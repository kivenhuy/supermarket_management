<div class="container" style="max-width:1200px !important;width:100%">
    
    @if( $carts && count($carts) > 0 )
    <div style="margin-bottom: 20px;">
        <span style="
            font-family: 'Quicksand',sans-serif !important;
            font-size: 40px;
            font-weight: 700;
            line-height: 48px;
            letter-spacing: -0.0004em;
            text-align: left;
            color:#2E7F25;
            ">Your Cart
        </span>
    </div>
    <div style="margin-bottom: 2rem">
        <span style="font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color:#797979;">Your have <span class="num_of_product">{{count($carts)}}</span> product in your cart</span>
    </div>
        <div class="row" id="cart-summary-2">
            <div class="col-xxl-8 col-xl-10 mx-auto">
                <div class=" bg-white p-3 p-lg-4 text-left">
                    <div class="mb-4">
                        <!-- Headers -->
                        <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table" >
                            <div class="col col-md-1 fw-600 text_cart_details"><input onchange = "Check_all(this)" type="checkbox"></div>
                            <div class="col-md-4 fw-600 text_cart_details" style="position: relative;left:32px">Product</div>
                            <div class="col col-md-1 fw-600 text_cart_details">Qty</div>
                            <div class="col fw-600 text_cart_details" style="display: flex;justify-content: center;">Unit</div>
                            {{--<div class="col fw-600">{{ translate('Tax')}}</div> --}}
                            <div class="col fw-600 text_cart_details" > Total</div>
                            <div class="col-auto fw-600 text_cart_details" style=" position: relative; right: 24px; "> Remove</div>
                        </div>
                        <!-- Cart Items -->
                        <ul class="list-group list-group-flush">
                           
                            @foreach ($carts as $key => $cartItem)
                                <li class="list-group-item px-0">
                                    <div class="row gutters-5 align-items-center">
                                        {{-- checkbxõ --}}
                                        <div class="col-md-1 ">
                                            {{-- @if($cartItem->is_checked ==1)
                                            <input onchange = "showHidePan(this)" class="check_box_child" type="checkbox" value="{{$cartItem->id}}" checked>
                                            @else --}}
                                            <input onchange = "showHidePan(this)" class="check_box_child" type="checkbox" value="{{$cartItem->id}}">
                                            {{-- @endif --}}
                                           
                                        </div>
                                        <!-- Product Image & name -->
                                        <div class="col-md-4 d-flex align-items-center mb-2 mb-md-0">
                                            <span class="mr-2 ml-0">
                                                <img src="{{$cartItem->img_product}}"
                                                    class="img-fit size-70px"
                                                    alt=""
                                                    onerror="this.onerror=null;this.src='';">
                                            </span>
                                            <span style="padding-left:10px" class="fs-14 text_name_product">{{ $cartItem->product_name }}</span>
                                        </div>
                                        <!-- Quantity -->
                                        <div class="col-md-2 col order-1 order-md-0">
                                           
                                                <div class="d-flex flex-column align-items-start aiz-plus-minus mr-2 ml-0">
                                                   
                                                   
                                                    <input type="number" name="quantity[{{ $cartItem->id }}]"
                                                        class="col border-0 text-left px-0 flex-grow-1 fs-14 input-number quantity_product"
                                                        placeholder="1" value="{{ $cartItem->quantity }}"
                                                        
                                                        style="padding-left:0.75rem !important;">
                                                    
                                                </div>
                                           
                                        </div>
                                        <!-- Price -->
                                        <div class="col-md col-4 order-2 order-md-0 my-3 my-md-0" style="max-width:80px !important">
                                            <span class="unit_product">KG</span>
                                        </div>
                                         {{--
                                        <!-- Tax -->
                                        <div class="col-md col-4 order-3 order-md-0 my-3 my-md-0">
                                            <span class="opacity-60 fs-12 d-block d-md-none">{{ translate('Tax')}}</span>
                                            <span class="fw-700 fs-14">{{ cart_product_tax($cartItem, $product) }}</span>
                                        </div> --}}
                                        <!-- Total -->
                                        <div class="col-md col-5 order-4 order-md-0 my-3 my-md-0">
                                            <span class="opacity-60 fs-12 d-block d-md-none">Total</span>
                                            <span class="fw-700 fs-16  total_product" style="color: #28a745 !important">{{ $cartItem->total_price }}</span>
                                        </div>
                                        <!-- Remove From Cart -->
                                        <div class="col-md-auto col-6 order-5 order-md-0 text-right">
                                            <a href="javascript:void(0)" onclick="" class="btn btn-icon btn-sm btn-soft-primary bg-soft-warning hov-bg-primary btn-circle">
                                                <i class="fa fa-trash fs-16"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div style="margin-top:40px;margin-bottom:16px;">
                    <i style="font-size: 24px;margin-right: 8px;" class="fa fa-map-marker" aria-hidden="true"><span class="shipping_info">Shipping Info</span></i>
                </div>
                <div style="height: 111px !important">
                    @empty($address)
                   
                    @else
                        @foreach($address as $data_address)
                            <div style="margin-bottom: 1rem;display: flex;align-items: center">
                                <input onclick="handleClick(this);" class="radio_button_checkout" type="radio" id="{{$data_address->id}}" name="address_info" value="{{$data_address->id}}" />
                                <span style="padding-left:10px" for="address_info" class="delivery_type">{{$data_address->full_adress}}</span>
                            </div>
                        @endforeach
                    @endempty
                    {{-- <button class="btn add_new_address" onclick="add_new_address()"><i class="fa fa-plus" aria-hidden="true"></i> New Address</button> --}}
                </div>
            </div>
            <div class="col-xxl-3 col-xl-10 mx-auto">
                <div class="border bg-white p-3 p-lg-4 text-left">
                    <div class="mb-4">
                        <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                            <span class="opacity-60 fs-14 price_product_cart_details">Subtotal</span>
                            <span class="fw-700 fs-16" id="total_price">{{$total}}</span>
                        </div>
                        <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                            <span class="opacity-60 fs-14 price_product_cart_details">Shpping</span>
                            <span class="fw-700 fs-16">đ 0</span>
                        </div>
                        <div class="px-0 py-2 mb-4 border-top d-flex justify-content-between" style="align-items:center">
                            <span class="opacity-60 fs-14 price_product_cart_details">Total</span>
                            <span class="fw-700 fs-16 final_price" id="total_price_2">{{ $total }}</span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center" style="background-color: #2E7F25">
                        <a id="myLink" href="{{ route('supermarket.checkout.final_checkout') }}" style="border:none;background-color: #2E7F25 !important" class="btn btn-primary fs-14 fw-700 rounded-0 px-4 disabled " >
                            Process To Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 text-center text-md-left order-1 order-md-0">
            <a href="{{ route('dashboard') }}" class="btn btn-link fs-14 fw-700 px-0" style="background-color: #2E7F25">
                <button class="btn return_to_shop" style="color: #FFFFFF">
                    <i class="fa fa-arrow-left fs-16"></i>
                    Return to Homepage
                </button>
            </a>
        </div>
    @else
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="border bg-white p-4">
                    <!-- Empty cart -->
                    <div class="text-center p-3">
                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        <h3 class="h4 fw-700">Your Cart is empty</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>



