<div class="modal-header">
    <h5 class="modal-title h6">Refund Request</h5>
    <button type="button" class="close" data-dismiss="modal">
    </button>
</div>


    <!-- Add new review -->
    <form action="{{ route('purchase_history.store_refund_order') }}" method="POST" >
        @csrf
        <input type="hidden" name="order_detail_id" value="{{ $order_detail->id }}">
        <input type="hidden" name="price" value="{{ $order_detail->price }}">
        <input type="hidden" name="shipping_price" value="{{ $order_detail->shipping_cost }}">
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-md-3 col-from-label">Order Code</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="order_code"
                        placeholder="Product Name" value="{{$order->code}}" disabled>
                </div>
            </div>
           
            <div class="form-group row">
                <label class="col-md-3 col-from-label">Product</label>
                <div class="col-md-8">
                    <input type="text" class="form-control"
                        placeholder="Product Name" value="{{$order_detail->product_name}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Quantity</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" 
                        placeholder="Product Name" value="{{$order_detail->quantity}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Price</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        placeholder="Product Name" value="{{"đ ".number_format($order_detail->price, 2, ',', '.')}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Shipping Price</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        placeholder="Product Name" value="{{"đ ".number_format($order_detail->shipping_cost, 2, ',', '.')}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Total Price</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="total_price"
                        placeholder="Product Name" value="{{"đ ".number_format($order_detail->shipping_cost + $order_detail->price, 2, ',', '.')}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Delivery Status</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        value="{{ucfirst($order_detail->delivery_status)}}" disabled>
                </div>
            </div>
        
     @if($is_refund == 0)       
            <div class="form-group">
                <label class="opacity-60">Reason</label>
                <textarea class="form-control rounded-0" rows="4" name="reason" placeholder="Your reason" required></textarea>
            </div>

            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-sm btn-primary rounded-0">Submit Request</button>
        </div>
    @else
            {{-- <div class="form-group">
                <label class="opacity-60">Reason</label>
                <textarea class="form-control rounded-0" rows="4" name="reason" placeholder="Your reason')}}">{{$order_detail->refund_requets->reason}}</textarea>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Refund Code</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="order_code"
                        placeholder="Product Name" value="{{$order_detail->refund_requets->code}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">Refund Status</label>
                <div class="col-md-8">
                    @if($order_detail->refund_requets->status == 0 )
                        <input type="text" class="form-control" name="order_code"
                        placeholder="Product Name" value="Waiting For Approve" disabled>
                    @elseif($order_detail->refund_requets->status == 1 )
                        <input type="text" class="form-control" name="order_code"
                        placeholder="Product Name" value="Waiting For Refund" disabled>
                    @elseif($order_detail->refund_requets->status == 2 )
                        <input type="text" class="form-control" name="order_code"
                            placeholder="Product Name" value="Refunded" disabled>
                        <p class="text-muted mb-2 fw-bold"><a href="{{uploaded_asset($order_detail->refund_requets->img_proof)}}" target="_blank">Click to see Image Proof</a></p>
                    @else
                        <input type="text" class="form-control" name="order_code"
                        placeholder="Product Name" value="Request Rejected" disabled>
                    @endif
                    
                </div>
            </div>

        </div> --}}
    @endif
</form>
