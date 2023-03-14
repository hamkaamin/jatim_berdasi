<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inovasi - {{ $inovasi->kode }}</title>
    <style>
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
    <table>
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
                <b>1.8. Rancang Bangun dan Pokok Perubahan Yang Dilakukan</b><br>
                {!! $inovasi->rancang_bangun !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.9. Tujuan Inovasi Daerah</b><br>
                {!! $inovasi->tujuan !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.10. Manfaat yang Diperoleh</b><br>
                {!! $inovasi->manfaat !!} <br><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>1.11. Hasil Inovasi</b><br>
                {!! $inovasi->hasil !!} <br><br>
            </td>
        </tr>
        @php
            $counter = 2;
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
