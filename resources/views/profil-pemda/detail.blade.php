@extends('layouts.main')

@section('title')
    Detail Profil Pemda {{ $provinsi->name }}
@endsection

@section('title-desc')
	Halaman Detail Profil Pemerintah Daerah
@endsection

@section('buttons')
    <a href="{{ route('profil-pemda.index') }}" class="btn btn-light">Kembali</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="profil-tab" data-toggle="tab" href="#tab-profil" role="tab" aria-controls="tab-profil" aria-selected='true'>Profil Inovasi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="indikator-tab" data-toggle="tab" href="#tab-indikator" role="tab" aria-controls="tab-indikator">Indikator</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profil" role="tabpanel" aria-labelledby="profil-tab">
                    <div class="row">
                        <div class="col">
                            <div class="my-3">
                                <b>Tingkatan</b><br>
                                <span>Provinsi</span>
                            </div>
                            <div class="my-3">
                                <b>OPD yang menangani</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>Alamat Pemda</b><br>
                                <span>-</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="my-3">
                                <b>Email</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>No. Telpon</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>Nama Admin</b><br>
                                <span>-</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-3">
                                <b>Dokumen Penelitian</b><br>
                                <span>-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-indikator" role="tabpanel" aria-labelledby="indikator-tab">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush" id="myTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Indikator SPD</th>
                                            <th>Informasi</th>
                                            @if (Auth::user()->role == 2)
                                                <th class="text-center">Bobot</th>
                                            @endif
                                            <th class="text-center" style="width: 100px; min-width: 100px;">Dokumen Pendukung</th>
                                        </tr>
                                    </thead>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }} @if($item->wajib == 1) <span class="text-danger">*</span> @endif</td>
                                                <td>{!! $item->keterangan !!}</td>
                                                @if (Auth::user()->role == 2)
                                                    <td class="text-center"><h4><b>{{ $item->pivot->bobot_akhir }}</b></h4></td>
                                                @endif
                                                <td class="text-center">
                                                    @if ($item->upload()->where('provinsi_id', Auth::user()->role == 3 ? Auth::user()->province_id : request()->id)->count() > 0)
                                                        <br><span class="badge badge-pill badge-success"><i class="fa fa-check-circle"></i> &nbsp; Ada File</span><br>
                                                    @endif
                                                    <a href="{{ route('profil-pemda.upload.index', ['id' => Auth::user()->role == 3 ? Auth::user()->province_id : request()->id, 'indikator' => $item->id]) }}" class="btn m-1 btn-sm btn-warning">
                                                        @if (Auth::user()->role == 3)
                                                            <i class="fas fa-upload"></i>&nbsp;&nbsp;Upload
                                                        @else
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Lihat
                                                        @endif
                                                    </a>
                                                    @if (Auth::user()->role == 2)
                                                        <br><button class="btn m-1 btn-sm btn-info" type="button" data-toggle="modal" data-target="#modalPopup" onclick="chooseParam({{ request()->id }}, {{ $item->id }})"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Beri Bobot</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.modal')
    @include('script.dataTable')
    <script>
		function chooseParam(provinsi_id, indikator_id) {
			$('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
			$.ajax({
				type: 'POST',
				url: '{{route("inovasi.indikator.chooseParam")}}',
				data: {
					'_token': '<?php echo csrf_token() ?>',
					'provinsi_id': provinsi_id,
					'indikator_id': indikator_id,
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
