@extends('layouts.main')

@section('title')
    Daftar Pengguna
@endsection

@section('title-desc')
	Daftar Seluruh Pengguna yang ada di dalam Database Sistem
@endsection

@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'pengguna')">Tambah Data</button>
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
							<th>Username</th>
							<th>Email</th>
							<th>Role</th>
							<th style="min-width: 100px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->username }}</td>
								<td>{{ $item->email }}</td>
								<td>{{ Helper::getRole($item->role) }}</td>
								<td>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'pengguna')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
									<form style="all: unset" action="{{ route('pengguna.reset-pass', ['id' => $item->id]) }}" method="post">
										@csrf
										<button type="submit" class="btn btn-sm btn-success" onclick="if(!confirm('Apakah Anda yakin akan me-reset password pengguna ini ?')){return false;}"><i class="fa fa-key"></i></button>
									</form>
									<form style="all: unset" action="{{ route('pengguna.delete', ['id' => $item->id]) }}" method="post">
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
	@include('script.ubahWilayah')
	<script>
		function ubahRole(type) {
			$.ajax({
				type: 'POST',
				url: '{{route("pengguna.change-role")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>',
					'type': type,
				},
				success: function(data) {
					$('#role_container').html(data.msg);
				},
				error: function(xhr) {
					console.log(xhr);
				}
			});
		}
	</script>
@endsection