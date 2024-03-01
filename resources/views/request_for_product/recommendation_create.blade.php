@extends('layouts.app')

@section('content')
    <div class="card">
        <form class="form-default" role="form" action="{{route('request_for_product.store')}}" method="POST">
            @csrf
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5>Create Request For Products </h5>
                </div>

            </div>
        

        <div class="card-body">
            <div class="form-group row">
                <input type="hidden" name="product_slug" value="{{$product->slug}}">
                <input type="hidden" name="shop_slug" value="{{$product->shop_slug}}">
                <input type="hidden" name="recommend" value="1">
                <label class="col-md-3 col-from-label">Product Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="product_name"
                        placeholder="Product Name') }}" value="{{$product->name}}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Order Quantity <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3" >
                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $quantity_request }}" min="{{ $product->min_qty }}" is_request="0" max="{{$product->product_stock->qty}}">
                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="plus" data-field="quantity">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <input type="text" class="form-control" name="unit"
                        value="KG" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Order Date <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <select class="form-control aiz-selectpicker" name="order_date" id="order_date" >
                        <option value="1">Every Day</option>
                        <option value="7">Each 7 Days</option>
                        <option value="14">Each 14 Days</option>
                        <option value="30">Each 30 Days</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Form Date <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input required="" type="datetime-local" class="form-control" name="from_date" id="from_date">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">To Date <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input required="" type="datetime-local" class="form-control" name="to_date" id="to_date">
                </div>
            </div>
        </div>

        <div class="card-footer" style="justify-content: flex-end !important">
            <button type="submit" class="btn btn-primary text-right">Send Request</button>
        </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    $('.aiz-plus-minus input').off('change').on('change', function() {
        var minValue = parseInt($(this).attr("min"));
        var maxValue = parseInt($(this).attr("max"));
        var valueCurrent = parseInt($(this).val());
        var is_request = parseInt($(this).attr("is_request"));
        if(is_request == 0)
        {
            name = $(this).attr("name");
            if (valueCurrent >= minValue) {
                $(this).siblings("[data-type='minus']").removeAttr("disabled");
            } 
            else {
                // AIZ.plugins.notify('danger',"Sorry, the minimum limit has been reached");
                $(this).val(minValue);
            }
            if (valueCurrent <= maxValue) {
                $(this).siblings("[data-type='plus']").removeAttr("disabled");
            } else {
                // AIZ.plugins.notify('danger',"Sorry, the maximum limit has been reached");
                // alert(("));
                $(this).val(maxValue);
            }

            // if (typeof getVariantPrice === "function") {
            //     getVariantPrice();
            // }
        }
        

    });

    $('.aiz-plus-minus button').off('click').on('click', function(e) {
                e.preventDefault();

                var fieldName = $(this).attr("data-field");
                var type = $(this).attr("data-type");
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == "minus") {
                        if (currentVal > input.attr("min")) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr("min")) {
                            $(this).attr("disabled", true);
                        }
                    } else if (type == "plus") {
                        if (currentVal < input.attr("max")) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr("max")) {
                            $(this).attr("disabled", true);
                        }
                    }

                } else {
                    input.val(0);
                }
            });
</script>
@endpush