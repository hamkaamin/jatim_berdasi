<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil Pemda - {{ $provinsi->id }}</title>
    <style>
        .border {
            border: 1px solid black;
        }
        h1, h2, h3, h4, h5, h6 {
            padding: 0px; margin: 0px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td><img src="https://1.bp.blogspot.com/-b3vWcyqsWP8/YUncfnrwd3I/AAAAAAAAI9E/UtKFWrrbQ8EirvaiRerip6iQrUvYawqoACLcBGAsYHQ/s752/logo-kemendagri.png" width="50" alt=""></td>
            <td><h2>KEMENTERIAN<br>DALAM NEGERI</h2></td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <h1>LAPORAN INDEKS DAERAH</h1>
                <br>
                <h2>Pemerintah Daerah: PROVINSI {{ $provinsi->name }}
                </h2>
            </td>
        </tr>
    </table>
    <br><br>
    <table>
        <tr>
            <td><h2>1. PROFIL PEMERINTAH DAERAH</h2></td>
        </tr>
    </table>
    <table class="border" style="margin-top: 0.5em; width: 100%">
        <tr>
            <th>No.</th>
            <th style="text-align: left">Indikator SPD</th>
            <th style="text-align: left">Informasi</th>
            <th style="text-align: left">Bukti Dukung</th>
        </tr>
        @foreach ($provinsi->indikator()->get() as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}.</td>
                <td>{{ $item->nama }}</td>
                <td>{!! $item->keterangan !!}</td>
                <td>
                    @php
                        $temp = $item->upload()->where('provinsi_id', $provinsi->id)->where('file', '<>', null);
                    @endphp
                    @if ($temp->count() > 0)
                        @foreach ($temp->get() as $upload)
                            @if (file_exists(public_path('/indikator_uploads/'.$upload->file)))
                                <a href="{{ asset('indikator_uploads/'.$upload->file) }}">File {{ $loop->iteration }}</a><br>
                            @endif
                        @endforeach
                    @else
                        Tidak ada data
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <table>
        <tr>
            <td><h2>2. DAFTAR INOVASI</h2></td>
        </tr>
    </table>
    <table class="border" style="margin-top: 0.5em; width: 100%">
        <tr>
            <th>No.</th>
            <th style="text-align: left">Inovasi</th>
        </tr>
        @foreach ($provinsi->inovasi()->get() as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}.</td>
                <td>{{ $item->nama }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
