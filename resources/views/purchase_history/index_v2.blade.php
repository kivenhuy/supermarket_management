@extends('layouts.app')

@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-md-left">
                    <h5 class="mb-md-0 h6">Purchase History</h5>
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
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Shipping Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
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
                                        
                                            <a href="{{ route('purchase_history.get_details_data', $each_request_data->id) }}"
                                            >{{ $each_request_data->code }}</a>
                                        
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($each_request_data->order_date)) }}
                                    </td>
                                    <td>
                                       
                                        {{ ($each_request_data->all_amount) }}
                                    </td>
                                    <td>
                                        @if ($each_request_data->delivery_status != 'waiting')
                                            <span class="badge badge-inline badge-success"> {{ ucfirst($each_request_data->delivery_status) }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger"> {{ ucfirst($each_request_data->delivery_status) }}</span>
                                        @endif
                                       
                                    </td>
                                    <td>
                                        @if ($each_request_data->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success"> {{ ucfirst($each_request_data->payment_status) }}</span>
                                        @elseif($each_request_data->payment_status == 'waiting for checking')
                                            <span class="badge badge-inline badge-warning"> {{ ucfirst($each_request_data->payment_status) }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger"> {{ ucfirst($each_request_data->payment_status) }}</span>
                                        @endif
                                        
                                       
                                    </td>
                                    <td class="text-right">
                                    
                                        <a href="{{ route('purchase_history.get_details_data', $each_request_data->id) }}"
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                            title="Request Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    
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
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }
    </script>
@endpush