<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-home"></i> Home</li>
    <li>
        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-home"></i> Dashboard
        </a>
    </li>
    {{-- <li>
            <a href="{{ route('pengumuman.index') }}" class="{{ Request::routeIs('pengumuman') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-home"></i> Pengumuman
            </a> --}}
    </li>
    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-note2"></i> Pengaturan Akun</li>
    <li>
        <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-note2"></i> Daftar OPD
        </a>
    </li>

    <li style="display: none;">
        <a href="{{ route('master.kategoriopd.index') }}"
            class="{{ Request::routeIs('master.kategoriopd.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Kategori OPD
        </a>
    </li>

    {{-- <li>
        <a href="{{ route('setting.index') }}" class="{{ Request::routeIs('setting.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-note2"></i> Setting
        </a>
    </li> --}}
    @for ($i = 1; $i < 5; $i++)
        <li>
            <a href="{{ route('master.kategori_opd.index', $i) }}"
                class="{{ Request::routeIs('master.kategori_opd.index', $i) ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> Kategori {{ $i }}
            </a>
        </li>
    @endfor

    <li>
        <a href="{{ route('pengguna.index') }}" class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-users"></i> Pengguna
        </a>
    </li>

    <li>
        <a href="{{ route('master.fase.index') }}" class="{{ Request::routeIs('master.fase.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-timer"></i> Fase
        </a>
    </li>
    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-ribbon"></i> Penilaian Juri</li>

    <li>
        <a href="{{ route('master.penilaian.index') }}"
            class="{{ Request::routeIs('master.penilaian.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Penilaian
        </a>
    </li>

    <li>
        <a href="{{ route('master.juri.index') }}" class="{{ Request::routeIs('master.juri.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Juri
        </a>
    </li>


    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-ribbon"></i> Master Data</li>
    <li>
        <a href="{{ route('master.indikator.index') }}"
            class="{{ Request::routeIs('master.indikator.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Indikator & Parameter
        </a>
    </li>
    <li>
        <a href="{{ route('master.tahapan.index') }}"
            class="{{ Request::routeIs('master.tahapan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Tahapan Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.kategoritahapan.index') }}"
            class="{{ Request::routeIs('master.kategoritahapan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Kategori Per Tahapan Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.inisiator.index') }}"
            class="{{ Request::routeIs('master.inisiator.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Inisiator Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.jenis.index') }}"
            class="{{ Request::routeIs('master.jenis.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Jenis Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.urusan.index') }}"
            class="{{ Request::routeIs('master.urusan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Urusan Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.bentuk.index') }}"
            class="{{ Request::routeIs('master.bentuk.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Bentuk Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.jabatan.index') }}"
            class="{{ Request::routeIs('master.jabatan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Jabatan Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.definisi.index') }}"
            class="{{ Request::routeIs('master.definisi.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Definisi Operasional
        </a>
    </li>
    <li>
        <a href="{{ route('master.golongan.index') }}"
            class="{{ Request::routeIs('master.golongan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Golongan Inovasi
        </a>
    </li>
    <li>
        <a href="{{ route('master.kategori.index') }}"
            class="{{ Request::routeIs('master.kategori.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Kategori Inovasi
        </a>
    </li>

    <li>
        <a href="{{ route('master.tematik.index') }}"
            class="{{ Request::routeIs('master.tematik.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Tematik
        </a>
    </li>
    <li>
        <a href="{{ route('master.detail_tematik.index') }}"
            class="{{ Request::routeIs('master.detail_tematik.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> Detail Tematik
        </a>
    </li>
    @if (env('APP_HIDE_FAQ') == 0)
        <li>
            <a href="{{ route('master.faq.index') }}"
                class="{{ Request::routeIs('master.faq.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> FAQ
            </a>
        </li>
    @endif
    <li class="app-sidebar__heading"><i class="afu metismenu-icon pe-7s-notebook"></i> Panduan Aplikasi</li>
    <li>
        <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-notebook"></i> Panduan
        </a>
    </li>
</ul>
