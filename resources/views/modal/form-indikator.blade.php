<form action="{{ route('master.indikator.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Tambah / Edit Indikator</h5>
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
			<div class="col-sm-4 d-flex align-items-center"><label>Keterangan <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><textarea name="keterangan" rows="5" class="form-control ck-editor" id="editor1">@if($data != null) {!! $data->keterangan !!} @endif</textarea></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Data Pendukung <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><input type="text" name="data_pendukung" class="form-control" required value="{{ $data != null ? $data->data_pendukung : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Tipe File <span class="text-danger">*</span></label></div>
			<div class="col-sm-8">
				<input type="text" name="tipe_file" class="form-control" required value="{{ $data != null ? $data->tipe_file : '' }}">
				<small>Isikan dengan keterangan ekstensi file yang dapat di-upload pengguna. <b>Contoh : </b>dokumen PDF = isikan dengan "pdf", file video isikan dengan "mp4". Jika jenis ekstensi lebih dari satu, maka pisahkan masing-masing ekstensi dengan tanda koma "," </small>
			</div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Wajib Diisi <span class="text-danger">*</span></label></div>
			<div class="col-sm-8">
				<input type="radio" name="wajib" id="wajib_1" value="1" @if($data != null && $data->wajib == 1) checked @endif>&nbsp;<label for="wajib_1">Ya</label><br>
				<input type="radio" name="wajib" id="wajib_0" value="0" @if($data == null || ($data != null && $data->wajib == 0)) checked @endif>&nbsp;<label for="wajib_0">Tidak</label>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>

@include('script.ck-editor')