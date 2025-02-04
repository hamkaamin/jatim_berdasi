@if (Auth::user()->role == 1)
    <li class="menu-title">Home</li>
    <li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}"">
            <i class="uil-home-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    {{-- <li>
<a href="{{ route('pengumuman.index') }}" class="{{ Request::routeIs('pengumuman') ? 'mm-active' : '' }}">
<i class="metismenu-icon pe-7s-home"></i> Pengumuman
</a> --}}
    </li>
    <li class="menu-title">Master Data</li>
    <li class="{{ Request::routeIs('master.indikator.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.indikator.index') }}"
            class="{{ Request::routeIs('master.indikator.*') ? 'active' : '' }}">
            <i class="uil-home-alt"></i> <span>Indikator & Parameter</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.tahapan.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.tahapan.index') }}"
            class="{{ Request::routeIs('master.tahapan.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Tahapan Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.kategoritahapan.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.kategoritahapan.index') }}"
            class="{{ Request::routeIs('master.kategoritahapan.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Kategori Per Tahapan Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.inisiator.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.inisiator.index') }}"
            class="{{ Request::routeIs('master.inisiator.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Inisiator Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.jenis.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.jenis.index') }}" class="{{ Request::routeIs('master.jenis.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Jenis Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.urusan.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.urusan.index') }}"
            class="{{ Request::routeIs('master.urusan.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Urusan Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.bentuk.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.bentuk.index') }}"
            class="{{ Request::routeIs('master.bentuk.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Bentuk Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.jabatan.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.jabatan.index') }}"
            class="{{ Request::routeIs('master.jabatan.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Jabatan Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.definisi.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.definisi.index') }}"
            class="{{ Request::routeIs('master.definisi.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Definisi Operasional</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.golongan.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.golongan.index') }}"
            class="{{ Request::routeIs('master.golongan.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Golongan Inovasi</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.kategori.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.kategori.index') }}"
            class="{{ Request::routeIs('master.kategori.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Kategori Inovasi</span>
        </a>
    </li>

    <li class="{{ Request::routeIs('master.tematik.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.tematik.index') }}"
            class="{{ Request::routeIs('master.tematik.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Tematik</span>
        </a>
    </li>
    <li class="{{ Request::routeIs('master.detail_tematik.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.detail_tematik.index') }}"
            class="{{ Request::routeIs('master.detail_tematik.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Detail Tematik</span>
        </a>
    </li>
    @if (env('APP_HIDE_FAQ') == 0)
        <li class="{{ Request::routeIs('master.faq.*') ? 'mm-active' : '' }}">
            <a href="{{ route('master.faq.index') }}" class="{{ Request::routeIs('master.faq.*') ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> <span>FAQ</span>
            </a>
        </li>
    @endif
    <li class="menu-title">Pengaturan Akun</li>
    <li class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
        <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-note2"></i> <span>Daftar OPD</span>
        </a>
    </li>

    <li style="display: none;" class="{{ Request::routeIs('master.kategoriopd.*') ? 'mm-active' : '' }}">
        <a href="{{ route('master.kategoriopd.index') }}"
            class="{{ Request::routeIs('master.kategoriopd.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-ribbon"></i> <span>Kategori OPD</span>
        </a>
    </li>

    <li class="{{ Request::routeIs('setting.*') ? 'mm-active' : '' }}">
        <a href="{{ route('setting.index') }}" class="{{ Request::routeIs('setting.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-note2"></i> <span>Setting</span>
        </a>
    </li>
    @for ($i = 1; $i < 5; $i++)
        <li class="{{ Request::routeIs('master.kategori_opd.index', $i) ? 'mm-active' : '' }}">
            <a href="{{ route('master.kategori_opd.index', $i) }}"
                class="{{ Request::routeIs('master.kategori_opd.index', $i) ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> <span>Kategori {{ $i }}</span>
            </a>
        </li>
    @endfor



    <li class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
        <a href="{{ route('pengguna.index') }}" class="{{ Request::routeIs('pengguna.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-users"></i> <span>Pengguna</span>
        </a>
    </li>
