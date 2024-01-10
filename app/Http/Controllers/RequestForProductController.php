<?php

namespace App\Http\Controllers;

use App\Imports\RequestImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class RequestForProductController extends Controller
{
    public function index()
    {
        return view('request_for_product.index');
    }

    public function importCSV_Request_For_Product(Request $request)
    {
        $data_return =Excel::toArray(new RequestImport(), $request->csvFile)[0];
        array_shift($data_return);
        
        $arr_data_import = [];
        foreach($data_return as $each_data)
        {
            // dd(Carbon::parse(($each_data[3])));
            $ldate = date('Ymd');
            $current_timestamp = Carbon::now()->timestamp; 
            $code_rfq = $ldate.'-'.$current_timestamp;
            $start = Carbon::parse(($each_data[3]));
            $start_date = $start;
            $end =  Carbon::parse(($each_data[4]));
            $days = $end->diffInDays($start);
            switch ($each_data[5]) {
            case "7 days":
                $order_date = 7;
                break;
            case "14 days":
                $order_date = 14;
                break;
            case "30 days":
                $order_date = 30;
                break;
            default:
                $order_date = 1;
            }
            $distance_between_date = intdiv($days,(int)$order_date);
            $arr_shipping_date = [];
            array_push($arr_shipping_date,$start->format('m/d/Y'));
            for($i = 0;$i <= $distance_between_date-1;$i++)
            {
                $start_date = $start_date->addDay((int)$order_date);
                array_push($arr_shipping_date,$start_date->format('m/d/Y'));
            }
            $data_request = [
                'product_id'=>0,
                'code'=>$code_rfq,
                'product_name'=>trim($each_data[0]),
                'shop_id'=>0,
                'buyer_id'=>Auth::user()->ecom_user_id,
                
                'from_date'=>date(Carbon::parse($each_data[3])),
                'to_date'=> date(Carbon::parse($each_data[4])),
                'shipping_date'=>json_encode($arr_shipping_date),
                'distance_between_shipping_date' =>(int)$request->order_date,
                'quantity'=>$each_data[1],
                'unit'=>$each_data[2],
                'price'=>0,
                'status'=>0,
            ];
            array_push($arr_data_import,$data_request);
        }
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/send_request/store';
            $response = Http::post($signupApiUrl,['data'=>$arr_data_import]);
        }
        catch(\Exception $exception) {
            
        }
        return back()->with(['success' => 'Import request succesfully']);
    }

    public function dtajax(Request $request)
    {
        $data_response = [];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/send_request/get_all';
            $response = Http::post($signupApiUrl,['buyer_id'=>Auth::user()->ecom_user_id]);
            $data_response = (json_decode($response)->data);
        }
        catch(\Exception $exception) {
            
        }
        $out =  DataTables::of($data_response)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            if(($data->data[$i]->seller_name) !==  "")
            {
                $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            }
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }

    public function get_details_data($id)
    {
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/send_request/get_detail/'.$id; 
            $response = Http::get($signupApiUrl,  [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            $data_response = (json_decode($response)->data);
        }
        catch(\Exception $exception) {
            
        }
        if(!isset($data_response))
        {
            $product = null;
            $seller = null;
            $buyer = null;
            $data_request = null;
        }
        else
        {
            $product = $data_response->product;
            $seller = $data_response->seller;
            $buyer = $data_response->buyer;
            $data_request = $data_response->data_request;
        }
        return view('request_for_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
    }

    public function approve_price(Request $request)  
    {
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/send_request/add_product_to_cart'; 
            $response = Http::post($signupApiUrl,['id_rfp'=>$request->id_rfp]);
            $data_response = (json_decode($response)->data);
            if($data_response)
            {
                return true;
            }
            
        }
        catch(\Exception $exception) {
            
        }
        return false;
    }

    public function reject_price(Request $request)  
    {
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/send_request/reject_price'; 
            $response = Http::post($signupApiUrl,['id_rfp'=>$request->id_rfp]);
            $data_response = (json_decode($response)->data);
            if($data_response)
            {
                return true;
            }
            
        }
        catch(\Exception $exception) {
            
        }
        return false;
    }

}
