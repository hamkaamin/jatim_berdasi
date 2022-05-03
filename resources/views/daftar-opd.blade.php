@extends('layouts.main')

@section('title')
    Daftar OPD
@endsection

@section('title-desc')
    Daftar Seluruh OPD yang ada di dalam Database Sistem
@endsection

@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'opd')">Tambah Data</button>
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
							<th>Wilayah</th>
							<th style="min-width: 50px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->nama }}</td>
								<td>
									@if ($item->provinsi_id != null)
										PROVINSI {{ ($item->provinsi->name) }}
									@elseif ($item->kabkota_id != null)
										{{ ucwords($item->kota->name) }}
									@elseif ($item->kecamatan_id != null)
										KECAMATAN {{ $item->kecamatan->name }}
									@elseif ($item->kelurahan_id != null)
										KELURAHAN {{ $item->kelurahan->name }}
									@endif
								</td>
								<td>
									<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'opd')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
									<form style="all: unset" action="{{ route('opd.delete', ['id' => $item->id]) }}" method="post">
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
		function ubahScopeOpd(type) {
			$.ajax({
				type: 'POST',
				url: '{{route("opd.change-scope")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>',
					'type': type,
				},
				success: function(data) {
					$('#scope_container').html(data.msg);
				},
				error: function(xhr) {
					console.log(xhr);
				}
			});
		}
	</script>
@endsection