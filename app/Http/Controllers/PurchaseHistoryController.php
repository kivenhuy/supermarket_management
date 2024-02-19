<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isEmpty;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        $data_response = [];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/get_all';
            $response = Http::post($signupApiUrl,['buyer_id'=>Auth::user()->ecom_user_id]);
            $data_response = (json_decode($response)->data);
        }
        catch(\Exception $exception) {
            
        }
        $request_data = $this->paginate($data_response);
        // dd($request_data);
        return view('purchase_history.index_v2',compact('request_data'));
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,['path' => route('request_for_product.index')], $options);
    }

    // public function dtajax(Request $request)
    // {
    //     $data_response = [];
    //     try
    //     {
    //         $upsteamUrl = env('ECOM_URL');
    //         $signupApiUrl = $upsteamUrl . '/purchase_history/get_all';
    //         $response = Http::post($signupApiUrl,['buyer_id'=>Auth::user()->ecom_user_id]);
    //         $data_response = (json_decode($response)->data);
    //     }
    //     catch(\Exception $exception) {
            
    //     }
    //     $out =  DataTables::of($data_response)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         $output = '';
            
    //         $output .= ' <a href="'.url(route('purchase_history.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         // $data->data[$i]->grand_total = single_price($data->data[$i]->grand_total);
    //         $data->data[$i]->delivery_status = (ucfirst($data->data[$i]->delivery_status));
    //         $data->data[$i]->payment_status = (ucfirst($data->data[$i]->payment_status));
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }

    public function get_details_data($id)
    {
        
        $order = [];
        $order_details = [];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/get_detail/'.$id; 
            $response = Http::get($signupApiUrl,  [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            if(isset($data_response))
            {
                $order = $data_response->order;
                $order_details = $data_response->order_details;
            }
        }
        catch(\Exception $exception) {
            
        }
        
        // dd(($order_details[1]->ship_his));
        return view('purchase_history.show',compact('order','order_details'));
    }

    public function shipping_history(Request $request){
        $shipping_history = [];
        $order = [];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/shipping_history'; 
            $response = Http::post($signupApiUrl,
            [
                'order_detail_id'=>$request->order_detail_id,
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            if(isset($data_response))
            {
                $shipping_history = $data_response->shipping_history;
                $order = $data_response->order;
            }
        }
        catch(\Exception $exception) {
            
        }
        // dd($shipping_history);
        return view('purchase_history.shipping_history', compact('shipping_history','order'));
    }



    public function product_review_modal(Request $request){
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/product_review_modal'; 
            $response = Http::post($signupApiUrl,
            [
                'product_id'=>$request->product_id,
                'ecom_id'=>Auth::user()->ecom_user_id
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            if(isset($data_response))
            {
                $product = $data_response->product;
                $review = $data_response->review;
            }
        }
        catch(\Exception $exception) {
            
        }
        return view('purchase_history.product_review_modal', compact('product','review'));
    }
   

    public function store(Request $request)
    {
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/product_review_modal/store'; 
            $response = Http::post($signupApiUrl,
            [
                'product_id'=>$request->product_id,
                'rating'=>$request->rating,
                'comment'=>$request->comment,
                'user_id'=>Auth::user()->ecom_user_id,
            ]);
            // dd($response->body());
            // $data_response = (json_decode($response)->data);
            // if(isset($data_response))
            // {
            //     $product = $data_response->product;
            //     $review = $data_response->review;
            // }
        }
        catch(\Exception $exception) {
            
        }
        return back()->with(['success' => 'Update Review Successfully']);
    }

}
