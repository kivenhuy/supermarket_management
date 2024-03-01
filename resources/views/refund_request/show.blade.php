@extends('layouts.app')

@section('content')
    <!-- Order id -->
    <div class="aiz-titlebar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6" style="display: flex">
                <a style="display: flex;align-items: center;margin-right: 10px;margin-bottom: 0.5rem" href="{{route('refund_request.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
                <h1 class="fs-20 fw-700 text-dark">Refund Code: {{ $refund_request->code }}</h1>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="card rounded-0 shadow-none border mb-4">
        <div class="card-header border-bottom-0">
            <h5 class="fs-16 fw-700 text-dark mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">Order Code:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Customer:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Email:</td>
                            @if ($order->customer_id != null)
                                <td>{{ $order->user_detail->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Shipping address:</td>
                            <td>{{ json_decode($order->shipping_address)->address }},
                                {{ json_decode($order->shipping_address)->city }},
                                @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif
                                {{ json_decode($order->shipping_address)->postal_code }},
                                {{ json_decode($order->shipping_address)->country }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">Order date:</td>
                            <td>{{ date('d-m-Y H:i A', strtotime($order->order_date)) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Total price amount:</td>
                            <td> {{"đ ".number_format($order_detail->shipping_cost + $order_detail->price, 2, ',', '.')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Shipping method:</td>
                            <td> {{ $order->shipping_type }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Payment method:</td>
                            <td>{{ (ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>
                       
                        <tr>
                            <td class="w-50 fw-600">Payment Status:</td>
                            <td> 
                                @if($order_detail->payment_status != 'paid' )
                                    <span class='badge badge-inline badge-warning'>{{ ucfirst($order_detail->payment_status) }}</span> 
                                @else
                                    <span class='badge badge-inline badge-success'>{{ ucfirst($order_detail->payment_status) }}</span> 
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="w-50 fw-600">Shipping status:</td>
                            
                            <td><span class='badge badge-inline badge-danger' style="font-size: 14px">{{ (ucfirst(str_replace('_', ' ', $order_detail->delivery_status))) }}</span> </td>
                        </tr>
                    
                        <tr>
                            <td class="w-50 fw-600">Refund Reason:</td>
                            <td> {{ $refund_request->reason }}</td>
                        </tr>
                        
                        <tr>
                            <td class="w-50 fw-600">Refund Status:</td>
                            <td> 
                                @if($refund_request->status == 0 )
                                    <span class='badge badge-inline badge-danger'>Waiting For Approval </span> 
                                @elseif($refund_request->status == 1 )
                                    <span class='badge badge-inline badge-warning'>Waiting For Refund</span> 
                                @elseif($refund_request->status == 2 )
                                    <span class='badge badge-inline badge-success'>Refunded</span> 
                                    <p class="text-muted mb-2 fw-bold"><a href="{{($refund_request->img_refund)}}" target="_blank">Click to see Image Proof</a></p>
                                @else
                                    <span class='badge badge-inline badge-danger'>Request Rejected</span> 
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="row gutters-16">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-none border mt-2 mb-4">
                <div class="card-header border-bottom-0">
                    <h5 class="fs-16 fw-700 text-dark mb-0">Order Details</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class=" table">
                        <thead class="text-gray fs-12">
                            <tr>
                                <th class="pl-0">#</th>
                                <th width="20%">Product</th>
                                <th>Quantity</th>
                                <th>Shipping Date</th>
                                <th data-breakpoints="md">Delivery Type</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="fs-14">
                                <tr>
                                    <td class="pl-0">1</td>
                                    <td>
                                        @if ($order_detail->product_id != null)
                                            <span>{{ $order_detail->product_name}}</span>
                                        @else
                                            <strong>Product Unavailable</strong>
                                        @endif
                                    </td>
                                  
                                    <td>
                                        {{ $order_detail->quantity }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($order_detail->shipping_date)) }}
                                    </td>
                                    
                                    <td>
                                        {{ $order_detail->shipping_type }}
                                    </td>
                                    <td class="fw-700">{{ ($order_detail->each_price) }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters-16">
        <!-- Order Ammount -->
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <div class="card rounded-0 shadow-none border mt-2">
                <div class="card-header border-bottom-0">
                    <b class="fs-16 fw-700 text-dark">Order Ammount</b>
                </div>
                <div class="card-body pb-0">
                    <table class="table-borderless table">
                        <tbody>
                            <tr>
                                <td class="w-50 fw-600">Subtotal</td>
                                <td class="text-right">
                                    <span class="strong-600">{{ $order_detail->each_price }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">Shipping</td>
                                <td class="text-right">
                                    <span class="text-italic">{{"đ ".number_format($order_detail->shipping_cost, 2, ',', '.')}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">Total</td>
                                <td class="text-right">
                                    <strong>{{"đ ".number_format($order_detail->shipping_cost + $order_detail->price, 2, ',', '.')}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <style>
        #modal-size {
            position:fixed !important;
            left:0 !important;
            right:0 !important;
            bottom:0 !important;
            top:0 !important;
            display:block !important; 
        }
    </style>
@endsection