@else
    <li class="menu-title">Home</li>
    <li class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
        <a href="{{ route('home') }}" class="class="{{ Request::routeIs('home') ? 'active' : '' }}"">
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
    @if (env('APP_OPD_JATIM') == 0)

        @if (Auth::user()->role == 5)
            <li class="{{ request()->is('inovasi/provinsi') ? 'mm-active' : '' }}">
                <a href="{{ route('inovasi.index', ['area' => 'provinsi']) }}"
                    class="{{ request()->is('inovasi/provinsi') ? 'active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> <span>Inovasi Daerah (Provinsi)</span>
                </a>
            </li>
        @else
            <li class="{{ request()->is('inovasi/daerah') ? 'mm-active' : '' }}">
                <a href="{{ route('inovasi.index', ['area' => 'daerah']) }}"
                    class="{{ request()->is('inovasi/daerah') ? 'active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> <span>Inovasi Daerah</span>
                </a>
            </li>
            <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
                <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                    class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> <span>Inovasi Daerah (Kota /
                        Kab)</span>
                </a>
            </li>
        @endif
    @else
        <li class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
            <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                class="{{ request()->is('inovasi/kota') ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-light"></i> <span>Inovasi Daerah</span>
            </a>
        </li>
    @endif

    @if (env('APP_PROVINSI_JATIM') == 0)
        @if (env('APP_OPD_JATIM') == 1)
            <li class="menu-title">Lomba Inovasi</li>
        @else
            <li class="menu-title">Lomba Inovasi Daerah</li>
        @endif
        @if (Auth::user()->role != 6)
            {{-- <li>
<a href="{{ route('inovasi.index', ['area' => 'pemda']) }}"
class="{{ request()->is('inovasi/pemda') ? 'active' : '' }}">
<i class="metismenu-icon pe-7s-light"></i> <span>Inovasi Pemda</span>
</a>
</li> --}}
        @endif
        @if (env('APP_OPD_JATIM') == 1)
            <li class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                    class="{{ request()->is('inovasi/masyarakat') ? 'active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> <span>Inotek Awards
                        {{ env('APP_NAMA_APLIKASI') }}</span>
                </a>
            </li>
        @else
            <li class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                    class="{{ request()->is('inovasi/masyarakat') ? 'active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> <span>Inotek Awards</span>
                </a>
            </li>
        @endif
        {{-- <li class="menu-title">Laporan</li>
<li>
<a href="{{ route('rekap.index', 'jenis') }}"
class="{{ request()->is('rekap/jenis') ? 'mm-active' : '' }}">
<i class="metismenu-icon pe-7s-graph1"></i> <span>Rekap Jenis Inovasi</span>
</a>
</li>
<li>
<a href="{{ route('rekap.index', 'bentuk') }}"
class="{{ request()->is('rekap/bentuk') ? 'mm-active' : '' }}">
<i class="metismenu-icon pe-7s-graph1"></i> <span>Rekap Bentuk Inovasi</span>
</a>
</li>
<li>
<a href="{{ route('rekap.index', 'urusan') }}"
class="{{ request()->is('rekap/urusan') ? 'mm-active' : '' }}">
<i class="metismenu-icon pe-7s-graph1"></i> <span>Rekap Urusan Pemerintah</span>
</a>
</li>
<li>
<a href="{{ route('rekap.index', 'inisiator') }}"
class="{{ request()->is('rekap/inisiator') ? 'mm-active' : '' }}">
<i class="metismenu-icon pe-7s-graph1"></i> <span>Rekap Berdasarkan Inisiator</span>
</a>
</li> --}}
    @endif


    <li class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
        <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
            class="{{ Request::routeIs('bank_data.*') ? 'active' : '' }}">
            <i class="metismenu-icon pe-7s-light"></i> <span>Bank Data</span>
        </a>
    </li>
    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
        <li class="menu-title">Konfigurasi</li>
        <li class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
            <a href="{{ route('pengguna.index') }}" class="{{ Request::routeIs('pengguna.*') ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-users"></i> <span>Accounts</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
            <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'active' : '' }}">
                <i class="metismenu-icon pe-7s-note2"></i> <span>Daftar PD</span>
            </a>
        </li>
        {{-- <li>
<a href="#" class="">
<i class="metismenu-icon pe-7s-global"></i> <span>Akses API</span>
</a>
</li> --}}
    @endif
@endif
<li class="menu-title">Panduan Aplikasi</li>
<li class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
    <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'active' : '' }}">
        <i class="metismenu-icon pe-7s-notebook"></i> <span>Panduan</span>
    </a>
</li>

<li class="{{ Request::routeIs('master.fase.*') ? 'mm-active' : '' }}">
    <a href="{{ route('master.fase.index') }}" class="{{ Request::routeIs('master.fase.*') ? 'active' : '' }}">
        <i class="metismenu-icon pe-7s-timer"></i> <span>Fase</span>
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
<a href="javascript: void(0);" class="has-arrow waves-effect">
    <i class="uil-share-alt"></i>
    <span>Multi Level</span>
</a>
<ul class="sub-menu" aria-expanded="true">
    <li><a href="javascript: void(0);">Level 1.1</a></li>
    <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="javascript: void(0);">Level 2.1</a></li>
            <li><a href="javascript: void(0);">Level 2.2</a></li>
        </ul>
    </li>
</ul>
</li> --}}
