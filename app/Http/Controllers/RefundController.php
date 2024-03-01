<?php

namespace App\Http\Controllers;

use Auth;
use Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/all_refund';
            $response = Http::post($signupApiUrl,['buyer_id'=>Auth::user()->ecom_user_id]);
            $data_response = (json_decode($response)->data);
        }
        catch(\Exception $exception) {
            
        }
        $request_data = $this->paginate($data_response);
        // dd($request_data);
        return view('refund_request.index_v2',compact('request_data'));
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,['path' => route('refund_request.index')], $options);
    }


    public function show($id)
    {

        $refund_request = [];
        $order_detail =[];
        $order = [];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/refund/detail/'.$id;
            $response = Http::get($signupApiUrl);
            $data_response = (json_decode($response)->data);
            // dd($data_response);
            if($data_response)
            {
                $refund_request = $data_response->refund_request;
                $order_detail = $data_response->order_detail;
                $order = $data_response->order;
            }
        }
        catch(\Exception $exception) {
            
        }

        // dd($refund_request);
        return view('refund_request.show',compact('refund_request','order_detail','order'));
    }
}
