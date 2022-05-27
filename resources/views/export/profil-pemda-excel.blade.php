<table>
    <tr>
        <th>No.</th>
        <th>Indikator SPD</th>
        <th>Informasi</th>
        <th>Bobot Akhir</th>
        <th>Keterangan</th>
    </tr>
    @foreach ($provinsi->indikator()->get() as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ strip_tags($item->keterangan) }}</td>
            <td>{{ $item->pivot->bobot_akhir }}</td>
            <td>{{ $item->pivot->catatan }}</td>
        </tr>
    @endforeach
</table>
