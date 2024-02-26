@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0">Import Request For Product</h5>
            </div>
            <div class="col" style="text-align: right;">
              <a href="{{ asset('/images/example_import_request.xlsx') }}" target="_blank">
                <button class="btn btn-primary">Download Example</button>
              </a>
            </div>
        </div>
        <div class="card-body">
        @include('shared.form-alerts')
        <div class="row">
            <div class="col-6">
            <form method="post" action="{{ route('import-csv-request') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                <div class="col-3 text-info fw-bold">
                    Import audit
                </div>
                <div class="col-9">
                    <input type="file" name="csvFile" class="form-control">
                </div>
                </div>
                <div class="form-group row">
                <div class="col-3 offset-3">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-md-left">
                    <h5 class="mb-md-0 h6">All Request</h5>
                </div>

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="Filter by Status" name="status"
                        onchange="sort_orders()">
                        <option value="">Filter by Status</option>
                        <option value="0"
                            @isset($status) @if ($status == 0) selected @endif @endisset>
                            Pending Admin Approve</option>
                        <option value="1"
                            @isset($status) @if ($status == 1) selected @endif @endisset>
                            Pending Seller Accept</option>
                        <option value="2"
                            @isset($status) @if ($status == 2) selected @endif @endisset>
                            Pending Price Update</option>
                        <option value="3"
                            @isset($status) @if ($status == 3) selected @endif @endisset>
                            Waiting For Customer</option>
                        <option value="4"
                            @isset($status) @if ($status == 4) selected @endif @endisset>
                            Added To Cart</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="Type Order code & hit Enter">
                    </div>
                </div>
            </div>
        </form>

        @if (count($request_data) > 0)
            <div class="card-body p-3">
                <table class="table  mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th data-breakpoints="lg">Product Name</th>
                            <th data-breakpoints="lg">Seller</th>
                            <th data-breakpoints="md">Quantity</th>
                            <th data-breakpoints="lg">Unit Price</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request_data as $key => $each_request_data)
                            @if ($each_request_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        @if($each_request_data->product_id != 0)
                                            <a href="{{ route('request_for_product.get_details_data', $each_request_data->id) }}"
                                            >{{ $each_request_data->code }}</a>
                                        @else
                                            <span>{{ $each_request_data->code }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $each_request_data->product_name }}
                                    </td>
                                    <td>
                                       
                                        {{ ($each_request_data->seller_name) }}
                                    </td>
                                    <td>
                                        {{ $each_request_data->quantity.' '.$each_request_data->unit }}
                                    </td>
                                    <td>
                                        {{($each_request_data->price)}}
                                    </td>
                                    <td>
                                       
                       
                                        @if ($each_request_data->status == 0)
                                            <span class='badge badge-inline badge-secondary'>Pending Admin Approval</span>
                                        @elseif($each_request_data->status == 1)
                                            <span class='badge badge-inline badge-secondary'>Pending Seller Accept</span>
                                        @elseif($each_request_data->status == 2)
                                            <span class='badge badge-inline badge-warning'>Pending Price Update</span>
                                        @elseif($each_request_data->status == 3)
                                            <span class='badge badge-inline badge-info' >Waiting For Customer</span>
                                        @elseif($each_request_data->status == 97)
                                            <span class='badge badge-inline badge-danger' >Missing Product Slug</span>
                                        @elseif($each_request_data->status == 98)
                                            <span class='badge badge-inline badge-danger' >Seller Not Found</span>
                                        @elseif($each_request_data->status == 99)
                                            <span class='badge badge-inline badge-danger' >Product Not Found</span>
                                        @elseif($each_request_data->status == 90)
                                            <span class='badge badge-inline badge-danger' >Seller Reject</span>
                                        @else
                                        <span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>Process To Checkout</span>
                                        @endif
                                    </td>
                                    
                                        <td class="text-right">
                                            @if($each_request_data->product_id != 0 && $each_request_data->shop_id != 0)
                                            <a href="{{ route('request_for_product.get_details_data', $each_request_data->id) }}"
                                                class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                title="Request Details">
                                                <i class="fa fa-eye"></i>
                                            </a> 
                                            @endif 
                                            @if(in_array($each_request_data->status,[90,97,98,99]))
                                                <a href="{{ route('request_for_product.destroy', $each_request_data->id) }}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                   
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                  {{ $request_data->links() }}
              </div>
            </div>
            
        @endif
    </div>
    
    <style>
      .aiz-pagination-center .pagination {
        -ms-flex-pack: center;
        justify-content: center;
        }
        .aiz-pagination-right .pagination {
        -ms-flex-pack: end;
        justify-content: flex-end;
        }
        .aiz-pagination .pagination {
        margin-bottom: 0;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        }
    </style>
@endsection

@push('scripts')

<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':

                toastr.options.timeOut = 10000;
                toastr.info("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();
                break;
            case 'success':

                toastr.options.timeOut = 10000;
                toastr.success("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
            case 'warning':

                toastr.options.timeOut = 10000;
                toastr.warning("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
            case 'error':

                toastr.options.timeOut = 10000;
                toastr.error("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
        }
    @endif
</script>
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }

    </script>
@endpush