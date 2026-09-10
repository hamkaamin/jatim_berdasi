<table>
    <thead>
        <tr>
            <th style="min-width: 200px;text-align:center;font-weight:bold">No.</th>
            <th style="min-width: 100px;text-align:center;font-weight:bold">Nama Perangkat Daerah Kota / Kab</th>
            <th style="min-width: 200px;text-align:center;font-weight:bold">Judul</th>
            <th style="min-width: 200px;text-align:center;font-weight:bold">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->penilaian->whereNull('parent_id')->sum('pivot.nilai') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
