@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h4" >Personal Supermarket Information</h5>
                    </div>
                    
                </div>
              <div class="card-body" >
                <form action="{{route('personal_information.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    

                    {{-- Shop Name --}}
                    {{-- <input type="hidden" name="" value="{{ $shop->id}}"> --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Supermarket Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value="{{ $user_data->name }}">
                         </div>
                    </div>


                    {{-- Shop Logo --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-8">
                              <input type="file" class="form-control" name="logo" @error('image') is-invalid @enderror id="selectImage">
                              <img id="preview" src="{{ $user_data->img_logo }}" alt="your image" class="mt-3" style="display:block;width:200px;height:200px;"/>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    {{-- Shop Name --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Supermarket Phone</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Nunber" value="{{ $user_data->phone }}">
                         </div>
                    </div>
                    {{-- Shop Name --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Supermarket Address</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="address" placeholder="Address" value="{{ $user_data->address }}">
                         </div>
                    </div>
                    <!-- Password-->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label fs-14">Your Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control " placeholder="New Password" name="new_password">
                        </div>
                    </div>
                    <!-- Confirm Password-->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label fs-14">Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control " placeholder="Confirm Password" name="confirm_password">
                        </div>
                    </div>
                    
                    <!-- Address -->
                    <div class="card rounded-0 shadow-none border">
                        <div class="card-header pt-4 border-bottom-0">
                            <h5 class="mb-0 fs-18 fw-700 text-dark">Address</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($address_data as $key => $address)
                                <div class="">
                                    <div class="border p-4 mb-4 position-relative">
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary">Address:</span>
                                            <span class="col-md-8 text-dark">{{ $address->address }}</span>
                                        </div>
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary">Postal Code:</span>
                                            <span class="col-md-10 text-dark">{{ $address->postal_code }}</span>
                                        </div>
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary">District:</span>
                                            <span class="col-md-10 text-dark">{{ $address->district_name }}</span>
                                        </div>
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary">City:</span>
                                            <span class="col-md-10 text-dark">{{ $address->city_name }}</span>
                                        </div>
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary">Country:</span>
                                            <span class="col-md-10 text-dark">{{ $address->country_name }}</span>
                                        </div>
                                        <div class="row fs-14 mb-2 mb-md-0">
                                            <span class="col-md-2 text-secondary text-secondary">Phone:</span>
                                            <span class="col-md-10 text-dark">{{ $address->phone }}</span>
                                        </div>
                                        @if ($address->set_default)
                                            <div class="absolute-md-top-right pt-2 pt-md-4 pr-md-5">
                                                <span class="badge badge-inline badge-warning text-white p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">Default</span>
                                            </div>
                                        @endif
                                       
                                    </div>
                                </div>
                            @endforeach
                            {{-- <!-- Add New Address -->
                            <div class="" onclick="add_new_address()">
                                <div class="border p-3 mb-3 c-pointer text-center bg-light has-transition hov-bg-soft-light">
                                    <i class="fa fa-plus la-2x"></i>
                                    <div class="alpha-7 fs-14 fw-700">Add New Address</div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mar-all mb-2" style=" text-align: end;">
                            <button type="submit" name="button" value="publish"
                                class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
   
@stop
@push('scripts')
    <script>
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush