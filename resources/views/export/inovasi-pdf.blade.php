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
            @php
                $logo = 'login.png';
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
            @php
                dd(public_path($logo));
            @endphp
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
                @endif
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
                <b>1.8. Waktu Ujicoba Inovasi</b><br>
                {{ $inovasi->waktu_uji_coba ?? '-' }} <br><br>
                <br><br>
            </td>
        </tr>

        <tr>
            <td>
                <b>1.9. Waktu Penerapan Inovasi</b><br>
                {{ $inovasi->waktu_penerapan ?? '-' }} <br><br>
                <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.10. Waktu Pengembangan Inovasi</b><br>
                {{ $inovasi->waktu_pengembangan ?? '-' }} <br><br>
                <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.11 Kategori</b><br>
                @foreach ($inovasi->kategori()->get() as $item)
                    {{ $item->nama }}@if (!$loop->last)
                        ,&nbsp;
                    @endif
                @endforeach <br><br>
            </td>
        </tr>
    </table>
    <div class="page-break">
        <b>1.12. Rancang Bangun dan Pokok Perubahan Yang Dilakukan</b><br>
        {!! $inovasi->rancang_bangun !!}
    </div>
    <table>
        <tr>
            <td>
                <b>1.13. Tujuan Inovasi Daerah</b><br>
                {!! $inovasi->tujuan !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.14. Manfaat yang Diperoleh</b><br>
                {!! $inovasi->manfaat !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.15. Hasil Inovasi</b><br>
                {!! $inovasi->hasil !!} <br><br>
            </td>
        </tr>
        @php
            $counter = 6;
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
                <b>1.1{{ $counter }}. Dokumen HAKI</b><br>
                @if ($inovasi->file_anggaran != null && file_exists(public_path('/file_anggaran/' . $inovasi->file_anggaran)))
                    {{ asset('file_anggaran/' . $inovasi->file_anggaran) }}
                @else
                    -
                @endif <br><br>
            </td>
        </tr>
        <tr>
            @php $counter++; @endphp
            <td>
                <b>1.1{{ $counter }}. Dokumen Penghargaan</b><br>
                @if ($inovasi->file_penghargaan != null && file_exists(public_path('/file_penghargaan/' . $inovasi->file_penghargaan)))
                    {{ asset('file_penghargaan/' . $inovasi->file_penghargaan) }}
                @else
                    -
                @endif <br><br>
            </td>
        </tr>
        <tr>
            @php $counter++; @endphp
            <td>
                <b>1.20. Kematangan</b><br>
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
                            @if ($upload->file != null)
                                <a href="{{ $upload->file }}">File {{ $loop->iteration }}</a><br>
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
