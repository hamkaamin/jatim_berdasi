<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-home"></i> Dashboard</li>
    <li>
        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-home"></i> Dashboard
        </a>
    </li>
    @if (env('APP_HIDE_FAQ') == 0)
        <li>
            <a href="{{ route('faq.index') }}" class="{{ Request::routeIs('faq.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-info"></i> FAQ
            </a>
        </li>
    @endif

    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-rocket"></i> Data Inovasi Daerah</li>

    <li class="">
        <a href="#" aria-expanded="false">
            <i class="metismenu-icon pe-7s-rocket"></i>Lomba Inovasi
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul class="mm-collapse" style="height: 7.04px;">
            <li>
                <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                    class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> IGA
                </a>
            </li>

            <li>
                <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                    class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> Inotek Awards {{ env('APP_NAMA_APLIKASI') }}
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
            class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-light"></i> Bank Data
        </a>
    </li>

    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-notebook"></i> Panduan Aplikasi</li>
    <li>
        <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-notebook"></i> Panduan
        </a>
    </li>

</ul>
