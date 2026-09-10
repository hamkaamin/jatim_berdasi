<html>
<head>
    <title>{{ $proposal->kode }} {{ $proposal->judul }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table{
            border-collapse: collapse;
        }
        .table tr td, .table tr th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    @php $nojuri=0; @endphp
    @foreach ($kelompok_juri as $user_id)
    @php $nojuri++; @endphp
    @php
        $penilaian_map = App\Models\PenilaianKovablikMap::whereIn('juri_id', function ($query) use ($user_id) {
            $query->select('id')->from('juris')->where('user_id', $user_id);
        })
            ->where('proposal_id', $proposal->id)
            ->where('juri_tahap', $juri_tahap)
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
    <table style="width: 100%" border="0">
        <tr>
            <td style="width: 150px">Kategori</td>
            <td style="width: 2%">:</td>
            <td colspan="2">{{ $proposal->kategori->nama_singkat ?? ($proposal->kategori->nama ?? ' ') }}</td>
        </tr>
        <tr>
            <td>Judul Inovasi</td>
            <td>:</td>
            <td colspan="2">{{ $proposal->judul }}</td>
        </tr>
        <tr>
            <td>Penilai / Juri</td>
            <td>:</td>
            <td>{{ App\Models\User::find($user_id)->name }}</td>
            <td style="vertical-align: top">
                @if(!empty($penilaian_map->signature_path))
                <img src="{{ $ttd }}" style="max-width: 120px">
                @endif
            </td>
        </tr>
    </table>
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
                $rows = $data
                    ->where('pivot.user_id', $user_id)
                    ->where('pivot.juri_tahap', $juri_tahap)
                    ->sortBy('id')
                    ->values();
                $tree = \App\Helper\Helper::buildAspekTree($rows);
                $totalNilai = $rows->whereNull('parent_id')->sum(fn($r) => optional($r->pivot)->nilai);
            @endphp
            @include('penilaian.partials.rekap-node', [
                'nodes' => $tree,
                'depth' => 0,
                'prefix' => '',
            ])
            <tr>
                <td colspan="4" style="text-align: right"><b>Total Nilai</b></td>
                <td style="text-align: center"><b>{{ round($totalNilai, 2) }}</b></td>
            </tr>
        </tbody>
    </table>
    @if(sizeof($kelompok_juri) > 1 && $nojuri < sizeof($kelompok_juri))
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
