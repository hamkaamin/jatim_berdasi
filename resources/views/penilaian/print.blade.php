<html>

<head>
    <title>{{ $inovasi->kode }} {{ $inovasi->nama }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table {
            border-collapse: collapse;
        }

        .table tr td,
        .table tr th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    @php $nojuri=0; @endphp
    @foreach ($kategori_juri as $user_id)
        @php $nojuri++; @endphp
        @php
            $penilaian_map = App\Models\PenilaianMap::whereIn('juri_id', function ($query) use (
                $user_id,
                $inovasi,
                $juri_tahap,
            ) {
                $query->select('id')->from('juris')->where('user_id', $user_id)->where('juri_tahap', $juri_tahap);
            })
                ->where('inovasi_id', $inovasi->id)
                ->first();
            $ttd = null;
            if (!empty($penilaian_map->signature_path)) {
                $path = public_path($penilaian_map->signature_path);
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $filenya = file_get_contents($path);
                    $ttd = 'data:image/' . $type . ';base64,' . base64_encode($filenya);
                }
            }
        @endphp
        <table class="table" style="width: 100%" border="0">
            <tr>
                <td colspan="3" style="text-align: center">{{ $inovasi->kategori->nama ?? ' ' }}</td>
            </tr>
            <tr>
                <td>Judul Inovasi</td>
                <td colspan="2">{{ $inovasi->nama }}</td>
            </tr>
            <tr>
                <td>Penilai / Juri</td>
                <td>{{ App\Models\User::find($user_id)->name }}</td>
                <td style="vertical-align: top">

                    @if (!empty($penilaian_map->signature_path))
                        <img src="{{ $ttd }}" style="max-width: 120px">
                    @endif
                </td>
            </tr>
        </table>
        <br>
        <table class="table" style="width: 100%" border="0">
            <thead class="thead-light">
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Bagian</th>
                    <th style="text-align: center;">Indikator</th>
                    <th style="text-align: center;min-width: 150px;">Catatan & Saran</th>
                    <th style="text-align: center;min-width: 100px;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalNilai = 0;
                    $no = 0;
                @endphp
                @foreach ($data as $item)
                    @if ($item->pivot->user_id == $user_id)
                        @php $no++; @endphp
                        <tr>
                            <td style="text-align: center">{{ $no }}</td>
                            <td>{{ $item->bagian }}</td>
                            <td>{!! $item->indikator !!}</td>
                            <td>
                                @if ($item->pivot->catatan_saran)
                                    {{ $item->pivot->catatan_saran }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center">
                                <h4><b>{{ $item->pivot->nilai }}</b></h4>
                            </td>
                        </tr>
                        @php
                            $totalNilai += $item->pivot->nilai;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: right"><b>Total Nilai</b></td>
                    <td style="text-align: center"><b>{{ $totalNilai }}</b></td>
                </tr>
            </tbody>
        </table>
        @if (sizeof($kategori_juri) > 1 && $nojuri < sizeof($kategori_juri))
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
