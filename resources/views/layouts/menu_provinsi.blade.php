<li class="menu-title">Home</li>
<li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
        <i class="uil-home-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
{{-- <li>
<a href="#" class="">
<i class="metismenu-icon pe-7s-file"></i> <span>Arsip</span>
</a>
</li> --}}
@if (env('APP_HIDE_FAQ') == 0)
    <li class="{{ Request::routeIs('faq.*') ? 'mm-active' : '' }}">
        <a href="{{ route('faq.index') }}" class="{{ Request::routeIs('faq.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-info"></i> <span>FAQ</span>
        </a>
    </li>
@endif
<div style="display: none">
    @if (Auth::user()->role == 2 || Auth::user()->role == 3)
        <li class="menu-title">Database Inovasi Daerah</li>
        <li class="{{ Request::routeIs('profil-pemda.*') ? 'mm-active' : '' }}">
            <a href="{{ route('profil-pemda.index') }}"
                class="{{ Request::routeIs('profil-pemda.*') ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-user"></i> <span>Profil Pemda</span>
            </a>
        </li>
    @endif
</div>
<li class="menu-title">Data Inovasi Daerah</li>
@php
    $fase = App\Models\Fase::where('active', 1)->where('timer', 1)->get();
    $faseName = $fase ? $fase->pluck('nama')->toArray() : [];
@endphp
@if(Auth::user()->menu_inotek == 1)
    @if(in_array('inovasi', $faseName) || in_array('kovablik', $faseName))
        <li class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
            <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                class="{{ request()->is('inovasi/masyarakat') ? 'active' : '' }}">
                <i class="uil-medal"></i> <span>Lomba Inovasi</span>
            </a>
        </li>
    @else
        <li>
            <a href="javascript:;" onclick="alertKu('warning', 'Fase penginputan Lomba Inovasi sedang ditutup, silakan coba lagi lain waktu')">
                <i class="uil-medal"></i> <span>Lomba Inovasi</span>
            </a>
        </li>
    @endif
@endif

@if(Auth::user()->menu_iga == 1)
    @if(in_array('iga', $faseName))
        <li class="{{ request()->is('inovasi/provinsi') ? 'mm-active' : '' }}">
            <a href="{{ route('inovasi.index', ['area' => 'provinsi']) }}"
                class="{{ request()->is('inovasi/provinsi') ? 'active' : '' }}">
                <i class="uil-trophy"></i> <span>IGA</span>
            </a>
        </li>
    @else
        <li>
            <a href="javascript:;" onclick="alertKu('warning', 'Fase penginputan IGA sedang ditutup, silakan coba lagi lain waktu')">
                <i class="uil-trophy"></i> <span>IGA</span>
            </a>
        </li>
    @endif
@endif

<li class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
    <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
        class="{{ Request::routeIs('bank_data.*') ? 'active' : '' }}">
        <i class="uil-books pe-7s-light"></i> <span>Bank Data</span>
    </a>
</li>
<li class="menu-title">Panduan Aplikasi</li>
<li class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
    <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'active' : '' }}">
        <i class="uil-video pe-7s-notebook"></i> <span>Panduan</span>
    </a>
</li>



{{-- <li>
<a href="javascript: void(0);" class="has-arrow waves-effect">
    <i class="uil-window-section"></i>
    <span>Layouts</span>
</a>
<ul class="sub-menu" aria-expanded="true">
    <li>
        <a href="javascript: void(0);" class="has-arrow">Vertical</a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="layouts-dark-sidebar.html">Dark Sidebar</a></li>
            <li><a href="layouts-compact-sidebar.html">Compact Sidebar</a></li>
            <li><a href="layouts-icon-sidebar.html">Icon Sidebar</a></li>
            <li><a href="layouts-boxed.html">Boxed Width</a></li>
            <li><a href="layouts-preloader.html">Preloader</a></li>
            <li><a href="layouts-colored-sidebar.html">Colored Sidebar</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">Horizontal</a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="layouts-horizontal.html">Horizontal</a></li>
            <li><a href="layouts-hori-topbar-dark.html">Topbar Dark</a></li>
            <li><a href="layouts-hori-boxed-width.html">Boxed Width</a></li>
            <li><a href="layouts-hori-preloader.html">Preloader</a></li>
        </ul>
    </li>
</ul>
</li> --}}



{{-- <li>

        <ul class="sub-menu" aria-expanded="true">
            <li><a href="javascript: void(0);">Level 2.1</a></li>
            <li><a href="javascript: void(0);">Level 2.2</a></li>
        </ul>
    </li>
</ul>
</li> --}}
