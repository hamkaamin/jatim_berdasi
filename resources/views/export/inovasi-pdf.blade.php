<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inovasi - {{ $inovasi->kode }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }

        [type="checkbox"] {
            vertical-align: middle;
        }

        ol li {
            justify-content: space-between !important;
        }

        .has_tab {
            text-indent: 30px;
        }

        .border {
            border: 1px solid black;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            padding: 0px;
            margin: 0px;
        }

        ,
        .page-break {
            page-break-inside: auto;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td><img src="{{ public_path('brida-logo.png') }}" width="50" alt=""></td>
            <td>
                <h2>Badan Riset dan Inovasi Daerah (BRIDA)</h2>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <h1>LAPORAN INOVASI DAERAH</h1>
                <br>
                <h2>Pemerintah Daerah:
                    @if ($inovasi->kelurahan_id != null)
                        KELURAHAN {{ $inovasi->kelurahan->name }}
                    @elseif ($inovasi->kecamatan_id != null)
                        KECAMATAN {{ $inovasi->kecamatan->name }}
                    @elseif ($inovasi->kota_id != null)
                        {{ $inovasi->kota->name }}
                    @else
                        {{ $inovasi->provinsi->name }}
                    @endif
                </h2>
                <h3>Nomor Registrasi : {{ $inovasi->kode }}</h3>
            </td>
        </tr>
    </table>
    <br><br>
    <table style="width: 100%;table-layout:fixed" class="page-break">
        <tr>
            <td>
                <h2>1. PROFIL INOVASI</h2>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.1. Nama Inovasi</b><br>
                {{ $inovasi->nama }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.2. Dibuat Oleh</b><br>
                {{ $inovasi->user->name }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.3. Tahapan Inovasi</b><br>
                {{ $inovasi->belongsToTahapan->nama }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.4. Inisiator Inovasi Daerah</b><br>
                {{ $inovasi->inisiator_id != null ? $inovasi->inisiator->nama : '-' }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.5. Jenis Inovasi</b><br>
                {{ $inovasi->jenis_id != null ? $inovasi->jenis->nama : '-' }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.6. Bentuk Inovasi Daerah</b><br>
                {{ $inovasi->bentuk_id != null ? $inovasi->bentuk->nama : '-' }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.7. Urusan Inovasi Daerah</b><br>
                @foreach ($inovasi->urusan()->get() as $item)
                    {{ $item->nama }}@if (!$loop->last)
                        ,&nbsp;
                    @endif
                @endforeach <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.8 Kategori</b><br>
                @foreach ($inovasi->kategori()->get() as $item)
                    {{ $item->nama }}@if (!$loop->last)
                        ,&nbsp;
                    @endif
                @endforeach <br><br>
            </td>
        </tr>
    </table>
    <div class="page-break">
        <b>1.9. Rancang Bangun dan Pokok Perubahan Yang Dilakukan</b><br>
        <p><strong>Tipe Badan Perencanaan Pembangunan Daerah Kabupaten Banyuwangi</strong> berdasarkan
            Peraturan
            Daerah Kabupaten Banyuwangi Nomor 6 Tahun 2020 Tentang Perubahan Kedua Atas Peraturan Daerah
            Nomor 8
            Tahun 2016 Tentang Pembentukan Dan Susunan Perangkat Daerah Pasal 2 huruf e ayat 1. Badan
            Perencanaan Pembangunan Daerah merupakan Badan Tipe A melaksanakan fungsi penunjang urusan
            pemerintahan bidang perencanaan, dan bidang penelitian dan pengembangan.</p>
        <p><strong>Visi pembangunan daerah Kabupaten Banyuwangi</strong> untuk periode RPJMD 2021-2026 yaitu
        </p>
        <p>“Terwujudnya Banyuwangi yang Semakin Maju, Sejahtera, dan Berkah”</p>
        <p>Misi Pembangunan dalam RPJMD Kabupaten Banyuwangi tahun 2021-2026 adalah sebagai berikut:</p>
        <p>1. Membangun Ekonomi Inklusif dan Pemerataan Infrastruktur yang mampu mengungkit produktifitas
            sektor
            unggulan dan menguatkan ketahanan lingkungan;</p>
        <p>2. Membangun SDM Unggul Berkarakter dan Harmonisasi Sosial yang Kondusif;</p>
        <p>3. Membangun Layanan Publik dan Tatakelola Pemerintahan yang Inovatif dan Dinamis.</p>
        <p><strong>Kebijakan inovasi</strong> daerah tertuang dalam Misi 3 yaitu Membangun Layanan Publik
            dan
            Tatakelola Pemerintahan yang Inovatif dan Dinamis. Pemerintah Kabupaten Banyuwangi terus
            berupaya
            untuk mewujudkan pelayanan publik dan tata kelola pemerintahan yang inovatif dan dinamis karena
            sangat berdampak pada kesejahteraan masyarakat. Birokrasi diharapkan dapat menjadi katalisator
            untuk
            mereformasi dengan menghilangkan segala hambatan dalam birokrasi terkait dengan pelayanan kepada
            masyarakat melalui akuntabilitas kinerja, inovasi daerah, kapasitas ASN, transformasi digital
            pada
            layanan publik.&nbsp;Dalam Membangun Layanan Publik dan Tatakelola Pemerintahan yang Inovatif
            dan
            Dinamis, salah satu strategi yaitu mengembangkan sistem pemerintahan yang dinamis dan adaptif
            melalui reformasi manajemen pemerintahan dan menguatkan inovasi pelayanan keseluruh layanan
            sampai
            desa.&nbsp;</p>
        <p><strong>Regulasi Inovasi Daerah</strong> Kabupaten Banyuwangi tertuang pada Peraturan Bupati
            Banyuwangi Nomor 27 Tahun 2022 Tentang Perubahan Atas Peraturan Bupati Banyuwangi Nomor 59 Tahun
            2021 Tentang Inovasi Daerah Kabupaten Banyuwangi.&nbsp;inovasi daerah yang telah dilaksanakan
            oleh
            seluruh Perangkat Daerah di Kabupaten Banyuwangi yang meliputi:</p>
        <ul>
            <li>299 inovasi pada 28 Dinas/badan;</li>
            <li>29&nbsp;Inovasi pada 2 RSUD; dan</li>
            <li>65 Inovasi pada 25 Kecamatan.</li>
        </ul>
        <p><strong>Amanat Undang-undang Nomor 23 Tahun 2014</strong> tentang Pemerintahan Daerah pasal 368
            dijelaskan bahwa dalam rangka peningkatan kinerja penyelenggaraan Pemerintahan Daerah,
            Pemerintah
            Daerah dapat melakukan inovasi. Inovasi merupakan semua bentuk pembaharuan dalam penyelenggaraan
            Pemerintahan Daerah. Penyelenggaraan inovasi daerah yaitu untuk mewujudkan kesejahteraan
            masyarakat.&nbsp;</p>
        <p>Berbagai upaya dilakukan untuk memacu Perangkat Daerah dan ASN di Kabupaten Banyuwangi untuk
            dapat
            terus mengembangkan ide-ide dan kreativitas dalam menumbuh kembangkan inovasi daerah.&nbsp;Dalam
            hal
            ini Peran BAPPEDA Kabupaten Banyuwangi sebagai Salah satu Perangkat Daerah yang menjadi
            pengungkit
            dan Pendorong seluruh Perangkat Daerah di Kabupaten Banyuwangi untuk terus menumbuhkan budaya
            inovatif dan kreatif dalam meningkatkan pelayanan publik. Oleh karena itu perlu dilakukan
            upaya-upaya strategis untuk mendorong ASN Pemerintah Kabupaten Banyuwangi tetap menjadi ASN dan
            Perangkat Daerah yang inovatif dan kreatif.&nbsp;</p>
        <p><strong>Beberapa upaya yang dilakukan oleh Pemerintah Kabupaten Banyuwangi dalam menumbuhkan
                budaya
                inovatif dan kreatif yaitu</strong> dengan melaksanakan beberapa terobosan sebagaimana
            berikut:
        </p>
        <p>1.Memberikan Dana Insentif Inovasi&nbsp;</p>
        <p>DINDA WANGI (Dana Insentif Inovasi Daerah Kabupaten Banyuwangi) merupakan penghargaan atas
            penerapan
            hasil inovasi daerah berupa dana insentif yang diberikan kepada Perangkat Daerah untuk
            mengembangankan inovasi Daerah. Perhitungan berdasarkan jumlah inovasi daerah yang dilaksanakan
            dan
            jumlah penghargaan terkait inovasi yang diperoleh oleh Perangkat Daerah.&nbsp;</p>
        <p>Kegiatan ini dimaksudkan agar dapat mendorong kompetisi positif antar Perangkat Daerah di
            Kabupaten
            Banyuwangi dalam penyelenggaraan pemerintahan daerah, dalam peningkatan pelayanan kepada
            masyarakat
            dan peningkatan pembangunan, guna terwujudnya kesejahteraan rakyat dan daya saing daerah.</p>
        <p>2. Mengadakan Lomba Inovasi</p>
        <p>Pemerintah Kabupaten Banyuwangi menyelenggarakan Kompetisi Inovasi Daerah Kabupaten Banyuwangi
            (KOINWANGI) dalam rangka menjaring inovasi-inovasi terbaik yang dapat meningkatkan daya saing
            daerah
            serta memberikan penghargaan/apresiasi kepada ASN dan Perangkat Daerah yang inovatif.</p>
        <p>3. Memberikan Reward dan Punishment&nbsp;</p>
        <p>Pemerintah Kabupaten Banyuwangi menerapkan Rapor SKPD yang merupakan laporan hasil penilaian
            kinerja
            SKPD berdasarkan perencanaan kinerja dengan indikator dan target kinerja sesuai ketentuan yang
            berlaku. Hasil kinerja dari Rapor SKPD yang penilaiannya meliputi Komponen Rapor Umum dan
            Komponen
            Rapor Khusus.</p>
        <ul>
            <li>Komponen Rapor Umum dalam Rapor SKPD&nbsp;meliputi :</li>
        </ul>
        <p>a. Perencanaan dan pengendalian pembangunan;</p>
        <p>b. Pelaporan kinerja;</p>
        <p>c. Pengelolaan anggaran dan barang milik daerah;</p>
        <p>d. Pengawasan;</p>
        <p><strong>e. Inovasi;</strong></p>
        <p>f. Pengadaan Barang dan Jasa.</p>
        <ul>
            <li>Komponen Rapor Khusus dalam Rapor SKPD berupa kinerja Indikator Kinerja&nbsp;Utama SKPD.
            </li>
        </ul>
        <p>&nbsp;</p>
        <p>Sebagai Salah satu Perangkat Daerah yang inovatif, di Tahun 2023 BAPPEDA Kabupaten Banyuwangi
            telah
            menjalankan beberapa inovasi diantaranya yaitu:</p>
        <ol>
            <li>UGDK</li>
        </ol>
        <p>Unit Gawat Darurat Kemiskinan (UGDK) adalah aplikasi yang dibangun sebagai rumah besar program
            penanggulangan kemiskinan di Kabupaten Banyuwangi yang bersifat multi sektor. Aplikasi ini
            memberikan kemudahan kepada para pemangku kepentingan untuk bisa mengetahui jumlah penduduk
            miskin
            by name, by address, by NIK, by problem yang mereka hadapi, lokasi tempat tinggal (GIS) penduduk
            miskin, program yang sudah diterima, siapa yag belum terima program dan intervensi program yang
            akan
            diberikan, sehingga program penanggulangan kemiskinan yang direncanakan tepat sasaran, tepat
            jumlah
            dan tepat waktu. UGDK juga menyediakan menu verifikasi dan validasi data kemiskinan untuk
            pemutakhiran data kemiskinan sesuai dengan kondisi terkini penduduk miskin.&nbsp;</p>
        <p>2. GIS Banyuwangi</p>
        <p>Geographic Information System (GIS) Kabupaten Banyuwangi adalah suatu sistem informasi yang
            menyajikan peta digital berbasis website untuk memudahkan pencarian data informasi spasial
            Kabupaten
            Banyuwangi seperti peta wilayah administrasi, jaringan infrastruktur, rencana tata ruang, daerah
            rawan bencana, atau kegiatan&nbsp; data-data spasial lainnya, serta data &amp; informasi lokasi
            pelaksanaan pekerjaan SKPD Teknis.</p>
        <p>3. Partisipasi Perencanaan Pembangunan Kewilayahan</p>
        <p>Strategi dalam inovasi ini yaitu pemberian pagu indikatif pada pelaksanaan Musrenbang&nbsp;yang
            terbagi menjadi 2 yaitu&nbsp;pagu indikatif kecamatan (PIK) dan&nbsp;pagu indikatif&nbsp;Khusus
            Infrastruktur.&nbsp;pagu indikatif kecamatan (PIK)&nbsp;didasarkan pada beberapa variable
            seperti
            luas wilayah, jumlah penduduk, infrastruktur, angka kemiskinan, indeks pendidikan, dan indeks
            kesehatan. Semakin rendah capaian kinerja indikatornya, semakin besar alokasi PIK yang diperoleh
            oleh kecamatan tersebut. Pagu Indikatif Kecamatan (PIK) Infrastruktur Jalan merupakan alokasi
            anggaran yang diberikan kepada desa-desa sebagai reward atau penghargaan atas kinerja realisasi
            penerimaan Pajak Bumi dan Bangunan (PBB) di masing-masing wilayahnya.</p>
        <p>4. MADANI (Manajemen Data Inovasi Daerah Kabupaten Banyuwangi)</p>
        <p>MADANI merupakan salah satu bagian dari manajemen pengetahuan di Kabupaten Banyuwangi yang
            berisikan
            tentang publikasi dan database Inovasi daerah di Kabupaten Banyuwangi. Dengan adanya MADANI
            masyarakat dapat dengan mudah mengetahui informasi program-program pemerintah kabupaten
            Banyuwangi.
            selain itu juga berfungsi sebagai database Inovasi dan mempermudah Perangkat Daerah dalam
            menyimpan
            berkas portofolio inovasi daerah.</p>
    </div>
    <table>
        <tr>
            <td>
                <b>1.10. Tujuan Inovasi Daerah</b><br>
                {!! $inovasi->tujuan !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.11. Manfaat yang Diperoleh</b><br>
                {!! $inovasi->manfaat !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.12. Hasil Inovasi</b><br>
                {!! $inovasi->hasil !!} <br><br>
            </td>
        </tr>
        @php
            $counter = 3;
        @endphp
        @foreach ($kolom as $item)
            <tr>
                <td>
                    <b>1.1{{ $counter }}. Waktu {{ $item->nama }} Inovasi</b><br>
                    @php
                        $temp = $item
                            ->belongsToManyInovasi()
                            ->where('inovasi_id', $inovasi->id)
                            ->first();
                    @endphp
                    {{ $temp != null && $temp->pivot->waktu != null ? date('d-m-Y', strtotime($temp->pivot->waktu)) : '-' }}
                    <br><br>
                </td>
            </tr>
            @php
                $counter++;
            @endphp
        @endforeach
        <tr>
            <td>
                <b>1.1{{ $counter }}. Anggaran</b><br>
                @if ($inovasi->anggaran != null && file_exists(public_path('/file_anggaran/' . $inovasi->anggaran)))
                    {{ asset('file_anggaran/' . $inovasi->anggaran) }}
                @else
                    -
                @endif <br><br>
            </td>
        </tr>
        <tr>
            @php $counter++; @endphp
            <td>
                <b>1.1{{ $counter }}. Profil Bisnis</b><br>
                @if ($inovasi->profil_bisnis != null && file_exists(public_path('/file_profil_bisnis/' . $inovasi->profil_bisnis)))
                    {{ asset('file_profil_bisnis/' . $inovasi->profil_bisnis) }}
                @else
                    -
                @endif <br><br>
            </td>
        </tr>
        <tr>
            @php $counter++; @endphp
            <td>
                <b>1.1{{ $counter }}. Kematangan</b><br>
                {{ $inovasi->indikator->sum('pivot.bobot_akhir') != null ? $inovasi->indikator->sum('pivot.bobot_akhir') : 0 }}
                <br><br>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <h2>2. INDIKATOR INOVASI</h2>
            </td>
        </tr>
    </table>
    <table class="border" style="margin-top: 0.5em; width: 100%">
        <tr>
            <th>No.</th>
            <th style="text-align: left">Indikator SPD</th>
            <th style="text-align: left">Informasi</th>
            <th style="text-align: left">Bukti Dukung</th>
        </tr>
        @foreach ($inovasi->indikator()->get() as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}.</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->pivot->param_awal != null ? $item->pivot->param_awal : '-' }}</td>
                <td>
                    @php
                        $temp = $inovasi
                            ->upload()
                            ->where('indikator_id', $item->id)
                            ->where('file', '<>', null);
                    @endphp
                    @if ($temp->count() > 0)
                        @foreach ($temp->get() as $upload)
                            @if (file_exists(public_path('/indikator_uploads/' . $upload->file)))
                                <a href="{{ asset('indikator_uploads/' . $upload->file) }}">File
                                    {{ $loop->iteration }}</a><br>
                            @endif
                        @endforeach
                    @else
                        Tidak ada data
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
