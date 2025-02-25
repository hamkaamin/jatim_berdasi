<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="{{ asset(env('APP_LOGO', 'login.png')) }}">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    @if (env('APP_NAME') == 'BANGKALAN BRAVO')
        <link href="{{ asset('admin_asset/main_bravo.css') }}" rel="stylesheet">
    @elseif(env('APP_NAME') == 'JEMBER SIABANG')
        <link href="{{ asset('admin_asset/main_siabang.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('admin_asset/main.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('admin_asset/assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}

    {{-- Adjustable Minible CSS --}}
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme_assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('theme_assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('theme_assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    {{-- End Adjustable Minible CSS --}}

    <style>
        .timer {
            background: rgb(57, 57, 57);
            color: white;
            -webkit-border-bottom-right-radius: 30px;
            -webkit-border-bottom-left-radius: 30px;
            -moz-border-radius-bottomright: 30px;
            -moz-border-radius-bottomleft: 30px;
            border-bottom-right-radius: 30px;
            border-bottom-left-radius: 30px;
            width: 33vh;
            padding: 6px;
            position: fixed;
            top: 0px;
            left: 35%;
            right: 35%;
            align-items: center;
            text-align: center;
            z-index: 99999;
            -webkit-box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);
            -moz-box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);
            box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);

            -webkit-animation: timer-saleh 1s infinite;
            /* Safari 4+ */
            -moz-animation: timer-saleh 1s infinite;
            /* Fx 5+ */
            -o-animation: timer-saleh 1s infinite;
            /* Opera 12+ */
            animation: timer-saleh 1s infinite;
        }

        .timer-time {
            font-size: 10pt;
            margin-left: 5px;
            margin-right: 5px;
        }

        @media only screen and (max-width: 500px) {
            .timer {
                background: rgb(57, 57, 57);
                color: white;
                -webkit-border-bottom-right-radius: 30px;
                -webkit-border-bottom-left-radius: 30px;
                -moz-border-radius-bottomright: 30px;
                -moz-border-radius-bottomleft: 30px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
                width: 20vh;
                padding: 6px;
                position: fixed;
                top: 0px;
                left: 35%;
                right: 35%;
                align-items: center;
                text-align: center;
                z-index: 99999;
                -webkit-box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);
                -moz-box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);
                box-shadow: 0px 3px 31px -4px rgba(0, 0, 0, 0.67);

                -webkit-animation: timer-saleh 1s infinite;
                /* Safari 4+ */
                -moz-animation: timer-saleh 1s infinite;
                /* Fx 5+ */
                -o-animation: timer-saleh 1s infinite;
                /* Opera 12+ */
                animation: timer-saleh 1s infinite;
                font-size: 7pt;
            }

            .timer-time {
                font-size: 7pt;
                margin-left: 5px;
                margin-right: 5px;
            }
        }

        @-webkit-keyframes timer-saleh {

            0%,
            49% {
                background-color: black;
                /* border: 3px solid #e50000; */
            }

            50%,
            100% {
                background-color: #e50000;
                /* background-color: rgb(228, 202, 202); */

            }
        }

        .tab-animate-afu {
            border-radius: 8px;
        }

        .tab-animate-afu a .animate {
            inset: 0;
        }

        .tab-animate-afu a .animate .kotak {
            height: 0;
            width: 0;
            transition: ease-in-out 0.2s;
        }

        .tab-animate-afu:hover a .animate .kotak {
            height: 100%;
            width: 100%;
            inset: 0;

        }

        .tab-animate-afu a.active .animate .kotak {
            height: 100%;
            width: 100%;
            inset: 0;
        }

        .form-check-input {
            border: 1px solid var(--bs-primary);
        }

        .col-3 .rainbow-card-afu {
            background-color: #FF884E;
        }

        .col-3:nth-child(2n+1) .rainbow-card-afu {
            background-color: #FFC44C;
        }

        .col-3:nth-child(3n+1) .rainbow-card-afu {
            background-color: #8CCA4D;
        }

        .col-3:nth-child(4n+1) .rainbow-card-afu {
            background-color: #4FDAC5;
        }

        .col-3:nth-child(5n+1) .rainbow-card-afu {
            background-color: #4DC3FF;
        }

        .col-3:nth-child(6n+1) .rainbow-card-afu {
            background-color: #5E94FF;
        }

        .col-3:nth-child(7n+1) .rainbow-card-afu {
            background-color: #A06FFF;
        }

        .dataTables_wrapper table.table {
            width: 100% !important;
        }
    </style>
