<div class="modal-header">
    <h5 class="modal-title h6">Shipping History</h5>
    {{-- <button type="button" class="close" data-dismiss="modal">
    </button> --}}
</div>


<div class="modal-body">
   
    <section class="py-5">
        <ul class="timeline-with-icons">
            @foreach($shipping_history as $each_shipping_history)
                @if($each_shipping_history->status == "receive_order")
                    <li class=" mb-5">
                        <span class="timeline-icon">
                        <i class="fas fa-user-check"></i>
                        </span>
                
                        <h5 class="fw-bold">Shipper Recive Order</h5>
                        <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                        <p class="text-muted">
                        
                                
                                    Order code:
                                    {{ $order->code }}
                                    has been 
                                    {{  (str_replace('_', ' ', $each_shipping_history->status)) }}
                                    by shipper {{ $each_shipping_history->shipper_name }}
                                
                            
                        </p>
                    </li>
                    @elseif($each_shipping_history->status == "order_picking")
                        <li class=" mb-5">
                            <span class="timeline-icon">
                                <i class="fa-solid fa-box"></i>
                            </span>
                    
                            <h5 class="fw-bold">Shipper Take Order From Shop</h5>
                            <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                            <p class="text-muted">
                                Shipper {{ $each_shipping_history->shipper_name }} doing order picking
                                        Order code: {{ $order->code }}
                            </p>
                        </li>
                    @elseif($each_shipping_history->status == "shipping")
                    <li class="mb-5">
                        <span class="timeline-icon">
                            <i class="fa-solid fa-truck-fast"></i>
                        </span>
                
                        <h5 class="fw-bold">Shipper Is Delivering Order To You</h5>
                        <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                        <p class="text-muted">
                            Shipper {{ $each_shipping_history->shipper_name }} is on the way to deliver
                                    Order code: {{ $order->code }}
                                
                        </p>
                    </li>
                    @elseif($each_shipping_history->status == "delivered")
                    <li class=" mb-5">
                        <span class="timeline-icon">
                            <i class="fa-solid fa-square-check"></i>
                        </span>
                
                        <h5 class="fw-bold">Shipper Is Delivered Order</h5>
                        <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                        <p class="text-muted mb-2 fw-bold"><a href="{{$each_shipping_history->photo}}" target="_blank">Click to see Image Proof</a></p>
                        <p class="text-muted">
                            Shipper {{ $each_shipping_history->shipper_name }} delivered successfully Order code: {{ $order->code }}
                        </p>
                    </li>
                    @elseif($each_shipping_history->status == "fail")
                        <li class=" mb-5">
                            <span class="timeline-icon">
                                <i class="fa fa-exclamation-triangle"></i>
                            </span>
                    
                            <h5 class="fw-bold">Order Status Is Failed</h5>
                            <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                            <p class="text-muted">
                                @if($each_shipping_history->shipper_name != "")
                                    Shipper {{ $each_shipping_history->shipper_name }} failed delivery because the time was  not meet standards
                                @else
                                    Delivery time was not meet standards because there is no shipper to receive orders
                                @endif
                                
                            </p>
                        </li>
                    @endif
            @endforeach
        </ul>
      </section>
</div>

    