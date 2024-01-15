<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        return view('purchase_history.index');
    }

    

    public function dtajax(Request $request)
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
        $out =  DataTables::of($data_response)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            
            $output .= ' <a href="'.url(route('purchase_history.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            // $data->data[$i]->grand_total = single_price($data->data[$i]->grand_total);
            $data->data[$i]->delivery_status = (ucfirst($data->data[$i]->delivery_status));
            $data->data[$i]->payment_status = (ucfirst($data->data[$i]->payment_status));
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }

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
        
        // dd($order_details);
        return view('purchase_history.show',compact('order','order_details'));
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