<script type="text/javascript">
   
  
    function showHidePan(myRadio) 
    {
        var cart_checked = myRadio.checked;
        var cart_id = myRadio.value;
        var active = 0;
        if(cart_checked == true)
        {
            active = 1;
        }
        $.ajax
                ({
                    url: "{{route('supermarket.update_selected_cart')}}",
                    method:'post',
                    data:{
                        cart_id:cart_id,
                        active:active,
                        type:0,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $('#total_price').html(data.total);
                        $('#total_price_2').html(data.total);
                        if(data.disabled == 0)
                        {
                            $('#myLink').addClass('disabled')
                        }
                        else
                        {
                            if ($('input[class=radio_button_checkout]:checked').length > 0) {
                                $('#myLink').removeClass('disabled')
                            }
                            else
                            {
                                AIZ.plugins.notify('danger', 'Please Select Address To Checkout');
                            }
                            
                        }
                    }, 
                    error: function(){
                        
                    }
                });

    }

    function Check_all(myRadio) 
    {
        var cart_checked = myRadio.checked;
        var active = 0;
        if(cart_checked)
        {
            $(".check_box_child").attr("checked", "true");
            active = 1;
        }
        else
        {
            $(".check_box_child").removeAttr('checked');
        }
        $.ajax
                ({
                    url: "{{route('supermarket.update_selected_cart')}}",
                    method:'post',
                    data:{
                        type:1,
                        active:active,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $('#total_price').html(data.total);
                        $('#total_price_2').html(data.total);
                        if(data.disabled == 0)
                        {
                            $('#myLink').addClass('disabled')
                        }
                        else
                        {
                            if ($('input[class=radio_button_checkout]:checked').length > 0) {
                                $('#myLink').removeClass('disabled')
                            }
                            else
                            {
                                AIZ.plugins.notify('danger', 'Please Select Address To Checkout');
                            }
                        }
                    }, 
                    error: function(){
                        
                    }
                });
    }

    function handleClick(myRadio) {
        var address_id = myRadio.value;
        // var id_radio = myRadio.id;
        // var final_price = $('#final_price').val();
        $.ajax
            ({
                url: "{{route('supermarket.checkout.update_shipping_fee')}}",
                method:'post',
                data:{
                    address_id:address_id,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    if ($('input[class=check_box_child]:checked').length > 0) {
                            $('#myLink').removeClass('disabled')
                        }
                }, 
                error: function(){
                    
                }
            });
    }
  

    
</script>
