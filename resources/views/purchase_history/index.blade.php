@extends('layouts.app')

@section('content')
<div class="row">
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">All Order History</h5>
                    </div>
                </div>
                <div class="card-body" >
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                            <th>Code</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Shipping Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                          </tr>
                      </tbody>
                    </table>
                  </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
{{-- </div> --}}
</div>
<script>
@if(Session::has('success'))
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true
}
toastr.success("{{ session('success') }}");
@endif
@if(Session::has('add'))
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true
}
toastr.success("{{ session('add') }}");
@endif
@if(Session::has('delete'))
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true
}
    toastr.success("{{ session('delete') }}");
@endif
</script>
@stop

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
        var rfq_table = $("#example1").DataTable
        ({
          lengthChange: true,
          responsive: true,
          processing: true,
          searching: false,
          bSort:false,
          serverSide: true,
          deferRender: true,
          ajax: {
                url:"{{ route('purchase_history.dtajax') }}",
                pages: 20
              },
                columns: 
                [
                    {data: 'code', name: 'code', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'order_date', name: 'order_date', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'all_amount', name: 'all_amount', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'delivery_status', name: 'delivery_status', render: function(data){
                        return "<span class='badge badge-inline badge-warning'>"+ data +"</span>";
                    }},
                    {data: 'payment_status', name: 'payment_status', render: function(data){
                        if(data === "Unpaid" || data === "Pending" )
                        {
                            return "<span class='badge badge-inline badge-danger'>" + data +"</span>";
                        }
                        else if(data === "Waiting for checking")
                        {
                            return "<span class='badge badge-inline badge-warning'>" + data +"</span>";
                        }
                        else
                        {
                            return "<span class='badge badge-inline badge-success'>" + data +"</span>";
                        }
                    }},
                    
                    {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                    },
                ],
          drawCallback:function(setting){
          
          $('[data-toggle="tooltip"]').tooltip();
          var abc = $(this).find('.dataTables_empty').length;
          console.log("aaaaaa" + abc);
          if ($(this).find('.dataTables_empty').length == 1) {
                // $('th').hide();
                // $('#example1_info').hide();
                $('#example1_paginate').hide();
          }
        },
        fnDrawCallback: function () {
          var abc = $(this).find('.dataTables_empty').length;
          console.log("aaaaaa" + abc);
        }
        });
    });

    
</script>
@endpush