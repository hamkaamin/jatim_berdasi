@extends('layouts.main')

@section('title')
    Upload Indikator Inovasi Masyarakat
@endsection

@section('title-desc')
    Halaman untuk Mengunggah File Pendukung Tiap Indikator Inovasi
@endsection

@section('buttons')
    <a href="{{ route('inovasi.indikator.index', ['id' => request()->id]) }}" class="btn btn-light">Kembali</a>
	@if ($inovasi->status == 0)
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="uploadNewFile({{ request()->id }}, {{ request()->indikator }}, 0)">Tambah Data</button>
	@endif
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush" id="myTable">
					<thead class="thead-light">
						<tr>
							<th>No.</th>
							@foreach ($kolom as $kol)
								<th>{{ $kol[0] }}</th>
							@endforeach
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								@foreach ($kolom as $kol)
									<td>
										@if ($kol[2] == 'file')
											@if ($item->{$kol[1]} != null && file_exists(public_path('/indikator_uploads/'.$item->{$kol[1]})))
												<a href="{{ asset('/indikator_uploads/'.$item->{$kol[1]}) }}" target="_blank">View</a>
											@else
												-
											@endif
										@elseif ($kol[2] == 'date')
											{{ date('Y-m-d', strtotime($item->{$kol[1]})) }}
										@else
											{{ $item->{$kol[1]} }}
										@endif
									</td>
								@endforeach
								<td></td>
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
	<div class="modal fade" id="modalPopup" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" id="modalContent">
				
			</div>
		</div>
	</div>
	
	<script>
		function uploadNewFile(inovasi_id, indikator_id, upload_id) {
			$('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
			$.ajax({
				type: 'POST',
				url: '{{route("inovasi.indikator.upload.add")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>',
					'inovasi_id': inovasi_id,
					'indikator_id': indikator_id,
					'upload_id': upload_id
				},
				success: function(data) {
					$('#modalContent').html(data.msg);
				},
				error: function(xhr) {
					console.log(xhr);
				}
			});
		}
	</script>
@endsection