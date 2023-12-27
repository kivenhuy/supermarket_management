<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Country;
use App\Models\FarmerDetails;
use App\Models\FarmLand;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function dashboard()
    {
        $array_data = [];
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
        }
        catch(\Exception $exception) {
            
        }
        return view('admin.dashboard',[
            'array_data'=>$array_data,
            'array_data_short_life'=>$array_data_short_life
        ]);
    }
}
