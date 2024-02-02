<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SeasonMasterController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FarmersController;
use App\Http\Controllers\Admin\CropMasterController;
use App\Http\Controllers\Admin\CropStageController;
use App\Http\Controllers\AjaxOptionsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CropVarietyController;
use App\Http\Controllers\FarmLandController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\RequestForProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return redirect('login');
});

Route::group(["prefix"=> ""], function () {
    Route::get("/login", [LoginController::class, 'showLoginForm'])->name('show_login_form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get("/logout", [LoginController::class, 'logout'])->name('logout');
});




Route::group(['middleware' => ['auth']], function () {
    Route::get('ajax-option-get-provinces', [AjaxOptionsController::class,'getProvinces'])->name('ajax_options.get-provinces');
    Route::get('ajax-option-get-districts', [AjaxOptionsController::class,'getDistricts'])->name('ajax_options.get-districts');
    Route::get('ajax-option-get-varieties', [AjaxOptionsController::class,'getVarieties'])->name('ajax_options.get-varieties');

    Route::get("/dashboard", [HomeController::class, 'dashboard'])->name('dashboard');

    //Country
    Route::get("/country", [CountryController::class, 'index'])->name('country.index');
    Route::get("/country/dtajax", [CountryController::class, 'dtajax'])->name('country.dtajax');
    Route::get("/country/create", [CountryController::class, 'create'])->name('country.create');
    Route::post("/add_country", [CountryController::class, 'store'])->name('country.store');


    //Province
    Route::get("/province", [ProvinceController::class, 'index'])->name('province.index');
    Route::get("/province/dtajax", [ProvinceController::class, 'dtajax'])->name('province.dtajax');
    Route::get("/province/create", [ProvinceController::class, 'create'])->name('province.create');
    Route::post("/add_province", [ProvinceController::class, 'store'])->name('province.store');
    Route::get("/province_filter_by_country/{id}", [ProvinceController::class, 'filter_by_country'])->name('province.filter_by_country');

    //District
    Route::get("/district", [DistrictController::class, 'index'])->name('district.index');
    Route::get("/district/dtajax", [DistrictController::class, 'dtajax'])->name('district.dtajax');
    Route::get("/district/create", [DistrictController::class, 'create'])->name('district.create');
    Route::post("/add_district", [DistrictController::class, 'store'])->name('district.store');
    Route::get("/district_filter_by_province/{id}", [DistrictController::class, 'filter_by_province'])->name('district.filter_by_province');

    //Commune
    Route::get("/commune", [CommuneController::class, 'index'])->name('commune.index');
    Route::get("/commune/dtajax", [CommuneController::class, 'dtajax'])->name('commune.dtajax');
    Route::get("/commune/create", [CommuneController::class, 'create'])->name('commune.create');
    Route::post("/add_commune", [CommuneController::class, 'store'])->name('commune.store');
    Route::get("/commnue_filter_by_district/{id}", [CommuneController::class, 'filter_by_district'])->name('commnue.filter_by_district');

    // Request For Product
    Route::get("/request_for_product", [RequestForProductController::class, 'index'])->name('request_for_product.index');
    Route::get("/request_for_product/dtajax", [RequestForProductController::class, 'dtajax'])->name('request_for_product.dtajax');
    Route::get("/request_for_product/get_details_data/{id}", [RequestForProductController::class, 'get_details_data'])->name('request_for_product.get_details_data');
    Route::get("/request_for_product/get_details_data/{id}", [RequestForProductController::class, 'get_details_data'])->name('request_for_product.get_details_data');
    Route::get("/request_for_product/destroy/{id}", [RequestForProductController::class, 'destroy'])->name('request_for_product.destroy');
    Route::post("/request_for_product/approve_price", [RequestForProductController::class, 'approve_price'])->name('request_for_product.approve_price');
    Route::post("/request_for_product/reject_price", [RequestForProductController::class, 'reject_price'])->name('request_for_product.reject_price');
    Route::post("/request_for_product/import-csv-request", [RequestForProductController::class, 'importCSV_Request_For_Product'])->name('import-csv-request');


    // Request For Product
    Route::get("/cart", [CheckoutController::class, 'cart'])->name('supermarket.cart');
    Route::get("/final_checkout", [CheckoutController::class, 'final_checkout'])->name('supermarket.checkout.final_checkout');
    Route::post("/update_selected_cart", [CheckoutController::class, 'update_select_item'])->name('supermarket.update_selected_cart');
    Route::post('/update_shipping_fee',[CheckoutController::class, 'update_shipping_fee'] )->name('supermarket.checkout.update_shipping_fee');
    Route::post('/update_total_shipping_fee',[CheckoutController::class, 'update_total_shipping_fee'] )->name('supermarket.checkout.update_total_shipping_fee');
    Route::post('/checkout',[CheckoutController::class, 'checkout'] )->name('supermarket.checkout');


    // Purchase History
    Route::get("/purchase_history", [PurchaseHistoryController::class, 'index'])->name('purchase_history.index');
    Route::get("/purchase_history/dtajax", [PurchaseHistoryController::class, 'dtajax'])->name('purchase_history.dtajax');
    Route::get("/purchase_history/get_details_data/{id}", [PurchaseHistoryController::class, 'get_details_data'])->name('purchase_history.get_details_data');
    Route::post("/purchase_history/product_review_modal", [PurchaseHistoryController::class, 'product_review_modal'])->name('product_review_modal');
    Route::post("/purchase_history/review/store", [PurchaseHistoryController::class, 'store'])->name('purchase_history.review.store');
    Route::post("/purchase_history/shipping_history", [PurchaseHistoryController::class, 'shipping_history'])->name('purchase_history.shipping_history');
    

    Route::get("/personal_information", [PersonalInformationController::class, 'index'])->name('personal_information.index');
    Route::post("/personal_information/update", [PersonalInformationController::class, 'update'])->name('personal_information.update');
});

