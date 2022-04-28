@extends('layouts.main')

@section('title')
    Master Jenis Inovasi
@endsection

@section('title-desc')
    Daftar Jenis untuk Data Inovasi
@endsection

@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'jenis')">Tambah Data</button>
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush" id="myTable">
					<thead class="thead-light">
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th style="min-width: 50px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->nama }}</td>
								<td>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'jenis')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
									<form style="all: unset" action="{{ route('master.jenis.delete', ['id' => $item->id]) }}" method="post">
										@csrf
										<button type="submit" class="btn btn-sm btn-danger" onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i class="fa fa-trash-alt"></i></button>
									</form>
								</td>
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