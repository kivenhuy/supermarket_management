  <div class="container-xxl container-p-y">
    <div class="container p-0">
      <div class="row justify-content-between align-items-center">
         <!-- ! Not required for layout-without-menu -->
        @if(!isset($navbarHideToggle))
          <div class="col layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-block d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="mdi mdi-menu mdi-24px"></i>
            </a>
          </div>
        @endif
        <div class="col col-xl-12 d-flex justify-content-end">
          

        <!-- User -->
        <div class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar ">
              <span class="">
                <span class="position-relative d-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14.668" height="16"
                        viewBox="0 0 14.668 16">
                        <path id="_26._Notification" data-name="26. Notification"
                            d="M8.333,16A3.34,3.34,0,0,0,11,14.667H5.666A3.34,3.34,0,0,0,8.333,16ZM15.06,9.78a2.457,2.457,0,0,1-.727-1.747V6a6,6,0,1,0-12,0V8.033A2.457,2.457,0,0,1,1.606,9.78,2.083,2.083,0,0,0,3.08,13.333H13.586A2.083,2.083,0,0,0,15.06,9.78Z"
                            transform="translate(-0.999)" fill="#91919b" />
                    </svg>
                    @if (Auth::check() && count(Auth::user()->unreadNotifications)>0)
                        <span
                            class="badge badge-primary badge-inline badge-pill absolute-top-right--10px"
                            style="
                            display: -webkit-inline-box !important;
                            display: -ms-inline-flexbox !important;
                            display: inline-flex !important;
                            -webkit-box-pack: center !important;
                            -ms-flex-pack: center !important;
                            justify-content: center !important; 
                            -webkit-box-align: center !important;
                            -ms-flex-align: center !important;
                            align-items: center !important;
                            height: 24px !important;
                            width: 18px !important;
                            font-size: 0.65rem !important;
                            font-weight: 500 !important;
                            border-radius: 50% !important;
                            "
                        >{{count(Auth::user()->unreadNotifications)}}</span>
                    @endif
                </span>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" style="min-width: 17rem;">
            
            @forelse(Auth::user()->unreadNotifications as $notification)
            <li style="
            border-bottom: 1px solid;
            /* border-top: 1px solid; */
            padding: 5px 10px;">
              @if ($notification->type == 'App\Notifications\RefundRequest')
                  <a href="{{ route('refund_request.show', ($notification->data['request_id']))}}" class="dropdow-item text-secondary fs-14">
                      <span class="order_notification">
                          Your refund request for order have code: 
                          {{ $notification->data['request_code'] }}
                          @if($notification->data['status'] == 1)
                              has been approved by admin
                          @elseif($notification->data['status'] == 2)
                              has been refunded by admin
                          @else
                              has been rejected by admin
                          @endif
                          
                      </span>
                  </a>
              @elseif($notification->type == 'App\Notifications\RequestForProduct')
                  <a href="{{ route('request_for_product.get_details_data', ($notification->data['request_id']))}}" class="dropdow-item text-secondary fs-14">
                    <span class="order_notification">
                        Your request for product have code: 
                        {{ $notification->data['request_code'] }}
                        @if($notification->data['status'] == 1)
                            has been approved by admin
                        @elseif($notification->data['status'] == 2)
                            has been approved by seller
                        @elseif($notification->data['status'] == 90)
                            has been rejected by seller
                        @else
                            has been updated price
                        @endif
                        
                    </span>
                </a>
              @else
                  {{-- <a href="{{ route('purchase_history.get_details_data',($order->id))}}" 
                    class="text-secondary fs-14">
                    @if($notification->data['status'] == "receive_order")
                        <span class="order_notification">
                            Order code:
                            {{ $order->code }}
                            {{ 'has been ' . (str_replace('_', ' ', $notification->data['status'])) }}
                            by shipper {{ $notification->data['shipper_name'] }}
                        </span>
                    @elseif($notification->data['status'] == "order_picking")
                        <span class="order_notification">
                            Shipper {{ $notification->data['shipper_name'] }} doing order picking
                           
                        </span>
                    @elseif($notification->data['status'] == "shipping")
                        <span class="order_notification">
                            Shipper {{ $notification->data['shipper_name'] }} is on the way to deliver
                        </span>
                    @elseif($notification->data['status'] == "receive_order")
                        <span class="order_notification">
                            Shipper {{ $notification->data['shipper_name'] }} delivered successfully Order code:  
                        </span>
                    @elseif($notification->data['status'] == "fail")
                        <span class="order_notification">
                            Order status has been fail because delivery time does not meet standards  Order code: 
                        </span>
                    @endif
                </a> --}}
              @endif
            </li>
            @empty
                                        
            @endforelse
          </ul>
        </div>

          {{-- <ul class="list-inline mb-0 h-100 d-none d-xl-flex justify-content-end align-items-center">
            <li class="list-inline-item ml-3 mr-3 pr-3 pl-0 dropdown">
                <a class="dropdown-toggle no-arrow text-secondary fs-12" data-toggle="dropdown"
                    href="javascript:void(0);" role="button" aria-haspopup="false"
                    aria-expanded="false">
                    <span class="">
                        <span class="position-relative d-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14.668" height="16"
                                viewBox="0 0 14.668 16">
                                <path id="_26._Notification" data-name="26. Notification"
                                    d="M8.333,16A3.34,3.34,0,0,0,11,14.667H5.666A3.34,3.34,0,0,0,8.333,16ZM15.06,9.78a2.457,2.457,0,0,1-.727-1.747V6a6,6,0,1,0-12,0V8.033A2.457,2.457,0,0,1,1.606,9.78,2.083,2.083,0,0,0,3.08,13.333H13.586A2.083,2.083,0,0,0,15.06,9.78Z"
                                    transform="translate(-0.999)" fill="#91919b" />
                            </svg>
                            @if (Auth::check() && count(Auth::user()->unreadNotifications)>0)
                                <span
                                    class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{count(Auth::user()->unreadNotifications)}}</span>
                            @endif
                        </span>
                </a>

                @auth
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0 rounded-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0"> Notifications </h6>
                        </div>
                        <div class=" c-scrollbar-light overflow-auto " style="max-height:300px;">
                            <ul class="list-group list-group-flush">
                                @if(count(Auth::user()->unreadNotifications)>0)
                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                        <li class="list-group-item">
                                            
                                            @if ($notification->type == 'App\Notifications\OrderNotification')
                                                @php
                                                    $order = App\Models\OrderDetail::find($notification->data['order_detail_id']);
                                                    if($order)
                                                    {
                                                        $order =$order->order;
                                                    }
                                                    else {
                                                        break;
                                                    }
                                                @endphp
                                                    <a href="{{ route('purchase_history.get_detail', encrypt($order->id))}}" 
                                                        class="text-secondary fs-14">
                                                        @if($notification->data['status'] == "receive_order")
                                                            <span class="order_notification">
                                                                {{ translate('Order code: 
                                                                {{ $order->code }}
                                                                {{ translate('has been ' . (str_replace('_', ' ', $notification->data['status']))) }}
                                                                by shipper {{ $notification->data['shipper_name'] }}
                                                            </span>
                                                        @elseif($notification->data['status'] == "order_picking")
                                                            <span class="order_notification">
                                                                Shipper {{ $notification->data['shipper_name'] }} doing order picking
                                                                {{ translate('order code: ') }} {{ $order->code }}
                                                            </span>
                                                        @elseif($notification->data['status'] == "shipping")
                                                            <span class="order_notification">
                                                                Shipper {{ $notification->data['shipper_name'] }} is on the way to deliver
                                                                {{ translate('order code: ') }} {{ $order->code }}
                                                            </span>
                                                        @elseif($notification->data['status'] == "receive_order")
                                                            <span class="order_notification">
                                                                Shipper {{ $notification->data['shipper_name'] }} delivered successfully {{ translate('Order code: ') }} {{ $order->code }}
                                                            </span>
                                                        @elseif($notification->data['status'] == "fail")
                                                            <span class="order_notification">
                                                                Order status has been fail because delivery time does not meet standards  {{ translate('Order code: ') }} {{ $order->code }}
                                                            </span>
                                                        @endif
                                                    </a>
                                              
                                            @elseif ($notification->type == 'App\Notifications\RefundNotification')
                                                <a href="{{ route('refund.detail', ($notification->data['request_id']))}}" class="text-secondary fs-14">
                                                    <span class="order_notification">
                                                        {{ translate('Your refund request for order have code: ') }}
                                                        {{ $notification->data['request_code'] }}
                                                        @if($notification->data['status'] == 1)
                                                            {{ translate('has been approved by admin')}}
                                                        @elseif($notification->data['status'] == 2)
                                                            {{ translate('has been refunded by admin')}}
                                                        @else
                                                            {{ translate('has been rejected by admin')}}
                                                        @endif
                                                        
                                                    </span>
                                                </a>
                                            @else
                                                <a href=""
                                                    class="text-secondary fs-12">
                                                    <span class="ml-2">
                                                        {{ translate('Order code: ') }}
                                                        {{ $notification->data['request_code'] }}
                                                        {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                    </span>
                                                </a>
                                            @endif
                                        </li>
                                    @empty
                                        
                                    @endforelse
                                @else
                                    <li class="list-group-item">
                                        <div class="py-4 text-center fs-16">
                                             No notification found
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="text-center border-top">
                            <a href=""
                                class="text-secondary fs-12 d-block py-2">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                @endauth
            </li>
        </ul> --}}

          <!-- User -->
          <div class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                @if(!empty(Session::get('user_data'))>0)
                  <img src="{{ Session::get('user_data')->img_logo }}" alt class="w-px-40 h-auto rounded-circle">
                @else
                  <img src="{{ asset('assets/img/avatars/1.png') }}">
                @endif
                
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 14rem;">
              <li>
                <a class="dropdown-item" href="javascript:void(0)">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        @if(!empty(Session::get('user_data'))>0)
                          <img src="{{ Session::get('user_data')->img_logo }}" alt class="w-px-40 h-auto rounded-circle">
                        @else
                          <img src="{{ asset('assets/img/avatars/1.png') }}">
                        @endif
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block">
                        @if (Auth::check())
                          {{ Auth::user()->name }}
                        @endif
                      </span>
                      <small class="text-muted">Supermarket</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{route('personal_information.index')}}">
                  <i class="mdi mdi-account-outline me-2"></i>
                  <span class="align-middle">My Profile</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              @if (Auth::check())
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}">
                  <i class='mdi mdi-logout me-2'></i>
                  <span class="align-middle">Logout</span>
                </a>
              </li>
              @endif
            </ul>
          </div>
          <!--/ User -->
        </div>
      
      </div>
    </div>
  </div>


{{-- comment old code --}}

{{-- <!-- Navbar -->
<nav class="layout-navbar container-fluid navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">

    <!-- ! Not required for layout-without-menu -->
    @if(!isset($navbarHideToggle))
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-block d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="mdi mdi-menu mdi-24px"></i>
      </a>
    </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Notification -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">
          <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i class="mdi mdi-bell-outline mdi-24px"></i>
            <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end py-0">
            <li class="dropdown-menu-header border-bottom">
              <div class="dropdown-header d-flex align-items-center py-3">
                <h6 class="mb-0 me-auto">Notification</h6>
                <span class="badge rounded-pill bg-label-primary">8 New</span>
              </div>
            </li>
            <li class="dropdown-notifications-list scrollable-container">
              <ul class="list-group list-group-flush">
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Congratulation Lettie 🎉</h6>
                      <small class="text-truncate text-body">Won the monthly best seller gold badge</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">1h ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Charles Franklin</h6>
                      <small class="text-truncate text-body">Accepted your connection</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">12hr ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">New Message ✉️</h6>
                      <small class="text-truncate text-body">You have new message from Natalie</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">1h ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <span class="avatar-initial rounded-circle bg-label-success"><i class="mdi mdi-cart-outline"></i></span>
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Whoo! You have new order 🛒 </h6>
                      <small class="text-truncate text-body">ACME Inc. made new order $1,154</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">1 day ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <img src="{{ asset('assets/img/avatars/9.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Application has been approved 🚀 </h6>
                      <small class="text-truncate text-body">Your ABC project application has been approved.</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">2 days ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <span class="avatar-initial rounded-circle bg-label-success"><i class="mdi mdi-chart-pie-outline"></i></span>
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Monthly report is generated</h6>
                      <small class="text-truncate text-body">July monthly financial report is generated </small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">3 days ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <img src="{{ asset('assets/img/avatars/5.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">Send connection request</h6>
                      <small class="text-truncate text-body">Peter sent you connection request</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">4 days ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <img src="{{ asset('assets/img/avatars/6.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1 text-truncate">New message from Jane</h6>
                      <small class="text-truncate text-body">Your have new message from Jane</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">5 days ago</small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                  <div class="d-flex gap-2">
                    <div class="flex-shrink-0">
                      <div class="avatar me-1">
                        <span class="avatar-initial rounded-circle bg-label-warning"><i class="mdi mdi-alert-circle-outline"></i></span>
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                      <h6 class="mb-1">CPU is running high</h6>
                      <small class="text-truncate text-body">CPU Utilization Percent is currently at 88.63%,</small>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <small class="text-muted">5 days ago</small>
                    </div>
                  </div>
                </li>
              </ul>
            </li>
            <li class="dropdown-menu-footer border-top p-2">
              <a href="javascript:void(0);" class="btn btn-primary d-flex justify-content-center">
                View all notifications
              </a>
            </li>
          </ul>
        </li>
        <!--/ Notification -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="javascript:void(0)">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-medium d-block">
                      @if (Auth::check())
                        {{ Auth::user()->name }}
                      @endif
                    </span>
                    <small class="text-muted">Admin</small>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);">
                <i class="mdi mdi-account-outline me-2"></i>
                <span class="align-middle">My Profile</span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            @if (Auth::check())
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}">
                <i class='mdi mdi-logout me-2'></i>
                <span class="align-middle">Logout</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
      <input type="text" class="form-control search-input border-0" placeholder="Search..." aria-label="Search...">
      <i class="mdi mdi-close search-toggler cursor-pointer"></i>
    </div>
</nav>
<!-- / Navbar --> --}}
