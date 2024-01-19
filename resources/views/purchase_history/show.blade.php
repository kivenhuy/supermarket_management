@extends('layouts.app')

@section('content')
    <!-- Order id -->
    <div class="aiz-titlebar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="fs-20 fw-700 text-dark">Order id: {{ $order->code }}</h1>
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
                            <td class="w-50 fw-600">Order status:</td>
                            <td>{{ (ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">Total order amount:</td>
                            <td>{{ $order->all_amount }}
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
                       
                       
                    </table>
                </div>
                <div class="row gutters-5">
                    <div class="col text-md-left text-center">
                        @if (is_array(json_decode($order->manual_payment_data, true)))
                            {{-- <div class="form-group text-left">
                                <button type="button" 
                                id="btn_image"
                                class="btn btn-primary">Showing Receipt</button>
                            </div> --}}
                           
                            <div id="hide_image" hidden="true">
                                @foreach($order->img_url as $data_image)
                                    <input type="hidden" value="{{$data_image}}">
                                    <a href="{{url('public/'.$data_image)}}" target="_blank">
                                        <img src="{{url('public/'.$data_image)}}" alt=""
                                            height="100">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
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
                                <th data-breakpoints="md" class="text-right pr-0">Review</th>
                            </tr>
                        </thead>
                        <tbody class="fs-14">
                            @foreach ($order_details as $key => $orderDetail)
                                <tr>
                                    <td class="pl-0">{{ sprintf('%02d', $key+1) }}</td>
                                    <td>
                                        @if ($orderDetail->product_id != null)
                                            <span>{{ $orderDetail->product_name}}</span>
                                        @else
                                            <strong>Product Unavailable</strong>
                                        @endif
                                    </td>
                                   
                                    <td>
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($orderDetail->shipping_date)) }}
                                    </td>
                                    
                                    <td>
                                        {{ $orderDetail->shipping_type }}
                                    </td>
                                    <td class="fw-700">{{ ($orderDetail->each_price) }}</td>
                                    
                                    <td class="text-xl-right pr-0">
                                        @if ($orderDetail->delivery_status === 'delivered')
                                            <a href="javascript:void(0);"
                                                onclick="product_review('{{ $orderDetail->product_id }}')"
                                                class="btn btn-primary btn-sm rounded-0"> Review </a>
                                        @else
                                            <span class="text-danger">Not Delivered Yet</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
                                    <span class="strong-600">{{ $order->amount_price }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">Shipping</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ ($order->all_shipping_price) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">Total</td>
                                <td class="text-right">
                                    <strong>{{ ($order->all_amount) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

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




@push('scripts')
    <script type="text/javascript">
        
        function product_review(product_id) {
            $.post('{{ route('product_review_modal') }}', {
                _token:'{{ csrf_token() }}',
                product_id: product_id
            }, function(data) {
                $('#product-review-modal-content').html(data);
                $('#product-review-modal').modal('show', {
                    backdrop: 'static'
                });
                $(".rating-input").each(function() {
                    $(this)
                        .find("label")
                        .on({
                            mouseover: function(event) {
                                $(this).find("i").addClass("hover");
                                $(this).prevAll().find("i").addClass("hover");
                            },
                            mouseleave: function(event) {
                                $(this).find("i").removeClass("hover");
                                $(this).prevAll().find("i").removeClass("hover");
                            },
                            click: function(event) {
                                $(this).siblings().find("i").removeClass("active");
                                $(this).find("i").addClass("active");
                                $(this).prevAll().find("i").addClass("active");
                            },
                        });
                    if ($(this).find("input").is(":checked")) {
                        $(this)
                            .find("label")
                            .siblings()
                            .find("i")
                            .removeClass("active");
                        $(this)
                            .find("input:checked")
                            .closest("label")
                            .find("i")
                            .addClass("active");
                        $(this)
                            .find("input:checked")
                            .closest("label")
                            .prevAll()
                            .find("i")
                            .addClass("active");
                    }
                });
            });
        }
    </script>
@endpush