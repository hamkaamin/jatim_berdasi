<table class="table align-items-center table-flush" id="myTable">
    <thead class="thead-light">
        <tr>
            <th>No.</th>
            <th style="min-width: 100px">Dibuat Oleh</th>
            <th style="min-width: 200px">Nama</th>
            <th>Nilai</th>
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
