@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="container-fluid">

      <div class="card mb-3">
        <div class="card-header row gutters-5">
          <div class="col">
              <h5 class="mb-md-0 h6">Import Request For Product</h5>
          </div>
          <div class="col">
            <a href="{{ asset('/images/example_import_request.xlsx') }}" target="_blank">
              <button>Download Example</button>
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


        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">All Request</h5>
                    </div>
                </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>Request Code</th>
                          <th>Seller Name</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Status</th>
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
                url:"{{ route('request_for_product.dtajax') }}",
                pages: 20
              },
          columns: 
          [
              {data: 'code', name: 'code', render: function(data,type,row){
                return (data=="")?"":data;
              }},
              {data: 'seller_name', name: 'seller_name', render: function(data,type,row){
                return (data=="")?"":data;
              }},
              {data: 'product_name', name: 'product_name',render: function (data) {
                return (data=="")?"":data;
              }},
              {data: 'quantity', name: 'quantity',render: function (data,type,row) {
                        return (data=="")?"":row.quantity + " "+ row.unit;
              }},
              {data: 'price', name: 'price', render: function(data){
                  return data;
              }},
              {data: 'status', name: 'status', render: function(data){
                  if(data == 0)
                  {
                      return "<span class='badge badge-inline badge-secondary'>Pending Admin Approval</span>";
                  }
                  if(data == 1)
                  {
                      return "<span class='badge badge-inline badge-secondary'>Pending Seller Accept</span>";
                  }
                  else if(data == 2)
                  {
                      return "<span class='badge badge-inline badge-warning'>Pending Price Update</span>";
                  }
                  else if(data == 3)
                  {
                      return "<span class='badge badge-inline badge-info' >Waiting For Customer</span>";
                  }
                  else if(data == 4)
                  {
                      return "<span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>Process To Checkout</span>";
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