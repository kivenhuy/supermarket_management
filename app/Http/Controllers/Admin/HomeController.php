<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Country;
use App\Models\FarmerDetails;
use App\Models\FarmLand;
use App\Models\Staff;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
