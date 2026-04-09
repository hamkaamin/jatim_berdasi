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

    <link href="{{ asset('admin_asset/afu.css') }}" rel="stylesheet">

    <style>
        .app-header__logo .logo-src {
            background-image: url({{ env('APP_LOGO_NAVBAR', 'logo-inovasi-daerah.png') }});
            background-size: contain;
            /* Menyesuaikan ukuran gambar tanpa memotong */
            background-repeat: no-repeat;
            /* Mencegah gambar diulang */
        }

        .timer {
            background: rgb(57, 57, 57);
            color: white;
            -webkit-border-top-right-radius: 30px;
            -webkit-border-top-left-radius: 30px;
            -moz-border-radius-topright: 30px;
            -moz-border-radius-topleft: 30px;
            border-top-right-radius: 30px;
            border-top-left-radius: 30px;
            width: 33vh;
            padding: 6px;
            position: fixed;
            bottom: 0px;
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

        .dataTables_wrapper table.table {
            width: 100% !important;
        }

        .closed-sidebar:not(.closed-sidebar-mobile) .app-header .app-header__logo .logo-src.afu {
            display: block;
        }

        .app-header__mobile-menu .app-header__logo {
            display: block;
        }

        .card {
            border: 1px #5b73e8 solid;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            border-color: #3f6ad8;
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
        @include('partials.navbar')

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
                        @include('layouts.menu-container')
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
                                    <div class=" ">@yield('title-desc')</div>
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
                            <div class="card">
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

    {{-- GSAP CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/Flip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/Observer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollToPlugin.min.js"></script>

    <!-- RoughEase, ExpoScaleEase and SlowMo are all included in the EasePack file -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/EasePack.min.js"></script>
    {{-- End GSAP CDN --}}

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

    {{-- Navbar builder --}}
    <script>
        // Get all div elements
        let lis = document.querySelectorAll('.afu.menu-container .vertical-nav-menu li');

        // Iterate through each div
        lis.forEach(li => {
            // Check if the li does NOT have the .app-sidebar__heading class
            if (!li.classList.contains('app-sidebar__heading')) {
                // Find the nearest .app-sidebar__heading element before this li
                let previousElement = li.previousElementSibling;

                // Traverse backwards to find the nearest .app-sidebar__heading
                while (previousElement && !previousElement.classList.contains('app-sidebar__heading')) {
                    previousElement = previousElement.previousElementSibling;
                }

                // If a .app-sidebar__heading is found, move the current li into it
                if (previousElement && previousElement.classList.contains('app-sidebar__heading')) {
                    // Check if a .box already exists in the .container
                    let box = previousElement.querySelector('.sub-menu');

                    // If no .box exists, create one
                    if (!box) {
                        box = document.createElement('ul');
                        box.classList.add('sub-menu');
                        previousElement.appendChild(box);
                    }

                    // Move the current li into the .box
                    box.appendChild(li);
                }
            }
        });
    </script>
    {{-- End Navbar builder --}}

    <script defer>
        // use a script tag or an external JS file
        document.addEventListener("DOMContentLoaded", (event) => {
            gsap.registerPlugin(Flip, ScrollTrigger, Observer, ScrollToPlugin, SlowMo)

            const liHeaders = document.querySelectorAll(
                '.afu.menu-container .app-sidebar__heading'
            );

            liHeaders.forEach(li => {

                const animationFunction = () => {
                    const state = Flip.getState(
                        ".afu.menu-container .sub-menu, .afu.menu-container .sub-menu li, .afu.menu-container .sub-menu a"
                    );

                    li.classList.toggle('hover');

                    Flip.from(state, {
                        duration: 0.3,
                        ease: "power1.inOut",
                    });
                };
                li.addEventListener('mouseover', () => {
                    animationFunction();
                });

                li.addEventListener('mouseout', () => {
                    animationFunction();
                });
            });
        });
    </script>

    @yield('script')
    @stack('scripts')
</body>

</html>
