@extends('layouts.app')

@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-md-left">
                    <h5 class="mb-md-0 h6">All Refund Request</h5>
                </div>
            </div>
        </form>

        @if (count($request_data) > 0)
            <div class="card-body p-3">
                <table class="table  mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-breakpoints="lg">Refund Code</th>
                            <th data-breakpoints="lg">Product Name</th>
                            <th data-breakpoints="lg">Order Date</th>
                            <th data-breakpoints="md">Total Amount</th>
                            <th data-breakpoints="lg">Delivery Status</th>
                            
                            <th>Payment Status</th>
                            <th data-breakpoints="lg">Refund Status</th>
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
                                    <a href="{{ route('refund_request.show', ($each_request_data->id)) }}">{{ $each_request_data->code }}</a>
                                </td>
                                <td>
                                    @if ($each_request_data->order_detail != null)
                                        {{ optional($each_request_data->order_detail)->product_name }}
                                    @endif
                                </td>
                                <td>
                                    {{  date('d-m-Y H:i A', strtotime($each_request_data->order_detail->created_at))  }}
                                </td>
                                
                                <td>
                                    {{"đ ".number_format($each_request_data->order_detail->shipping_cost + $each_request_data->order_detail->price, 2, ',', '.')}}
                                </td>
                                <td>
                                    @php
                                        $status =$each_request_data->order_detail->delivery_status;
                                    @endphp
                                    {{ (ucfirst(str_replace('_', ' ', $status))) }}
                                </td>
                                {{-- <td>
                                    {{ ucfirst(str_replace('_', ' ', $each_request_data->order_detail->order->payment_type))}}
                                </td> --}}
                                <td>
                                    @if ($each_request_data->order_detail->payment_status == 'paid')
                                        <span class="badge badge-inline badge-success">{{ ('Paid') }}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">{{ ('Unpaid') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($each_request_data->status == 0)
                                        <span class="badge badge-inline badge-danger">{{ ('Waiting For Approval') }}</span>
                                    @elseif ($each_request_data->status == 1)
                                        <span class="badge badge-inline badge-warning">{{ ('Waiting For Refund') }}</span>
                                    @else
                                        <span class="badge badge-inline badge-success">{{ ('Refunded') }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                   
                                    <a href="{{ route('refund_request.show', ($each_request_data->id)) }}"
                                        class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        title="{{ ('Refund Details') }}">
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