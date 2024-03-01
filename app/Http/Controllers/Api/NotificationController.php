<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RefundRequest;
use App\Notifications\RequestForProduct;
use App\Notifications\Shipping;
use Illuminate\Http\Request;
use Notification;

class NotificationController extends Controller
{
    public function supermarket_notification(Request $request)
    {
        
        $user = User::where('ecom_user_id',(int)$request->user_id)->first();
        
        if($request->type == "request_for_product")
        {   
           
            $data_notic =
            [
                'request_code'=>$request->request_code,
                'request_id'=>$request->request_id,
                'status'=>$request->status,
                'type'=>"request_for_product",
            ];
            
            Notification::send($user, new RequestForProduct($data_notic));
        }
        if($request->type == "refund")
        {
            $data_notic =
            [
                'request_code'=>$request->request_code,
                'request_id'=>$request->request_id,
                'status'=>$request->status,
                'type'=>"refund",
            ];
            // dd($data_notic);
            Notification::send($user, new RefundRequest($data_notic));
        }

        if($request->type == "shipping")
        {
            $data_notic =
            [
                'order_detail_id'=>$request->order_detail_id,
                'shipper_name'=>$request->shipper_name,
                'status'=>$request->status,
                'type'=>"shipping",
            ];
            // dd($data_notic);
            Notification::send($user, new Shipping($data_notic));
        }
       
    }
}
