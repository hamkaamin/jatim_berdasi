@extends('layouts.main')

@section('title')
    Daftar OPD
@endsection

@section('title-desc')
    Daftar Seluruh OPD yang ada di dalam Database Sistem
@endsection

@if (Auth::user()->role != 6 && Auth::user()->role != 2)
	@section('buttons')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'opd')">Tambah Data</button>
	@endsection
@endif

@section('content')
	@if (Auth::user()->role != 1 && Auth::user()->role != 2 && Auth::user()->role != 6)
		<div class="row p-1">
			<div class="col">
				<form action="{{ route('opd.filter-area') }}" method="get">
					<div class="row">
						<div class="col-auto align-self-center">
							<b>Filter Berdasarkan Wilayah OPD :</b>
						</div>
						<div class="col">
							<select onchange="ubahScopeOpd(this.value, 'col')" class="form-control" required name="scope">
								<option selected disabled>-- Pilih Salah Satu --</option>
								@if (in_array(Auth::user()->role, [1,2,3]) || Helper::checkOpd('provinsi', Auth::user()))
									<option value="provinsi">Provinsi</option>
									<option value="kota">Kabupaten / Kota</option>
									<option value="kecamatan">Kecamatan</option>
									<option value="kelurahan">Kelurahan</option>
								@elseif (Auth::user()->role == 4 || Helper::checkOpd('kota', Auth::user()))
									<option value="kota">Kabupaten / Kota</option>
									<option value="kecamatan">Kecamatan</option>
									<option value="kelurahan">Kelurahan</option>
								@elseif (Helper::checkOpd('kecamatan', Auth::user()))
									<option value="kecamatan">Kecamatan</option>
									<option value="kelurahan">Kelurahan</option>
								@elseif (Helper::checkOpd('kelurahan', Auth::user()))
									<option value="kelurahan">Kelurahan</option>
								@endif
							</select>
						</div>
					</div>
					<div class="row mt-2" id="col_scope_container"></div>
					<div class="row mt-2 mb-4 d-flex justify-content-center"><div class="col-4"><button class="btn btn-primary btn-sm btn-block" type="submit">Filter</button></div></div>
				</form>
			</div>
		</div>
	@endif
	<div class="row">
		<div class="col">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush" id="myTable">
					<thead class="thead-light">
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Wilayah</th>
							<th style="width: 100px"></th>
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
									@if (in_array(Auth::user()->role, [1,3,4]) || (Auth::user()->role == 5 && $item->maker_id == Auth::user()->id))
										<button data-target="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'opd')" class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
										<form style="all: unset" action="{{ route('opd.delete', ['id' => $item->id]) }}" method="post">
											@csrf
											<button type="submit" class="btn m-1 btn-block btn-sm btn-danger" onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
										</form>
									@endif
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
	@include('script.ubahScopeOpd')
@endsection