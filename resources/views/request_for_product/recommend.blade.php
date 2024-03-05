@extends('layouts.app')

@section('content')
    <div class="card">
        
            <div class="card-header row gutters-5">
                <div class="col text-md-left">
                    <h5 class="mb-md-0 h6">Recommendations request for you</h5>
                </div>

                
            </div>
       
        <form  action="{{ route('request_for_product.recommendation_create') }}" method="POST" id="final_checkout_form">
            @csrf
            <input type="hidden" name="product_id" id="product_id" >
            <input type="hidden" name="quantity" id="quantity" >
            @if (count($recommend_request) > 0)
                <div class="card-body p-3">
                    <table class="table  mb-0">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Product ID</th>
                                    <th data-breakpoints="lg">Product Name</th>
                                    <th data-breakpoints="lg">Seller</th>
                                    <th data-breakpoints="md">Quantity</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recommend_request as $key => $each_recommend_request)
                                @if ($each_recommend_request != null)
                                    <tr>
                                        <td class="product_id">
                                            @if($each_recommend_request->id != 0)
                                                {{ $each_recommend_request->id}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($each_recommend_request->id != 0)
                                                <a href="{{"http://localhost:8000/product/".$each_recommend_request->slug}}" target="_blank">{{ $each_recommend_request->name }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $each_recommend_request->seller_name }}
                                        </td>
                                        <td class="quantity">
                                            {{ round($each_recommend_request->qty/$count_enteprise) }} KG
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary" onclick="rowClicked(this)">Request Now</button>
                                        </td>
                                        
                                    
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                
                </div>
                
            @endif
        </form>
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

        function rowClicked(element){
            var id = $(element).closest("tr").find('.product_id').text();
            var quantity = $(element).closest("tr").find('.quantity').text();
            $('#product_id').val(id)
            $('#quantity').val(quantity)
            // if(id != null)
            // {
                $('#final_checkout_form').submit();
            // }
        }
    </script>
@endpush