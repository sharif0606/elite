<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('pageTitle')|@yield('pageSubTitle')</title>
    @yield('meta')

    <!-- css -->
    <link rel="stylesheet" href="{{asset('front/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('front/css/single.css')}}" />
    <!-- Bootsrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <!-- Bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <!-- Font Awesome 6.0 -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="" type="text/css" />
    <!-- our project just needs Font Awesome Solid + Brands -->
    <link href="{{asset('front/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('front/css/solid.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/extensions/laravel-toster/toastr.min.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-182321313-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-182321313-1');
    </script>
    <!-- Review Yotp -->
    <script type="text/javascript">
        (function e(){var e=document.createElement("script");e.type="text/javascript",e.async=true,e.src="//staticw2.yotpo.com/fH6c2xJm2synckDLh2ylP6r8ifftZl7rGfPSt0LB/widget.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})();
    </script>
    <style>
        .top-menu .dropdown-menu {
            background-color: var(--brand-color) !important;
        }

        .top-menu .dropdown-item:focus,
        .top-menu .dropdown-item:hover {
            color: var(--brand-color) !important;
            background-color: #fff !important;
        }

        .top-menu > .nav-link:focus,.top-menu >
        .nav-link:hover {
            color: #fff !important;
        }

        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu {
                display: none;
            }

            .navbar .nav-item:hover .nav-link {}

            .navbar .nav-item:hover .dropdown-menu {
                display: block;
            }

            .navbar .nav-item .dropdown-menu {
                margin-top: 0;
            }
        }

        .list-group-item {
            background-color: var(--brand-color) !important;
        }

        .list-group-flush>.list-group-item {
            border-width: 0;
            padding: 4px 0;
            font-size: 13px;
            font-weight: 400;
        }

        /*Nav*/
        .top-nav li.nav-item {
            margin: 0px 30px;
        }

        .header-top h4 {
            font-size: 16px;
            letter-spacing: 0;
            font-weight: bold;
        }
        .ui-menu-item{
            font-size:14px;
        }
        .chat-whatsapp {
            background-color: green;
            width: 60px;
            height: 60px;
            font-weight: bold;
            border-radius: 50%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            font-size: 30px;
            position: fixed;
            bottom: 100px;
            right: 30px;
            text-decoration: none;
        }
        .chat-facebook {
            background-color: #1877F2;
            width: 50px;
            height: 50px;
            font-weight: bold;
            border-radius: 50%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            font-size: 25px;
            position: fixed;
            bottom: 110px;
            right: 50px;
            text-decoration: none;
        }
        .chat-whatsapp i.bi, .chat-facebook i.fab{
            color: #fff;
        }
    </style>
    <!--begin::Page Scripts(used by this page)-->
    @stack('styles')
    <!--end::Page Scripts-->
</head>

<body>