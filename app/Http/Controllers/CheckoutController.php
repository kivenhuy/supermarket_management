<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Auth;
use Http;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function update_shipping_fee(Request $request)
    {
        $arr_data=[
            'address_id'=>$request->address_id,
            'ecom_id'=>Auth::user()->ecom_user_id,
        ];
        // dd($arr_data);
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/update_shipping_fee';
            $response = Http::post($signupApiUrl,['data'=>$arr_data]);
            // dd(json_decode($response));
           
        }
        catch(\Exception $exception) {
            
        }
    }

    public function update_select_item(Request $request)
    {
        $total = 0;
        $disabled = 0;
        if((int)$request->type === 1)
        {
            $arr_data=[
                'data_address'=>$request->data_address,
                'type'=>$request->type,
                'active'=>$request->active,
                'ecom_id'=>Auth::user()->ecom_user_id
            ];
        }
        else
        {
            $arr_data=[
                'data_address'=>$request->data_address,
                'type'=>$request->type,
                'active'=>$request->active,
                'ecom_id'=>Auth::user()->ecom_user_id,
                'cart_id'=>$request->cart_id,
            ];
        }
        // dd($arr_data);
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/update_select_item';
            $response = Http::post($signupApiUrl,['data'=>$arr_data]);
            // dd(json_decode($response));
            $data_response = (json_decode($response)->data);
            $total = $data_response->total;
            $disabled = $data_response->disabled;
        }
        catch(\Exception $exception) {
            
        }
        if($total != 0)
        {
            $disabled = 1;
        }
        return ['total'=>$total,'disabled'=>$disabled];
    }

    public function cart()
    {
        $ecom_id = Auth::user()->ecom_user_id;
        
        $carts = [];       
        $address = [];       
        $total = 0;       
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/get_cart/'.$ecom_id; 
            $response = Http::get($signupApiUrl,  [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            $data_response = (json_decode($response)->data);
            $address = $data_response->address;
            $carts = $data_response->carts;
            $total = $data_response->total;
            // dd($total);
            // dd(($carts));
        }
        catch(\Exception $exception) {
            
        }
        return view('cart.cart_view', compact('carts','address','total'));
    }

    public function final_checkout()
    {
        $ecom_id = Auth::user()->ecom_user_id;
        $carts_normal = [];       
        $carts_short_shelf_life = [];       
        $seller_products_normal = [];       
        $seller_products_short = [];       
        $carrier_list = [];     
        $discount = 0;     
        // try
        // {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/final/'.$ecom_id; 
            $response = Http::get($signupApiUrl,  [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            $carts_normal = $data_response->carts_normal;       
            $carts_short_shelf_life = $data_response->carts_short_shelf_life;        
            $seller_products_normal = $data_response->seller_products_normal;          
            $seller_products_short = $data_response->seller_products_short;           
            $carrier_list = $data_response->carrier_list;      
            $total_normal_product = $data_response->total_normal_product;      
            $total_short_product = $data_response->total_short_product;      
            $final_price = $data_response->final_price;      
            $final_price_normal = $data_response->final_price_normal;      
            // }
        // catch(\Exception $exception) {
            
        // }
        return view('checkout.payment_select', compact('final_price','final_price_normal','total_normal_product','total_short_product','discount','carts_normal','carts_short_shelf_life','seller_products_normal','seller_products_short','carrier_list'));
    }

    public function update_total_shipping_fee(Request $request)
    {
        $total_price = 0;
        $shipping_price = 0;
        $arr_data = [
            'total_shipping'=>$request->total_shipping,
            'final_price'=>$request->final_price,
            'data_id_seller'=>$request->data_id_seller,
            'shipping_type'=>$request->shipping_type,
            'type_cart'=>$request->type_cart,
            'ecom_id'=>Auth::user()->ecom_user_id
        ];
        // try
        // {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/update_total_shipping_fee';
            $response = Http::post($signupApiUrl,['data'=>$arr_data]);
            // dd($response->body());
            $data_response = (json_decode($response)->data);
            
            $total_price = $data_response->total_price;
            $shipping_price = $data_response->shipping_price;
            // dd($response->body());
            // dd(json_decode($response));
            
        // }
        // catch(\Exception $exception) {
            
        // }
        return [
            'total_price' =>$total_price,
            'shipping_price'=>  $shipping_price,
        ];
    }

    public function checkout(Request $request)
    {  
        $first_order = [];
        $combined_order_price = "đ 0";
        $all_order = [];
        $arr_order_details = [];
        $photo_url = $this->upload_photo($request->photo,Auth::user()->id);
        $arr_data = [
            'payment_option'=>$request->payment_option,
            'ecom_id'=>Auth::user()->ecom_user_id,
            'photo_url'=>$photo_url,
            'trx_id'=>$request->trx_id,
        ];
        // dd($arr_data);
         // try
        // {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/checkout_supermarket/checkout';
            $response = Http::post($signupApiUrl,['data'=>$arr_data]);
            // dd($response->body());
            // dd($response->body());
            $data_response = (json_decode($response));
            if($data_response->result)
            {
                $first_order = $data_response->data->first_order;
                $combined_order_price = $data_response->data->combined_order_price;
                $all_order = $data_response->data->all_order;
                $arr_order_details = $data_response->data->arr_order_details;
            }
            // $total_price = $data_response->total_price;
            // $shipping_price = $data_response->shipping_price;
            // dd($response->body());
            // dd(json_decode($response));
            
        // }
        // catch(\Exception $exception) {
            
        // }
        $arr_order_details = (json_decode(json_encode($arr_order_details), true));
        return view('checkout.order_confirmed', compact(
            'first_order',
            'combined_order_price',
            'all_order',
            'arr_order_details',
        ));
    }

    public function order_confirmed()
    {
       
    }

    public function upload_photo($file,$user_id)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if (!empty($file)) {
            $upload = new Uploads();
            $extension = strtolower($file->getClientOriginalExtension());

            // if (
            //     env('DEMO_MODE') == 'On' &&
            //     isset($type[$extension]) &&
            //     $type[$extension] == 'archive'
            // ) {
            //     return '{}';
            // }

            if (isset($type[$extension])) {
                $upload->file_original_name = null;
                $arr = explode('.', $file->getClientOriginalName());
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= "." . $arr[$i];
                    }
                }


                $path = $file->store('assets/image_uploads', 'public');

                // dd($path);
                $size = $file->getSize();

                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = $user_id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                // dd($upload);
                $upload->save();
                return $upload->file_name;
            }
        }
    }
}
