<li class="menu-title">Penilaian Juri</li>

<li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}"">
        <i class="uil-home-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="{{ Request::is('penilaian*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="uil-file-check"></i>
        <span>Penilaian</span>
    </a>
    <ul class="sub-menu" aria-expanded="true">
        @if(Auth::user()->menu_iga == 1)
        <li class="{{ Request::is('penilaian/iga') && request('jenis') == 'iga' ? 'mm-active' : '' }}">
            <a href="{{ route('penilaian.index', ['jenis' => 'iga']) }}"
                class="{{ Request::is('penilaian/iga') && request('jenis') == 'iga' ? 'active' : '' }}">IGA</a>
        </li>
        @endif 
        @if(Auth::user()->menu_inotek == 1)
        <li class="{{ Request::is('penilaian/inotek') ? 'mm-active' : '' }}">
            <a href="{{ route('penilaian.index', ['jenis' => 'inotek']) }}"
                class="{{ Request::is('penilaian/inotek') ? 'active' : '' }}">Inotek Awards</a>
        </li>
        @endif 
    </ul>
</li>

<li class="menu-title">Panduan Aplikasi</li>
<li class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
    <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'active' : '' }}">
        <i class="metismenu-icon pe-7s-notebook"></i> <span>Panduan</span>
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