</head>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<body data-sidebar-size="sm">
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.left-sidebar')



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @php
                        $fase_aktif = App\Models\Fase::where('timer', 1)->first();
                        $pengumuman = App\Models\Pengumuman::where('is_aktif', 1)->get();
                    @endphp
                    @if ($fase_aktif)
                        <div class="timer">
                            <span class="timer-title">Fase {{ $fase_aktif->keterangan ?? '' }} Berakhir
                                Dalam</span>
                            <br>
                            <div class="timer-inner">
                                <span class="timer-time timer-day">0</span>:<span
                                    class="timer-time timer-hour">0</span>:<span
                                    class="timer-time timer-minutes">0</span>:<span
                                    class="timer-time timer-seconds">0</span>
                            </div>

                            <script>
                                // Set the date we're counting down to
                                var countDownDate = new Date("{{ $fase_aktif->tgl_berakhir }}").getTime();

                                // Update the count down every 1 second
                                var x = setInterval(function() {
                                    // Get today's date and time
                                    var now = new Date().getTime();

                                    // Find the distance between now and the count down date
                                    var distance = countDownDate - now;

                                    // Time calculations for days, hours, minutes and seconds
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    // Output the result in an element with id="demo"
                                    // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                                    // + minutes + "m " + seconds + "s ";
                                    $('.timer-day').html(days + 'hari');
                                    $('.timer-hour').html(hours + 'jam');
                                    $('.timer-minutes').html(minutes + 'menit');
                                    $('.timer-seconds').html(seconds + 'detik');

                                    // If the count down is over, write some text
                                    if (distance < 0) {
                                        clearInterval(x);
                                        $('.timer-inner').html('WAKTU HABIS');
                                        document.getElementById("demo").innerHTML = "EXPIRED";
                                    }
                                }, 1000);
                            </script>
                        </div>
                    @endif

                    @foreach ($pengumuman as $item)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <i class="afu-gsap-scale uil uil-exclamation-triangle me-2"></i>
                                {{ $item->judul }}
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                            </button> --}}
                            </div>
                            <p class="mb-0">{!! $item->deskripsi !!}</p>
                            @if ($item->file)
                                <a target="_blank" href="{{ $item->file }}">View</a>
                            @else
                                -
                            @endif
                        </div>
                    @endforeach

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                @include('layouts.alert')
                            </div>
                            <div
                                class="card card-body page-title-box d-flex flex-column align-items-start justify-content-between gap-2">
                                <h4 class="mb-0"> @yield('title')</h4>
                                <h5 class="text-muted">@yield('title-desc')</h5>
                                <div class="page-title-actions">
                                    @yield('buttons')
                                </div>
                                {{-- <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Minible</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="card card-body">
                        @yield('content')
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2">
                                        <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1">$<span data-plugin="counterup">34,152</span></h4>
                                        <p class="text-muted mb-0">Total Revenue</p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i
                                                class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2">
                                        <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">5,643</span></h4>
                                        <p class="text-muted mb-0">Orders</p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i
                                                class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2">
                                        <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">45,254</span></h4>
                                        <p class="text-muted mb-0">Customers</p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i
                                                class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">

                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2">
                                        <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1">+ <span data-plugin="counterup">12.58</span>%</h4>
                                        <p class="text-muted mb-0">Growth</p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i
                                                class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> since last week
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#"
                                                id="dropdownMenuButton5" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Sort By:</span> <span
                                                    class="text-muted">Yearly<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Monthly</a>
                                                <a class="dropdown-item" href="#">Yearly</a>
                                                <a class="dropdown-item" href="#">Weekly</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Sales Analytics</h4>

                                    <div class="mt-1">
                                        <ul class="list-inline main-chart mb-0">
                                            <li class="list-inline-item chart-border-left me-0 border-0">
                                                <h3 class="text-primary">$<span
                                                        data-plugin="counterup">2,371</span><span
                                                        class="text-muted d-inline-block font-size-15 ms-3">Income</span>
                                                </h3>
                                            </li>
                                            <li class="list-inline-item chart-border-left me-0">
                                                <h3><span data-plugin="counterup">258</span><span
                                                        class="text-muted d-inline-block font-size-15 ms-3">Sales</span>
                                                </h3>
                                            </li>
                                            <li class="list-inline-item chart-border-left me-0">
                                                <h3><span data-plugin="counterup">3.6</span>%<span
                                                        class="text-muted d-inline-block font-size-15 ms-3">Conversation
                                                        Ratio</span></h3>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-3">
                                        <div id="sales-analytics-chart"
                                            data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]'
                                            class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-4">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-sm-8">
                                            <p class="text-white font-size-18">Enhance your <b>Campaign</b> for better
                                                outreach <i class="mdi mdi-arrow-right"></i></p>
                                            <div class="mt-4">
                                                <a href="javascript: void(0);"
                                                    class="btn btn-success waves-effect waves-light">Upgrade
                                                    Account!</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <img src="assets/images/setup-analytics-amico.svg" class="img-fluid"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Sort By:</span> <span
                                                    class="text-muted">Yearly<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton1">
                                                <a class="dropdown-item" href="#">Monthly</a>
                                                <a class="dropdown-item" href="#">Yearly</a>
                                                <a class="dropdown-item" href="#">Weekly</a>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">Top Selling Products</h4>


                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i
                                                    class="mdi mdi-circle-medium text-primary me-2"></i> Desktops </p>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                                    style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                                    aria-valuemax="52">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i
                                                    class="mdi mdi-circle-medium text-info me-2"></i> iPhones </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-info" role="progressbar"
                                                    style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                                    aria-valuemax="45">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i
                                                    class="mdi mdi-circle-medium text-success me-2"></i> Android </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-success" role="progressbar"
                                                    style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                                    aria-valuemax="48">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i
                                                    class="mdi mdi-circle-medium text-warning me-2"></i> Tablets </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                                    style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                                    aria-valuemax="78">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i
                                                    class="mdi mdi-circle-medium text-purple me-2"></i> Cables </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                                    style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                                    aria-valuemax="63">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end Col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">All Members<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item" href="#">Locations</a>
                                                <a class="dropdown-item" href="#">Revenue</a>
                                                <a class="dropdown-item" href="#">Join Date</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Top Users</h4>

                                    <div data-simplebar style="max-height: 339px;">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-centered table-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20px;"><img
                                                                src="assets/images/users/avatar-4.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Glenn Holden</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> Nevada</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-danger-subtle text-danger font-size-12">Cancel</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-success"
                                                                data-feather="trending-up"></i>$250.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-5.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Lolita Hamill</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> Texas</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success font-size-12">Success</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-danger"
                                                                data-feather="trending-down"></i>$110.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-6.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Robert Mercer</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> California</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-info-subtle text-info font-size-12">Active</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-success"
                                                                data-feather="trending-up"></i>$420.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-7.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> Montana</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-warning-subtle text-warning font-size-12">Pending</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-danger"
                                                                data-feather="trending-down"></i>$120.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-8.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> Colorado</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-info-subtle text-info font-size-12">Active</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-success"
                                                                data-feather="trending-up"></i>$112.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-2.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> Australia</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success font-size-12">Success</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-danger"
                                                                data-feather="trending-down"></i>$120.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="assets/images/users/avatar-1.jpg"
                                                                class="avatar-xs rounded-circle " alt="..."></td>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-map-marker"></i> India</p>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-danger-subtle text-danger font-size-12">Cancel</span>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i
                                                                class="icon-xs icon me-2 text-success"
                                                                data-feather="trending-up"></i>$112.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- enbd table-responsive-->
                                    </div> <!-- data-sidebar-->
                                </div><!-- end card-body-->
                            </div> <!-- end card-->
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Recent<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton3">
                                                <a class="dropdown-item" href="#">Recent</a>
                                                <a class="dropdown-item" href="#">By Users</a>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">Recent Activity</h4>

                                    <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 339px;">
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <p class="text-muted mb-1 font-size-13">Today<small
                                                        class="d-inline-block ms-1">12:20 pm</small></p>
                                                <p class="mb-0">Andrei Coman magna sed porta finibus, risus
                                                    posted a new article: <span class="text-primary">Forget UX
                                                        Rowland</span></p>
                                            </div>
                                        </li>
                                        <li class="feed-item">
                                            <p class="text-muted mb-1 font-size-13">22 Jul, 2020 <small
                                                    class="d-inline-block ms-1">12:36 pm</small></p>
                                            <p class="mb-0">Andrei Coman posted a new article: <span
                                                    class="text-primary">Designer Alex</span></p>
                                        </li>
                                        <li class="feed-item">
                                            <p class="text-muted mb-1 font-size-13">18 Jul, 2020 <small
                                                    class="d-inline-block ms-1">07:56 am</small></p>
                                            <p class="mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                                Commented <span class="text-primary"> Developer Moreno</span></p>
                                        </li>
                                        <li class="feed-item">
                                            <p class="text-muted mb-1 font-size-13">10 Jul, 2020 <small
                                                    class="d-inline-block ms-1">08:42 pm</small></p>
                                            <p class="mb-0">Zack Wetass, Chris combined Commented <span
                                                    class="text-primary">UX Murphy</span></p>
                                        </li>

                                        <li class="feed-item">
                                            <p class="text-muted mb-1 font-size-13">23 Jun, 2020 <small
                                                    class="d-inline-block ms-1">12:22 am</small></p>
                                            <p class="mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                                Commented <span class="text-primary"> Developer Moreno</span></p>
                                        </li>
                                        <li class="feed-item pb-1">
                                            <p class="text-muted mb-1 font-size-13">20 Jun, 2020 <small
                                                    class="d-inline-block ms-1">09:48 pm</small></p>
                                            <p class="mb-0">Zack Wetass, Chris combined Commented <span
                                                    class="text-primary">UX Murphy</span></p>
                                        </li>

                                    </ol>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">

                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton4"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Monthly<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton4">
                                                <a class="dropdown-item" href="#">Yearly</a>
                                                <a class="dropdown-item" href="#">Monthly</a>
                                                <a class="dropdown-item" href="#">Weekly</a>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title">Social Source</h4>

                                    <div class="text-center">
                                        <div class="avatar-sm mx-auto mb-4">
                                            <span class="avatar-title rounded-circle bg-primary-subtle font-size-24">
                                                <i class="mdi mdi-facebook text-primary"></i>
                                            </span>
                                        </div>
                                        <p class="font-16 text-muted mb-2"></p>
                                        <h5><a href="#" class="text-reset ">Facebook - <span
                                                    class="text-muted font-16">125 sales</span> </a></h5>
                                        <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec vitae
                                            sapien ut libero venenatis faucibus tincidunt.</p>
                                        <a href="#" class="text-reset font-16">Learn more <i
                                                class="mdi mdi-chevron-right"></i></a>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-primary font-size-16">
                                                        <i class="mdi mdi-facebook text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Facebook</h5>
                                                <p class="text-muted mb-0">125 sales</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-info font-size-16">
                                                        <i class="mdi mdi-twitter text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Twitter</h5>
                                                <p class="text-muted mb-0">112 sales</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-pink font-size-16">
                                                        <i class="mdi mdi-instagram text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Instagram</h5>
                                                <p class="text-muted mb-0">104 sales</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-center">
                                        <a href="#" class="text-primary font-size-14 fw-medium">View All Sources
                                            <i class="mdi mdi-chevron-right"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Latest Transaction</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck1">
                                                            <label class="form-check-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Order ID</th>
                                                    <th>Billing Name</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Payment Status</th>
                                                    <th>Payment Method</th>
                                                    <th>View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck2">
                                                            <label class="form-check-label"
                                                                for="customCheck2">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2540</a> </td>
                                                    <td>Neal Matthews</td>
                                                    <td>
                                                        07 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $400
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-success-subtle text-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck3">
                                                            <label class="form-check-label"
                                                                for="customCheck3">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2541</a> </td>
                                                    <td>Jamal Burnett</td>
                                                    <td>
                                                        07 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $380
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-danger-subtle text-danger font-size-12">Chargeback</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-visa me-1"></i> Visa
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck4">
                                                            <label class="form-check-label"
                                                                for="customCheck4">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2542</a> </td>
                                                    <td>Juan Mitchell</td>
                                                    <td>
                                                        06 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $384
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-success-subtle text-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-paypal me-1"></i> Paypal
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck5">
                                                            <label class="form-check-label"
                                                                for="customCheck5">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2543</a> </td>
                                                    <td>Barry Dick</td>
                                                    <td>
                                                        05 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $412
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-success-subtle text-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck6">
                                                            <label class="form-check-label"
                                                                for="customCheck6">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2544</a> </td>
                                                    <td>Ronald Taylor</td>
                                                    <td>
                                                        04 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $404
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-warning-subtle text-warning font-size-12">Refund</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-visa me-1"></i> Visa
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck7">
                                                            <label class="form-check-label"
                                                                for="customCheck7">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);"
                                                            class="text-body fw-bold">#MB2545</a> </td>
                                                    <td>Jacob Hunter</td>
                                                    <td>
                                                        04 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $392
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-success-subtle text-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-paypal me-1"></i> Paypal
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row --> --}}


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            @include('layouts.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('layouts.partials.right-sidebar')

    @include('script.modal')

    <script type="text/javascript" src="{{ asset('admin_asset/assets/scripts/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin_asset/assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function alertKu(tipe, isi = "kosongan") {
            var public_path = $('#public_path').val(); /* di layouts */
            if (isi == 'kosongan') {
                isi = tipe;
                tipe = 'warning';
            }
            var warnabtn = "#FF5722";
            if (tipe == 'success') {
                warnabtn = "#4CAF50";
            }

            Swal.fire({
                title: "",
                html: isi,
                icon: tipe,
                confirmButtonColor: warnabtn,
                confirmButtonText: "Ok !",
            });
        }
    </script>

    {{-- Adjustable Minible Script --}}
    <!-- JAVASCRIPT -->
    {{-- <script src="{{ asset('theme_assets/libs/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('theme_assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme_assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('theme_assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme_assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('theme_assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('theme_assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('theme_assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('theme_assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('theme_assets/js/app.js') }}"></script>


    <script src="{{ asset('theme_assets/theme-adjustable.js') }}"></script>
    {{-- End Adjustable Minible Script --}}

    {{-- GSAP Script --}}
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/Flip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
    <script>
        // use a script tag or an external JS file
        document.addEventListener("DOMContentLoaded", (event) => {
            gsap.registerPlugin(Flip, ScrollTrigger)
            // gsap code here!

            gsap.to('.afu-gsap-scale', {
                scale: 1.1,
                duration: 0.5,
                repeat: -1,
                yoyo: true,
            })
        });
    </script>
    {{-- End GSAP Script --}}

    @yield('script')
    @stack('scripts')
</body>

</html>
