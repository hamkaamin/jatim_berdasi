<ul class="vertical-nav-menu">
    @if (Auth::user()->role == 1)
        <li class="app-sidebar__heading">Home</li>
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
        {{-- <li>
            <a href="{{ route('master.definisi.index') }}"
                class="{{ Request::routeIs('master.definisi.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-ribbon"></i> Definisi Operasional
            </a>
        </li> --}}
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
        @if (env('APP_HIDE_FAQ') == 0)
            <li>
                <a href="{{ route('master.faq.index') }}"
                    class="{{ Request::routeIs('master.faq.*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-ribbon"></i> FAQ
                </a>
            </li>
        @endif
        <li class="app-sidebar__heading">Pengaturan Akun</li>
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
    @else
        <li class="app-sidebar__heading">Dashboard</li>
        <li>
            <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-home"></i> Dashboard
            </a>
        </li>
        {{-- <li>
			<a href="#" class="">
				<i class="metismenu-icon pe-7s-file"></i> Arsip
			</a>
		</li> --}}
        @if (env('APP_HIDE_FAQ') == 0)
            <li>
                <a href="{{ route('faq.index') }}" class="{{ Request::routeIs('faq.*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-info"></i> FAQ
                </a>
            </li>
        @endif
        <div style="display: none">
            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="app-sidebar__heading">Database Inovasi Daerah</li>
                <li>
                    <a href="{{ route('profil-pemda.index') }}"
                        class="{{ Request::routeIs('profil-pemda.*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-user"></i> Profil Pemda
                    </a>
                </li>
            @endif
        </div>
        <li class="app-sidebar__heading">Data Inovasi Daerah</li>
        @if (env('APP_OPD_JATIM') == 0)

            @if (Auth::user()->role == 5)
                <li>
                    <a href="{{ route('inovasi.index', ['area' => 'provinsi']) }}"
                        class="{{ request()->is('inovasi/provinsi') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-light"></i> Inovasi Daerah (Provinsi)
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('inovasi.index', ['area' => 'daerah']) }}"
                        class="{{ request()->is('inovasi/daerah') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-light"></i> Inovasi Daerah
                    </a>
                </li>
                <li>
                    <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                        class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-light"></i> Inovasi Daerah (Kota / Kab)
                    </a>
                </li>
            @endif
        @else
            <li>
                <a href="{{ route('inovasi.index', ['area' => 'kota']) }}"
                    class="{{ request()->is('inovasi/kota') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> Inovasi Daerah
                </a>
            </li>
        @endif

        @if (env('APP_PROVINSI_JATIM') == 0)
            @if (env('APP_OPD_JATIM') == 1)
                <li class="app-sidebar__heading">Lomba Inovasi</li>
            @else
                <li class="app-sidebar__heading">Lomba Inovasi Daerah</li>
            @endif
            @if (Auth::user()->role != 6)
                {{-- <li>
                <a href="{{ route('inovasi.index', ['area' => 'pemda']) }}"
                    class="{{ request()->is('inovasi/pemda') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-light"></i> Inovasi Pemda
                </a>
            </li> --}}
            @endif
            @if (env('APP_OPD_JATIM') == 1)
                <li>
                    <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                        class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-light"></i> Inotek Awards {{ env('APP_NAMA_APLIKASI') }}
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}"
                        class="{{ request()->is('inovasi/masyarakat') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-light"></i> Inotek Awards
                    </a>
                </li>
            @endif
            {{-- <li class="app-sidebar__heading">Laporan</li>
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
            </li> --}}
        @endif


        <li>
            <a href="{{ route('bank_data.index', ['area' => 'bank_data']) }}"
                class="{{ Request::routeIs('bank_data.*') ? 'mm-active' : '' }}">
                <i class="metismenu-icon pe-7s-light"></i> Bank Data
            </a>
        </li>
        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
            <li class="app-sidebar__heading">Konfigurasi</li>
            <li>
                <a href="{{ route('pengguna.index') }}"
                    class="{{ Request::routeIs('pengguna.*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-users"></i> Accounts
                </a>
            </li>
            <li>
                <a href="{{ route('opd.index') }}" class="{{ Request::routeIs('opd.*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-note2"></i> Daftar PD
                </a>
            </li>
            {{-- <li>
			<a href="#" class="">
				<i class="metismenu-icon pe-7s-global"></i> Akses API
			</a>
		</li> --}}
        @endif
    @endif
    <li class="app-sidebar__heading">Panduan Aplikasi</li>
    <li>
        <a href="{{ route('panduan') }}" class="{{ Request::routeIs('panduan.*') ? 'mm-active' : '' }}">
            <i class="metismenu-icon pe-7s-notebook"></i> Panduan
        </a>
    </li>
</ul>
