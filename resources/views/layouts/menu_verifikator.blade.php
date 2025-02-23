<li class="menu-title">Home</li>
<li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
        <i class="uil-home-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="menu-title">Lomba Inovasi Daerah</li>
@if (env('APP_OPD_JATIM') == 0)
    <li class="{{ request()->is('inovasi/daerah') ? 'mm-active' : '' }}">
        <a href="{{ route('inovasi.index', ['area' => 'daerah']) }}"
            class="{{ request()->is('inovasi/daerah') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-light"></i> <span>IGA</span>
        </a>
    </li>

    <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
        <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
            class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-light"></i> <span>INOTEK AWARDS</span>
        </a>
    </li>
@else
    <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
        <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
            class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-light"></i> <span>INOTEK AWARDS</span>
        </a>
    </li>
@endif

<li class="menu-title">Bank Data</li>
<li class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
    <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
        class="{{ Request::routeIs('bank_data.*') ? 'active' : '' }}">
        <i class="metismenu-icon pe-7s-light"></i> <span>Bank Data</span>
    </a>
</li>


<li class="menu-title">Panduan Aplikasi</li>
<li class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
    <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'active' : '' }}">
        <i class="metismenu-icon pe-7s-notebook"></i> <span>Panduan</span>
    </a>
</li>
