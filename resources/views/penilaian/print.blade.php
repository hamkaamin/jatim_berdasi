<html>
<head>
    <title>{{ $inovasi->kode }} {{ $inovasi->nama }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @php $nojuri=0; @endphp
    @foreach ($kategori_juri as $user_id)
    @php $nojuri++; @endphp
    <table style="width: 100%" border="0">
        <tr>
            <td style="width: 150px">Kategori</td>
            <td style="width: 2%">:</td>
            <td>{{ $inovasi->kategori->nama_singkat ?? ' ' }}</td>
        </tr>
        <tr>
            <td>Judul Inovasi</td>
            <td>:</td>
            <td>{{ $inovasi->nama }}</td>
        </tr>
        <tr>
            <td>Penilai / Juri</td>
            <td>:</td>
            <td>{{ App\Models\User::find($user_id)->name }}</td>
        </tr>
    </table> 
    @if(sizeof($kategori_juri) > 1 && $nojuri < sizeof($kategori_juri))
    <div class="page-break"></div>
    @endif 
    @endforeach
</body>
</html>