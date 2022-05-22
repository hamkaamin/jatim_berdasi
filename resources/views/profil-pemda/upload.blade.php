@extends('layouts.main')

@section('title')
    Upload Indikator Provinsi
@endsection

@section('title-desc')
    Halaman untuk Mengunggah File Pendukung Indikator : {{ $indikator->nama }}
@endsection

@section('buttons')
    <a href="{{ route('profil-pemda.detail', ['id' => request()->id]) }}" class="btn btn-light">Kembali</a>
	@if (Auth::user()->role == 3)
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
							@if (Auth::user()->role == 3)
                                <th style="width: 100px"></th>
                            @endif
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
											{{ $item->{$kol[1]} != null ? date('Y-m-d', strtotime($item->{$kol[1]})) : '-' }}
										@else
											{{ $item->{$kol[1]} }}
										@endif
									</td>
								@endforeach
                                @if (Auth::user()->role == 3)
                                    <td>
                                        <button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'upload')" class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                        <form style="all: unset" action="{{ route('profil-pemda.upload.delete', ['id' => $item->id]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn m-1 btn-block btn-sm btn-danger" onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                        </form>
                                    </td>
                                @endif
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
	@if (Auth::user()->role == 3)
        @include('script.modal')

        <script>
            function uploadNewFile(provinsi_id, indikator_id, upload_id) {
                $('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
                $.ajax({
                    type: 'POST',
                    url: '{{route("profil-pemda.upload.add")}}',
                    data: {
                        '_token': '<?php echo csrf_token() ?>',
                        'provinsi_id': provinsi_id,
                        'indikator_id': indikator_id,
                        'upload_id': upload_id,
                        'type': 1,
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
    @endif
@endsection
