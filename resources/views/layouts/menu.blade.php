<ul class="vertical-nav-menu">
    @if (Auth::user()->role == 1)
        <li class="app-sidebar__heading">Home</li>
        <li>
            <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-home"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('pengumuman.index') }}" class="{{ Request::routeIs('pengumuman') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-home"></i> Pengumuman
            </a>
        </li>
        <li class="app-sidebar__heading">Master Data</li>
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
            <a href="{{ route('master.golongan.index') }}"
                class="{{ Request::routeIs('master.golongan.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> Golongan Inovasi
            </a>
        </li>
        <li>
            <a href="{{ route('master.faq.index') }}"
                class="{{ Request::routeIs('master.faq.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> FAQ
            </a>
        </li>
        <li class="app-sidebar__heading">Pengaturan Akun</li>
        <li>
            <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-note2"></i> Daftar OPD
            </a>
        </li>
        <li>
            <a href="{{ route('pengguna.index') }}" class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-users"></i> Pengguna
            </a>
        </li>
    @else
        <li class="app-sidebar__heading">Dashboard</li>
        <li>
            <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-home"></i> Dashboard IGA
            </a>
        </li>
        {{-- <li>
			<a href="#" class="">
				<i class="metismenu-icon pe-7s-file"></i> Arsip
			</a>
		</li> --}}
        <li>
            <a href="{{ route('faq.index') }}" class="{{ Request::routeIs('faq.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-info"></i> FAQ
            </a>
        </li>
        @if (Auth::user()->role == 2 || Auth::user()->role == 3)
            <li class="app-sidebar__heading">Database Inovasi Daerah</li>
            <li>
                <a href="{{ route('profil-pemda.index') }}"
                    class="{{ Request::routeIs('profil-pemda.*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-user"></i> Profil Pemda
                </a>
            </li>
        @endif
        @if (Auth::user()->role != 4)
            <li class="app-sidebar__heading">Database Inovasi Daerah</li>

            <li>
                <a href="{{ route('inovasi.index', ['area' => 'daerah']) }}"
                    class="{{ request()->is('inovasi/daerah') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> Inovasi Daerah
                </a>
            </li>
        @endif
        <li class="app-sidebar__heading">Lomba Inovasi Daerah</li>
        @if (Auth::user()->role != 6)
            <li>
                <a href="{{ route('inovasi.index', ['area' => 'pemda']) }}"
                    class="{{ request()->is('inovasi/pemda') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> Inovasi Pemda
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-light"></i> Inovasi Masyarakat
            </a>
        </li>
        <li class="app-sidebar__heading">Laporan</li>
        <li>
            <a href="{{ route('rekap.index', 'jenis') }}"
                class="{{ request()->is('rekap/jenis') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-graph1"></i> Rekap Jenis Inovasi
            </a>
        </li>
        <li>
            <a href="{{ route('rekap.index', 'bentuk') }}"
                class="{{ request()->is('rekap/bentuk') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-graph1"></i> Rekap Bentuk Inovasi
            </a>
        </li>
        <li>
            <a href="{{ route('rekap.index', 'urusan') }}"
                class="{{ request()->is('rekap/urusan') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-graph1"></i> Rekap Urusan Pemerintah
            </a>
        </li>
        <li>
            <a href="{{ route('rekap.index', 'inisiator') }}"
                class="{{ request()->is('rekap/inisiator') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-graph1"></i> Rekap Berdasarkan Inisiator
            </a>
        </li>
        <li class="app-sidebar__heading">Konfigurasi</li>
        <li>
            <a href="{{ route('pengguna.index') }}" class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-users"></i> Accounts
            </a>
        </li>
        <li>
            <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-note2"></i> Daftar OPD
            </a>
        </li>
        {{-- <li>
			<a href="#" class="">
				<i class="metismenu-icon pe-7s-global"></i> Akses API
			</a>
		</li> --}}
    @endif
</ul>
