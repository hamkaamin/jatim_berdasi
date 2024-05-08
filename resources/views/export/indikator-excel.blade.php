<table>
    <tr>
        <th>No.</th>
        <th>Indikator Inovasi</th>
        <th>Informasi</th>
        <th>Bobot Awal</th>
        <th>Parameter Awal</th>
        <th>Bobot Akhir</th>
        <th>Parameter Akhir</th>
        <th>Keterangan</th>
        <th>Dokumen Pendukung</th>
    </tr>
    @foreach ($inovasi->indikator()->get() as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ strip_tags($item->keterangan) }}</td>
            <td>{{ $item->pivot->bobot_awal != null ? $item->pivot->bobot_awal : 0 }}</td>
            <td>{{ $item->pivot->param_awal != null ? $item->pivot->param_awal : '-' }}</td>
            <td>{{ $item->pivot->bobot_akhir != null ? $item->pivot->bobot_akhir : 0 }}</td>
            <td>{{ $item->pivot->param_akhir != null ? $item->pivot->param_akhir : '-' }}</td>
            <td>{{ $item->pivot->catatan }}</td>
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
                <td>Tidak ada data</td>
            @endif
        </tr>
    @endforeach
</table>
