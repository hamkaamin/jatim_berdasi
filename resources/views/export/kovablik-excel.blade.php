<table>
    <tr>
        <th>Data</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>Nomor Registrasi</td>
        <td>{{ $proposal->kode }}</td>
    </tr>
    <tr>
        <td>Judul Inovasi</td>
        <td>{{ $proposal->judul }}</td>
    </tr>
    <tr>
        <td>Dibuat Oleh</td>
        <td>{{ $proposal->nama_inovator }}</td>
    </tr>
    <tr>
        <td>Kategori Inovasi</td>
        <td>
            @foreach ($proposal->kategori()->get() as $item)
                {{ $item->nama }}@if (!$loop->last),&nbsp; @endif
            @endforeach
        </td>
    </tr>
    <tr>
        <td>Ringkasan</td>
        <td>{{ strip_tags($proposal->ringkasan) }}</td>
    </tr>
    <tr>
        <td>Latar Belakang dan Tujuan</td>
        <td>{{ strip_tags($proposal->latar_belakang) }}</td>
    </tr>
    <tr>
        <td>Kebaruan/Nilai Tambah</td>
        <td>{{ strip_tags($proposal->nilai_tambah) }}</td>
    </tr>
    <tr>
        <td>Implementas Inovasi</td>
        <td>{{ strip_tags($proposal->implementasi) }}</td>
    </tr>
    <tr>
        <td>Signifikansi</td>
        <td>{{ strip_tags($proposal->signifikansi) }}</td>
    </tr>
    <tr>
        <td>Adaptabilitas</td>
        <td>{{ strip_tags($proposal->adaptabilitas) }}</td>
    </tr>
    <tr>
        <td>Sumber Daya</td>
        <td>{{ strip_tags($proposal->sumber_daya) }}</td>
    </tr>
    <tr>
        <td>Strategi Keberlanjutan</td>
        <td>{{ strip_tags($proposal->strategi_keberlanjutan) }}</td>
    </tr>
</table>
