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

    public function refund_order(Request $request){
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/refund_request'; 
            $response = Http::post($signupApiUrl,
            [
                'order_details_id'=>$request->order_details_id
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            if(isset($data_response))
            {
                $order_detail = $data_response->order_detail;
                $is_refund = (int)$data_response->is_refund;
                $order = $data_response->order;
            }
        }
        catch(\Exception $exception) {
            
        }
        // dd($order_detail);
        return view('purchase_history.refund_request', compact('order_detail','is_refund','order'));
    }


    public function store_refund_order(Request $request){
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/purchase_history/store_refund_order'; 
            // $arr_refund = [
            //     'code' => date('Ymd-His') . rand(10, 99),
            //     'order_detail_id' => $request->order_detail_id,
            //     'buyer_id' => Auth::user()->ecom_user_id,
            //     'price' => $request->price,
            //     'shipping_price' => $request->shipping_price,
            //     'reason' => $request->reason,
            //     'status' => 0,
            // ];
            $response = Http::post($signupApiUrl,
            [
                'code' => date('Ymd-His') . rand(10, 99),
                'order_detail_id' => $request->order_detail_id,
                'buyer_id' => Auth::user()->ecom_user_id,
                'price' => $request->price,
                'shipping_price' => $request->shipping_price,
                'reason' => $request->reason,
                'status' => 0,
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->status);
            if(($data_response))
            {
                $notification = array(
                    'message' => 'Refund request inserted successfully',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $notification = array(
                    'message' => 'Refund request inserted fail',
                    'alert-type' => 'error'
                );
            }
        }
        catch(\Exception $exception) {
            
        }
        // dd($order_detail);->with($notification)
        return redirect()->route('refund_request.index')->with($notification);
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
