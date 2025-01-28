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
    <script src="https://www.google.com/recaptcha/api.js"></script>


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
    </style>
</head>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">

                                @php
                                    $fase_aktif = App\Models\Fase::where('timer', 1)->first();
                                @endphp
                                @if ($fase_aktif)
                                    <div class="timer">
                                        <span class="timer-title">Fase {{ $fase_aktif->nama ?? 'saleh' }} Berakhir
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
                                            var countDownDate = new Date(" 2025-03-03 12:38:00").getTime();

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
                                <div class="top-menu ms-auto">
                                    &nbsp;
                                    &nbsp;
                                    <a href="javascript:;" data-toggle="modal" data-target="#modalPopup"
                                        onclick="modal(0,'setting')">
                                        <span class="badge bg-primary badge-sm text-light  me-1 mb-1 mt-1">
                                            {{ Auth::user()->name }} - {{ @Auth::user()->tahun }}
                                        </span>
                                    </a>
                                </div>

                                <div class="widget-content-left ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{ ucwords(Auth::user()->name) }}
                                    </div>
                                    <div class="widget-subheading">
                                        {{ Helper::getRole(Auth::user()->role) }}
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <a href="{{ route('profil.index') }}"
                                        class="btn-shadow p-1 btn btn-secondary btn-sm"><i
                                            class="fas fa-user-cog pr-1 pl-1"></i></a>
                                    <form action="{{ route('logout') }}" method="post" style="all: unset">
                                        @csrf
                                        <button type="submit" class="btn-shadow p-1 btn btn-danger btn-sm"
                                            onclick="if(!confirm('Apakah Anda yakin akan logout?')){return false;}">
                                            <i class="fas fa-power-off text-white pr-1 pl-1"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scrollbar-container"></div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        @include('layouts.menu')
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    @yield('title')
                                    <div class="page-title-subheading">@yield('title-desc')</div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                @yield('buttons')
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @include('layouts.alert')
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-right">
                                <ul class="nav">
                                    <li class="nav-item">
                                        © {{ date('Y') }} <a href="#">SI-INOVASI</a>. All Rights Reserved
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    @yield('script')
    @stack('scripts')
</body>

</html>
