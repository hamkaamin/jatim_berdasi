<form action="{{ route('opd.save', ['id' => $data != null ? $data->id : 0]) }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Tambah / Edit OPD</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><input type="text" name="nama" class="form-control" required value="{{ $data != null ? $data->nama : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Alamat</label></div>
			<div class="col-sm-8"><input type="text" name="alamat" class="form-control" value="{{ $data != null ? $data->alamat : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Fax</label></div>
			<div class="col-sm-8"><input type="number" name="fax" class="form-control" value="{{ $data != null ? $data->fax : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Telepon</label></div>
			<div class="col-sm-8"><input type="number" name="telp" class="form-control" value="{{ $data != null ? $data->telp : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Logo</label></div>
			<div class="col-sm-8 align-items-center d-flex align-items-center">
				<input type="file" name="logo" class="mr-2">
				@if ($data != null && $data->logo != null && file_exists(public_path('/logo_opd/'.$data->logo)))
					<a href="{{ asset('logo_opd/'.$data->logo) }}" target="_blank"><img src="{{ asset('logo_opd/'.$data->logo) }}" alt="" width="100" height="100"></a>
				@endif
			</div>
		</div>
		@if ($data == null)
			<div class="row my-2">
				<div class="col-sm-4 d-flex align-items-center"><label>Scope OPD <span class="text-danger">*</span></label></div>
				<div class="col-sm-8">
					<select onchange="ubahScopeOpd(this.value)" class="form-control" required name="scope">
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
					<small>Scope hanya dapat ditentukan pada saat pembuatan data OPD baru. <b>Pastikan data yang dimasukkan pada form ini sudah benar !</b></small>
				</div>
			</div>
			<div class="row my-2">
				<div class="col" id="scope_container">

				</div>
			</div>
		@else
			<div class="row my-2">
				<div class="col-sm-4 d-flex align-items-center"><label>Daerah</label></div>
				<div class="col-sm-8">
					@if ($data->provinsi_id != null)
						PROVINSI {{ ($data->provinsi->name) }}
					@elseif ($data->kabkota_id != null)
						{{ ucwords($data->kota->name) }}
					@elseif ($data->kecamatan_id != null)
						KECAMATAN {{ $data->kecamatan->name }}
					@elseif ($data->kelurahan_id != null)
						KELURAHAN {{ $data->kelurahan->name }}
					@endif
				</div>
			</div>
			<div class="row my-2">
				<div class="col-sm-4 d-flex align-items-center"><label>Dibuat Oleh</label></div>
				<div class="col-sm-8">
					{{ $data->maker_id != null ? $data->maker->name : '-' }}
				</div>
			</div>
			<div class="row my-2">
				<div class="col-sm-4 d-flex align-items-center"><label>Update Terakhir Oleh</label></div>
				<div class="col-sm-8">
					{{ $data->updater_id != null ? $data->updater->name : '-' }} ({{ $data->updated_at }})
				</div>
			</div>
		@endif
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>