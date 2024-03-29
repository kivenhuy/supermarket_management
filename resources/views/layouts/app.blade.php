@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

@php
    $configData = Helper::appClasses();
@endphp

<!DOCTYPE html>
<html lang="{{ session()->get('locale') ?? app()->getLocale() }}" class="light-style layout-navbar-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-theme-default-light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title', 'SuperMarket Management')</title>
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->



  <!-- Include Styles -->
  <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/styles')
  <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
  {{-- <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" /> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('custom/css/aiz-core.css') }}" />
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/scriptsIncludes')
  <link rel="stylesheet" href="{{ asset('custom\css\jquery.datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('custom\css\style.css?v=')}}{{ now()->timestamp}}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
  @yield('style')
  <script>
    var AIZ = AIZ || {};
        AIZ.local = {}

       

  </script>

  
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
      
          {{-- @include('layouts/app-sections/navbar') --}}
          @include('layouts/sections/menu/verticalMenu')
      
          <!-- Layout page -->
          <div class="layout-page px-4">
      
            {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}
            {{-- <x-banner /> --}}
      
            @include('layouts/app-sections/navbar')
      
      
            <!-- Content wrapper -->
            <div class="content-wrapper">
      
              <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
      
                  @yield('content')
      
                </div>
                <!-- / Content -->
      
                <!-- Footer -->
                    {{-- @include('layouts/sections/footer/footer') --}}
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
              </div>
              <!--/ Content wrapper -->
            </div>
            <!-- / Layout page -->
          </div>
      
          <!-- Drag Target Area To SlideIn Menu On Small Screens -->
          <div class="drag-target"></div>
        </div>
        <style>
          .layout-page
          {
            background-color: #FFFFFF;
          }
          .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl
          {
            padding-left: unset;
            padding-right: unset;
          }
          .sub-menu {
            display:none;
            padding-left: 2rem;
          }
        </style>
        <!-- / Layout wrapper -->

  

  <!-- Include Scripts -->
  <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
 
  <script src="{{ asset('plugins/jquery/jquery.js') }}"></script>
  <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}" ></script>

  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  @include('layouts/sections/scripts')

  <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
   
</script>


  @stack('scripts')

    
  
</body>

</html>


