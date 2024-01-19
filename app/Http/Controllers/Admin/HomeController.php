<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Country;
use App\Models\FarmerDetails;
use App\Models\FarmLand;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function dashboard()
    {
        $array_data = [];
        $array_data_short_life = [];
        $array_data_paddy = [];
        $array_data_seafood = [];
        $array_data_fresh_fruits = [];
        $all_order = [];
        $user_data = [];
        $address_data =[];
        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/suggest_for_supermarket'; 
            $response = Http::get($signupApiUrl,  [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            $data_response = (json_decode($response)->data);
            $array_data = $data_response->product;
            $array_data_short_life = $data_response->products_with_short_shelf_life;
            $array_data_paddy = $data_response->paddy_cate_products;
            $array_data_seafood = $data_response->seafood_cate_products;
            $array_data_fresh_fruits = $data_response->fresh_fruits_cate_products;
            $all_order = $data_response->all_order;
        }
        catch(\Exception $exception) {
            
        }

        try
        {
            $upsteamUrl = env('ECOM_URL');
            $signupApiUrl = $upsteamUrl . '/personal_supermarket_information/get_detail/'.Auth::user()->ecom_user_id;
            $response = Http::get($signupApiUrl);
            $data_response = (json_decode($response)->data);
            $user_data = $data_response->user_data;
            $address_data = $data_response->address_data;
        }
        catch(\Exception $exception) {
            
        }
        Session::put('user_data', $user_data);
        // dd($address_data);
        Session::put('address_data', $address_data);
        return view('admin.dashboard',[
            'array_data'=>$array_data,
            'array_data_short_life'=>$array_data_short_life,
            'array_data_paddy'=>$array_data_paddy,
            'array_data_seafood'=>$array_data_seafood,
            'array_data_fresh_fruits'=>$array_data_fresh_fruits,
            'all_order'=>$all_order,
        ]);
    }
}
