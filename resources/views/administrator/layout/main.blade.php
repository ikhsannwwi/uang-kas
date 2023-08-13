<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@stack('title')Kas Kosan</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('template/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('template/assets/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('template/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- endinject -->
    <!-- Datatable:css -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <!-- End Datatable -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('template/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('template/assets/images/favicon.png')}}" />
    {{-- Toaster css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- SweetAlert css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">


    <!-- Custom styles -->
    @stack('css')
    <!-- End Custom styles -->
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('administrator.layout.navbar')
      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('administrator.layout.sidebar')
        
        <!-- partial:partials/_modal.html -->
        @include('administrator.layout.modal')
        <!-- partial -->
        <div class="main-panel">

            {{-- content main --}}
            @yield('content')
            {{-- end content main --}}

            {{-- footer --}}
            @include('administrator.layout.footer')
            {{-- end footer --}}

          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- plugins:js -->
    <script src="{{asset('template/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('template/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('template/assets/vendors/jquery-circle-progress/js/circle-progress.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('template/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('template/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('template/assets/js/misc.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    {{-- <script src="{{asset('template/assets/js/dashboard.js')}}"></script> --}}
    <!-- End custom js for this page -->
    <!-- Datatable -->
    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/formvalidation/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/formvalidation//dist/js/plugins/Trigger.min.js') }}"></script> --}}
    <!-- Include FormValidation Bootstrap5 plugin -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/formvalidation-bootstrap5@latest/dist/Bootstrap5.min.js"></script> --}}
 
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
    <!-- End Datatable -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Custom js -->
    
    <!-- Toaster JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- SweetAlert Js --}}
    <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    {{-- Moment Js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Optional FormValidation Plugins (Choose the ones you need) -->
    <!-- Other head elements -->
    <!-- Add other plugins if needed -->

      <script>
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "rtl": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 1000,
        "hideDuration": 500,
        "timeOut": 10000,
        "extendedTimeOut": 8000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      @if (session()->has('errors'))
       @foreach (session('errors') as $error)
          toastr["error"]("{!! $error !!}",{ class: 'toast-error' })
        @endforeach
      @endif
      @if (session()->has('error'))
        toastr["error"]("{{ Session::get('error') }}",{ class: 'toast-error' })
        @endif
      @if (session()->has('success'))
        toastr["success"]("{{ Session::get('success') }}",{ class: 'toast-success' })
      @endif
      </script>
      

    @stack('js')
    <!-- End Custom js -->
  </body>
</html>