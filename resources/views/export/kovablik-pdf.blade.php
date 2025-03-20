<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kovablik - {{ $proposal->kode }}</title>
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
            @php
                $logo = 'brida-logo.png';
                $width = '50';
            @endphp
            @if (env('APP_NAME') == 'BRAVO BANGKALAN')
                @php
                    $logo = 'admin_asset/logo-bangkalan.png';
                    $width = '100';
                @endphp
            @elseif(env('APP_NAME') == 'JEMBER SIABANG')
                @php
                    $logo = 'admin_asset/logo-kabupatenjember.png';
                    $width = '100';
                @endphp
            @endif
            <td><img src="{{ public_path($logo) }}" width={{ $width }} alt=""></td>
            <td>
                @php $nama_app = 'Badan Riset dan Inovasi Daerah (BRIDA)'; @endphp
                @if (env('APP_NAME') == 'BRAVO BANGKALAN')
                    @php
                        $nama_app = 'Pemerintah Kabupaten Bangkalan <br>
Bangkalan Kreatif, Inovatif dan Teknologi (BRAVO) ';
                    @endphp
                @elseif(env('APP_NAME') == 'JEMBER SIABANG')
                    @php
                        $nama_app = 'SIABANG, Pemerintah Kabupaten Jember ';
                    @endphp
                @endif
                <h2>{!! $nama_app !!}</h2>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <h1>LAPORAN INOVASI DAERAH</h1>
                <br>
                @if ('APP_NAME' == 'INOVASI DAERAH')
                    <h2>Pemerintah Daerah:
                        @if ($proposal->kelurahan_id != null)
                            KELURAHAN {{ $proposal->kelurahan->name }}
                        @elseif ($proposal->kecamatan_id != null)
                            KECAMATAN {{ $proposal->kecamatan->name }}
                        @elseif ($proposal->kota_id != null)
                            {{ $proposal->kota->name }}
                        @else
                            {{ $proposal->provinsi->name }}
                        @endif
                    </h2>
                @endif
                <h3>Nomor Registrasi : {{ $proposal->kode }}</h3>
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
                {{ $proposal->judul }} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.2. Dibuat Oleh</b><br>
                {{ $proposal->nama_inovator }} <br><br>
            </td>
        </tr>

        <tr>
            <td>
                <b>1.9. Waktu Penerapan Inovasi</b><br>
                {{ $proposal->tanggal_mulai ?? '-' }} <br><br>
                <br><br>
            </td>
        </tr>
        
        <tr>
            <td>
                <b>1.11 Kategori</b><br>
                @foreach ($proposal->kategori()->get() as $item)
                    {{ $item->nama }}@if (!$loop->last)
                        ,&nbsp;
                    @endif
                @endforeach <br><br>
            </td>
        </tr>
    </table>
    <div class="page-break">
        <b>1.12. Ringkasan</b><br>
        {!! $proposal->ringkasan !!}
    </div>
    <table>
        <tr>
            <td>
                <b>1.13. Latar Belakang dan Tujuan Inovasi Daerah</b><br>
                {!! $proposal->latar_belakang !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.14. Kebaruan/Nilai Tambah</b><br>
                {!! $proposal->nilai_tambah !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.15. Implementasi Inovasi</b><br>
                {!! $proposal->implementasi !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.16. Signifikansi</b><br>
                {!! $proposal->signifikansi !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.17. Adaptabilitas</b><br>
                {!! $proposal->adaptabilitas !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.18. Sumber Daya</b><br>
                {!! $proposal->sumber_daya !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.19. Strategi Keberlanjutan</b><br>
                {!! $proposal->strategi_keberlanjutan !!} <br><br>
            </td>
        </tr>
    </table>
</body>

</html>
