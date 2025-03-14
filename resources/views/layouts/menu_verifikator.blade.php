<li class="menu-title">Home</li>
<li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
        <i class="uil-home-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="menu-title">Lomba Inovasi Daerah</li>
@if (env('APP_OPD_JATIM') == 0)
    @if (Auth::user()->menu_iga == 1)
        <li class="{{ request()->is('inovasi/daerah') ? 'mm-active' : '' }}">
            <a href="{{ route('inovasi.index', ['area' => 'daerah']) }}"
                class="{{ request()->is('inovasi/daerah') ? 'active' : '' }}">
                <i class="uil-trophy"></i> <span>IGA</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->menu_inotek == 1)
        <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
            <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
                <i class="uil-medal"></i> <span>INOTEK AWARDS</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->menu_kovablik == 1)
        <li class="{{ request()->is('kovablik/masyarakat') ? 'mm-active' : '' }}">
            <a href="{{ route('kovablik.index', ['area' => 'masyarakat']) }}"
                class="{{ request()->is('kovablik/masyarakat') ? 'active' : '' }}">
                <i class="uil-award"></i> <span>KOVABLIK</span>
            </a>
        </li>
    @endif
@else
    <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
        <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
            class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
            <i class="uil-medal"></i> <span>INOTEK AWARDS</span>
        </a>
    </li>
@endif

<li class="menu-title">Bank Data</li>
<li class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
    <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
        class="{{ Request::routeIs('bank_data.*') ? 'active' : '' }}">
        <i class="uil-books pe-7s-light"></i> <span>Bank Data</span>
    </a>
</li>

<li class="{{ Request::is('penilaian/ranking*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="uil-file-check"></i>
        <span>Ranking Penilaian</span>
    </a>
    <ul class="sub-menu" aria-expanded="true">
        @if (Auth::user()->menu_iga == 1)
            <li class="{{ Request::is('penilaian/ranking/iga') && request('jenis') == 'iga' ? 'mm-active' : '' }}">
                <a href="{{ route('penilaian.ranking', ['jenis' => 'iga']) }}"
                    class="{{ Request::is('penilaian/ranking/iga') && request('jenis') == 'iga' ? 'active' : '' }}">IGA</a>
            </li>
        @endif
        @if (Auth::user()->menu_inotek == 1)
            <li
                class="{{ Request::is('penilaian/ranking/inotek') && request('jenis') == 'inotek' ? 'mm-active' : '' }}">
                <a href="{{ route('penilaian.ranking', ['jenis' => 'inotek']) }}"
                    class="{{ Request::is('penilaian/ranking/inotek') && request('jenis') == 'inotek' ? 'active' : '' }}">Inotek
                    Awards</a>
            </li>
        @endif
    </ul>
</li>


<li class="menu-title">Panduan Aplikasi</li>
<li class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
    <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'active' : '' }}">
        <i class="uil-video pe-7s-notebook"></i> <span>Panduan</span>
    </a>
</li>
