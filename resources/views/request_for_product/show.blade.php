@extends('layouts.app')

@section('content')

    <div class="card">
       
        <div class="card-body">
            <div class="form-group row">
                <div class="col-12 data_user">
                    <div class="form-group row" style="margin-bottom:1rem">
                        <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('request_for_product.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-arrow-left"></i></a>
                        <span class="rfp_code">
                            Request Code: {{$data_request->code}}
                        </span>
                    </div>

                    {{-- RFQ Details --}}
                    <div>
                        <table class="padding text-left small border-bottom" style="width: 100%">
                            <thead>
                                <tr class="gry-color" style="background: #F5F5F5;">
                                    <th width="40%" style="color:#000000; font-family:'Quicksand',sans-serif; font-size:16px; line-height:16px;">Product <br> <span style="font-family: 'Quicksand',sans-serif !important;font-size: 12px !important;
                                        font-weight: 500;
                                        line-height: 16px;
                                        letter-spacing: -0.0004em;
                                        text-align: left;
                                        ">Product Raised Date:{{$data_request->created_at}} </span></th>
                                    <th width="15%" style="color:#000000; font-family:'Quicksand',sans-serif; font-size:16px; line-height:16px;">Seller</th>
                                    <th width="15%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;">Quantity</th>
                                    <th width="15%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;">Quote Price</th>
                                    <th width="15%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;" >Status</th>
                                </tr>
                            </thead>
                            <tbody class="strong">
                                {{-- @foreach ($order->orderDetails as $key => $orderDetail) --}}
                                    @if (isset($data_request))
                                        <tr class="" style="height: auto">
                                            @if(!empty($product))
                                            <td style="padding-top:24px">
                                                <div style="display: flex;align-items: center">
                                                    <img src="{{ $product->img_url }}" width="115px" height="115px" alt="">
                                                    <div style="display: flex;flex-direction: column;padding-left: 16px;">
                                                        <span class="rfp_product_name" style="margin-bottom:6px;" >{{ $product->name }}</span>
                                                    </div>

                                                </div>  
                                            </td>
                                            @else
                                            <td style="padding-top:24px">
                                                <div style="display: flex;align-items: center">
                                                    <img src="" width="115px" height="115px" alt="">
                                                    <div style="display: flex;flex-direction: column;padding-left: 16px;">
                                                        <span class="rfp_product_name" style="margin-bottom:6px;" >{{ $data_request->product_name }}</span>
                                                    </div>

                                                </div>  
                                            </td>
                                            @endif
                                            @if(!empty($seller))
                                                <td><span class="rfp_product_name">{{ $seller->name }} </span></td>
                                            @else
                                                <td><span class="rfp_product_name"> </span></td>
                                            @endif
                                            <td><span class="rfp_product_name">{{$data_request->quantity}} x {{$data_request->unit}}</span></td>
                                            <td><span class="rfp_product_name">{{ $data_request->unit_price }}</span></td>
                                            <td>
                                                @if($data_request->status == 0)
                                                
                                                    <span class='badge badge-inline badge-secondary'>Pending Admin Approval</span>
                                                
                                                @elseif($data_request->status == 1)
                                                
                                                    <span class='badge badge-inline badge-warning'>Pending Seller Accept</span>
                                                
                                                @elseif($data_request->status == 1)
                                                
                                                    <span class='badge badge-inline badge-warning'>Pending Price Update</span>
                                                
                                                @elseif($data_request->status == 2)
                                                
                                                    <span class='badge badge-inline badge-info' >Price Update</span>
                                                
                                                @elseif($data_request->status == 3)
                                                    <span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>Added To Cart</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                 {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="addtional_info_shipping_schdule ">
                        <div class="head_addtional_info_buyer">
                            <span>Schedule For Shipping</span>
                        </div>
                        <div class="body_addtional_info_buyer col-12">
                            <div class="col-6">
                                <div class="sub_data_addition_info">
                                    <span class="title_addtional_info">Shipping Date</span>
                                    @foreach (json_decode($data_request->shipping_date) as $each_day)
                                        <div class="data_addtional_info">
                                            {{date('d-m-Y', strtotime($each_day))}}
                                        </div>
                                    @endforeach
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>

                    @if($data_request->status == 3)
                    <div class="parent_appprove_rfp">
                        <div class="text_approval">
                            This request has new price update from seller and waiting for your approval
                        </div>
                        <div style="margin-right: 10px">
                            <button id={{$data_request->id}} class="btn EdApprove btn-success btn-xs" style="width:100%;height:100%;display:inline;padding:2px 5px 3px 5px;">Approval</button>
                           
                        </div>
                        <div>
                            <button id={{$data_request->id}} class="btn EdOpenReject Reject btn-danger btn-xs" style="width:100%;height:100%;display:inline;padding:2px 5px 3px 5px;">Reject</button>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        


    </div>

    <style>
        .EdOpenReject
        {
            font-family: 'Roboto',sans-serif !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            line-height: 28px;
            letter-spacing: 0.25px;
            text-align: center;
            color: #FFFFFF;
        }
        .addtional_info_shipping_schdule
        {
            margin-top: 2rem;
            margin-left: 1rem;
            height: auto;
            max-width: 500px;
            border: 1px solid #D1D1D1;
            border-radius: 10px;
            padding: 0px 0px 0px 24px;
        }
        .head_addtional_info_buyer
        {
            height: auto;
            border-bottom: 1px solid #D1D1D1;
            font-family: 'Quicksand',sans-serif !important;
            font-size: 24px !important; 
            font-weight: 700 !important; 
            line-height: 32px;
            letter-spacing: -0.0004em;
            text-align: left;
            color: #253D4E;
            padding: 24px 0px 24px 0px;
        }
        .sub_data_addition_info
        {
            margin-bottom: 24px;
        }
        .title_addtional_info
        {
            font-family: 'Roboto',sans-serif !important;
            font-size: 16px;
            font-weight: 700;
            line-height: 20px;
            letter-spacing: -0.0004em;
            text-align: left;
            color: #333333;
        }
        .data_addtional_info
        {
            font-family: 'Roboto',sans-serif !important;
            font-size: 16px;
            font-weight: 400;
            line-height: 32px;
            letter-spacing: -0.0004em;
            text-align: left;
            color: #797979;
        }
        .body_addtional_info_buyer
        {
            display: flex;
            padding: 24px 0px 32px 0px;
        }
        .EdApprove
        {
            font-family: 'Roboto',sans-serif !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            line-height: 28px;
            letter-spacing: 0.25px;
            text-align: center;

        }
        .text_approval
        {
            font-family: 'Roboto',sans-serif !important;
            font-size: 14px;
            font-weight: 400;
            line-height: 28px;
            letter-spacing: 0.25px;
            text-align: left;
            color: #797979;
            margin-right: 1rem;
        }
        .parent_appprove_rfp
        {
            margin-top: 1rem;
            display: flex;
            align-items:center;
            height: auto;
        }
        .btn-primary
        {
            background-color: #0cc618 !important;
            border-color: #0cc618 !important;
            border-radius: 0px !important;
        }
        .btn-danger
        {
            border-radius: 0px !important;
        }
        .card .card-footer
        {
            justify-content: flex-end !important
        }
        .data_rfp
        {
            background-color: #F5F5F5;
        }
        .seller_data
        {
            background-color: #F5F5F5;
            margin-bottom: 2rem;
        }
        .buyer_data
        {
            background-color: #F5F5F5
        }
        .img_product
        {
            max-width: 300px;
            height: 300px;
        }
        #modal-size {
            position:fixed;
            left:0;
            right:0;
            bottom:0;
            top:0;
            display:block;
        }

        .modal-content {
            /* 80% of window height */
            height: 100% !important;
        }

        .modal-body {
            /* 100% = dialog height, 120px = header + footer */
            max-height: calc(100% - 120px) !important;
        }
    </style>
@endsection


@push('scripts')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" ></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" ></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}" ></script>
<script type="text/javascript">
$(document).ready(function()
{   
    $(document).on("click", ".EdApprove", function()
    {
        var serviceID = $(this).attr('id');
        if(serviceID != null )
        {
            $.ajax
            ({
                url: "{{route('request_for_product.approve_price')}}",
                method:'post',
                data:{
                    id_rfp:serviceID,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    location.reload();
                    notifySuccess('Product Added To Cart Successfully');
                }, 
                error: function(){
                    notifyDanger('Product Added To Cart Failed');
                }
            });
        }
    });

    $(document).on("click", ".Reject", function()
    {
        var serviceID = $(this).attr('id');
        if(serviceID != null )
        {
            $.ajax
            ({
                url: "{{route('request_for_product.reject_price')}}",
                method:'post',
                data:{
                    id_rfp:serviceID,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    location.reload();
                    notifySuccess('Reject Price Successfully');
                },
                error: function(){
                    notifyDanger('Reject Price Failed');
                }
            });
        }
    });

    function notifySuccess(message) {
        toastr.success(message);
    }
    function notifyDanger(message) {
        toastr.error(message);
    }
});
</script>
@endpush