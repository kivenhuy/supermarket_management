@extends('layouts.app')
@section('content')
    <!-- Order Confirmation -->
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <!-- Order Confirmation Text-->
                    <div class="text-center py-4 mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" class=" mb-3">
                            <g id="Group_23983" data-name="Group 23983" transform="translate(-978 -481)">
                              <circle id="Ellipse_44" data-name="Ellipse 44" cx="18" cy="18" r="18" transform="translate(978 481)" fill="#85b567"/>
                              <g id="Group_23982" data-name="Group 23982" transform="translate(32.439 8.975)">
                                <rect id="Rectangle_18135" data-name="Rectangle 18135" width="11" height="3" rx="1.5" transform="translate(955.43 487.707) rotate(45)" fill="#fff"/>
                                <rect id="Rectangle_18136" data-name="Rectangle 18136" width="3" height="18" rx="1.5" transform="translate(971.692 482.757) rotate(45)" fill="#fff"/>
                              </g>
                            </g>
                        </svg>
                        <h1 class="mb-2 fs-28 fw-500 text-success">Thank You for Your Order!</h1>
                        {{-- <p class="fs-13 ">{{  translate('A copy or your order summary has been sent to') }} <strong>{{ json_decode($first_order->shipping_address)->email }}</strong></p> --}}
                    </div>
                    <!-- Order Summary -->
                    <div class="mb-4 bg-white p-4 border">
                        <h5 class="fw-600 mb-3 fs-16  pb-2 border-bottom">Order Summary</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table fs-14 ">
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 pl-0 py-2">'Order date:</td>
                                        <td class="border-top-0 py-2">{{ date('d-m-Y H:i A', strtotime($first_order->order_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 pl-0 py-2">'Name:</td>
                                        <td class="border-top-0 py-2">{{ json_decode($first_order->shipping_address)->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 pl-0 py-2">'Email:</td>
                                        <td class="border-top-0 py-2">{{ json_decode($first_order->shipping_address)->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 pl-0 py-2">'Shipping address:</td>
                                        <td class="border-top-0 py-2">{{ json_decode($first_order->shipping_address)->address }}, {{ json_decode($first_order->shipping_address)->city }}, {{ json_decode($first_order->shipping_address)->country }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">'Order status:</td>
                                        <td class="border-top-0 pr-0 py-2">{{ucfirst(str_replace('_', ' ', $first_order->delivery_status)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">'Total order amount:</td>
                                        <td class="border-top-0 pr-0 py-2">{{$combined_order_price}}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">'Shipping:</td>
                                        <td class="border-top-0 pr-0 py-2"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">'Payment method:</td>
                                        <td class="border-top-0 pr-0 py-2">{{ucfirst(str_replace('_', ' ', $first_order->payment_type))}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Info -->
                    @foreach ($all_order as $order)
                        <div class="card shadow-none border rounded-0">
                            <div class="card-body">
                                <!-- Order Code -->
                                <div class="text-center py-1 mb-4">
                                    <h2 class="h5 fs-20">Order Code: <span class="fw-700 text-primary">{{ $order->code }}</span></h2>
                                </div>
                                <!-- Order Details -->
                                <div>
                                    <h5 class="fw-600  mb-3 fs-16 pb-2">'Order Details</h5>
                                    <!-- Product Details -->
                                    <div>
                                        <table class="table table-responsive-md  fs-14">
                                            <thead>
                                                <tr>
                                                    <th class="opacity-60 border-top-0 pl-0">#</th>
                                                    <th class="opacity-60 border-top-0" width="20%">'Product</th>
                                                    <th class="opacity-60 border-top-0">'Shipping Date</th>
                                                    <th class="opacity-60 border-top-0">'Quantity</th>
                                                    <th class="opacity-60 border-top-0">'Delivery Type</th>
                                                    <th class="text-right opacity-60 border-top-0 pr-0">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($arr_order_details[$order->id] as $key => $orderDetail)
                                                    <tr>
                                                        <td class="border-top-0 border-bottom pl-0">{{ $key+1 }}</td>
                                                        <td class="border-top-0 border-bottom">
                                                            
                                                                <a href="" target="_blank" class="text-reset">
                                                                    {{$orderDetail['product_name']}}
                                                                   
                                                                </a>
                                                            
                                                        </td>
                                                        <td class="border-top-0 border-bottom">
                                                            {{ $orderDetail['shipping_date'] }}
                                                        </td>
                                                        <td class="border-top-0 border-bottom">
                                                            {{ $orderDetail['quantity'] }}
                                                        </td>
                                                        <td class="border-top-0 border-bottom">
                                                            
                                                                {{ $order->shipping_type}}
                                                            
                                                        </td>
                                                        <td class="border-top-0 border-bottom pr-0 text-right">{{$orderDetail['each_price']}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Order Amounts -->
                                    <div class="row">
                                        <div class="col-xl-5 col-md-6 ml-auto mr-0">
                                            <table class="table ">
                                                <tbody>
                                                    <!-- Subtotal -->
                                                    <tr>
                                                        <th class="border-top-0 py-2">'Subtotal</th>
                                                        <td class="text-right border-top-0 pr-0 py-2">
                                                            <span class="fw-600">{{$order->amount_price}}</span>
                                                        </td>
                                                    </tr>
                                                    <!-- Shipping -->
                                                    <tr>
                                                        <th class="border-top-0 py-2">'Shipping</th>
                                                        <td class="text-right border-top-0 pr-0 py-2">
                                                            <span>{{$order->all_shipping_price}}</span>
                                                        </td>
                                                    </tr>
                                                   
                                                    <!-- Total -->
                                                    <tr>
                                                        <th class="py-2"><span class="fw-600">'Total</span></th>
                                                        <td class="text-right pr-0">
                                                            <strong><span>{{$order->all_amount}}</span></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection