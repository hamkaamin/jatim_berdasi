@extends('layouts.main')

@section('title')
    Master Indikator dan Parameter Inovasi
@endsection

@section('title-desc')
    Daftar Indikator dan masing-masing Parameternya untuk Penilaian Inovasi
@endsection

@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'indikator')">Tambah Data</button>
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
							<th>Keterangan</th>
							<th>Data Pendukung</th>
							<th>Tipe File</th>
							<th style="min-width: 100px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->nama }} @if($item->wajib == 1) <span class="text-danger">*</span> @endif</td>
								<td>{!! $item->keterangan !!}</td>
								<td>{{ $item->data_pendukung }}</td>
								<td>{{ $item->tipe_file }}</td>
								<td>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'indikator')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'parameter')" class="btn btn-sm btn-success"><i class="fa fa-list-ul"></i></button>
									<form style="all: unset" action="{{ route('master.indikator.delete', ['id' => $item->id]) }}" method="post">
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
	<script>
		function tambahParameter() {
			$.ajax({
				type: 'POST',
				url: '{{route("master.parameter.add")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>'
				},
				success: function(data) {
					$('#parameter_container').append(data.msg);
				},
				error: function(xhr) {
					console.log(xhr);
				}
			});
		}

		function hapusParameter(id) {
			$.ajax({
				type: 'POST',
				url: '{{route("master.parameter.delete")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>',
					'id':id
				},
				success: function(data) {
					$('#parameter_'+id).remove();
				},
				error: function(xhr) {
					console.log(xhr);
				}
			});
		}
	</script>
@endsection