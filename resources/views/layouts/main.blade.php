<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="{{ asset(env('APP_LOGO' ?? 'login.png')) }}">
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
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
    <script type="text/javascript" src="{{ asset('admin_asset/assets/scripts/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')
</body>

</html>
