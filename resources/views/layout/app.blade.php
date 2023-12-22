<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE FORCE | @yield('siteTitle', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    {{--<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/assets/extensions/laravel-toster/toastr.min.css') }}">
    <!-- Bootstrap Date Range Picker  -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/custome.css') }}">
    <style>
    </style>
    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>

{{--  <body class="theme-dark" style="overflow-y: auto;">  --}}
<body style="overflow-y: auto;">
    <div id="app">
        @include('layout.nav')
        <div id="main" class="layout-navbar">
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                <li class="nav-item dropdown me-1">
                                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-envelope bi-sub fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Mail</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-bell bi-sub fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-header">
                                            <h6>Notifications</h6>
                                        </li>
                                        <li class="dropdown-item notification-item">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="notification-icon bg-primary">
                                                    <i class="bi bi-cart-check"></i>
                                                </div>
                                                <div class="notification-text ms-4">
                                                    <p class="notification-title font-bold">Successfully check out</p>
                                                    <p class="notification-subtitle font-thin text-sm">Order ID #256</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="dropdown-item notification-item">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="notification-icon bg-success">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </div>
                                                <div class="notification-text ms-4">
                                                    <p class="notification-title font-bold">Homework submitted</p>
                                                    <p class="notification-subtitle font-thin text-sm">Algebra math homework</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <p class="text-center py-2 mb-0"><a href="#">See all notification</a></p>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{encryptor('decrypt', request()->session()->get('userName'))}}</h6>
                                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="assets/images/faces/1.jpg">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{currentUser()}}!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{route('profile', ['role' =>currentUser()])}}"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="{{route('change_password', ['role' =>currentUser()])}}"><i class="icon-mid bi bi-gear me-2"></i>
                                            Change Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{route('logOut')}}"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">

                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>@yield('pageTitle')</h3>
                                <p class="text-subtitle text-muted">@yield('pageSubTitle')</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        @hasSection('pageSubTitle')
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">@yield('pageSubTitle')</li>
                                        @else
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        @endif
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            @yield('content')
                        </div>
                    </section>
                </div>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2023 © Eliteforce</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                                by <a href="https://ahmadsaugi.com">Muktodhara Technology Ltd.</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/horizontal-layout.js') }}"></script>
    {{--<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>--}}
    <script src="{{ asset('/assets/extensions/laravel-toster/toastr.min.js') }}"></script>
    <script src="{{asset('assets/moment/moment.min.js')}}"></script>
    <!-- Bootstrap Date Range Picker  -->
    <script src="{{asset('assets/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
    <script src="{{ asset('/assets/js/pages/form-element-select.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/simple-datatables.js') }}"></script>
    <script>
        $(".dropify").dropify({messages:{default:"  click here",replace:" click to here",remove:"Remove",error:"Ooops, something wrong appended."},error:{fileSize:"The file size is too big (1M max)."}});
    </script>

    @stack('scripts')
    {!! Toastr::message() !!}
    <script>
        $('.select2').select2();
        function getBranch(e) {
            let customerId=$(e).val();
            $.ajax({
                url: "{{ route('get_ajax_branch') }}",
                type: "GET",
                dataType: "json",
                data: { customerId: customerId },
                success: function (data) {
                    //console.log(data)
                    var d = $('#branch_id').empty();
                    $('#branch_id').append('<option value="0">Select Branch</option>');
                    $.each(data, function(key, value) {
                        $('#branch_id').append('<option data-vat="'+value.vat+'" value="' + value.id + '">' + value.brance_name + '</option>');
                    });
                },
                error: function () {
                    console.error("Error fetching data from the server.");
                },
            });
        }
        function getAtm(e) {
            let branchId=$(e).val();
            $.ajax({
                url: "{{ route('get_ajax_atm') }}",
                type: "GET",
                dataType: "json",
                data: { branchId: branchId },
                success: function (data) {
                    //console.log(data)
                    var d = $('#atm_id').empty();
                    $('#atm_id').append('<option data-vat="0" value="0">Select ATM</option>');
                    $('#atm_id').append('<option value="1">All ATM</option>');
                    $.each(data, function(key, value) {
                        $('#atm_id').append('<option value="' + value.id + '">' + value.atm + '</option>');
                    });
                },
                error: function () {
                    console.error("Error fetching data from the server.");
                },
            });
        }
        function getRate(e) {

            if (!$('.customer_id').val()) {
                $('.customer_id').focus();
                return false;
            }
            let customerId=$('#customer_id').find(":selected").val();
            let jobpostId=$(e).closest('tr').find('.job_post_id').val();
            $.ajax({
                url: "{{ route('get_ajax_rate') }}",
                type: "GET",
                dataType: "json",
                data: { customerId: customerId, jobpostId: jobpostId},
                success: function (data) {
                    console.log(data)
                    $(e).closest('tr').find('.rate').val(data.rate);
                },
                error: function () {
                    console.error("Error fetching data from the server.");
                },
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var currentPageUrl = window.location.href;
            $('.submenu-item a').each(function() {
                var anchorUrl = $(this).attr('href');
                if (currentPageUrl === anchorUrl) {
                    $(this).closest('.submenu-item').addClass('active');
                    $(this).closest('ul.submenu').addClass('active').css('display', 'block');

                    $(this).closest('ul.submenu').parents('ul.submenu').addClass('active').css('display', 'block');
                }
            });
        });
    </script>
    <script>
        function printDiv(divName) {
            var prtContent = document.getElementById(divName);
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write('<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css"/>');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.onload =function(){
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            }
        }
    </script>
    <script>
        $(function() {
            $("#datepicker").datepicker({ dateFormat: "dd-mm-yy" }).val()
        });
    </script>
</body>

</html>
