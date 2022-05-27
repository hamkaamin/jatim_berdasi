@extends('layouts.main')

@section('title')
    Rekap {{ ucwords($type) }} Inovasi
@endsection

@section('title-desc')
    Daftar Rekap {{ ucwords($type) }} Inovasi
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush" id="myTable">
					<thead class="thead-light">
						<tr>
							<th>No.</th>
							<th>{{ ucwords($type) }} Inovasi</th>
							<th>Total Disetujui</th>
                            <th>Total Keseluruhan</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->inovasi()->where('status', 2)->count() }}</td>
                                <td>{{ $item->inovasi()->where('status', '<>', 0)->count() }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('script')
	@include('script.dataTable')
	@include('script.modal')
@endsection
