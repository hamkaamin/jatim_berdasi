<table class="table align-items-center table-flush" id="myTable">
    <thead class="thead-light">
        <tr>
            <th style="min-width: 200px;text-align:center;">No.</th>
            <th style="min-width: 100px;text-align:center;">Nama Perangkat Daerah Kota / Kab</th>
            <th style="min-width: 200px;text-align:center;">Judul</th>
            <th style="min-width: 200px;text-align:center;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->penilaian->sum('pivot.nilai') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
