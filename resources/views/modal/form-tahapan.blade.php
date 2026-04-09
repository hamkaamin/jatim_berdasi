<form action="{{ route('master.tahapan.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Tambah / Edit Tahapan</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Urutan <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><input type="number" name="urutan" class="form-control" required value="{{ $data != null ? $data->urutan : $urutan }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><input type="text" name="nama" class="form-control" required value="{{ $data != null ? $data->nama : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Tampilkan Kolom Waktu <span class="text-danger">*</span></label></div>
			<div class="col-sm-8">
				<input type="radio" name="tampilkan_kolom" id="tampilkan_kolom_1" value="1" @if($data != null && $data->tampilkan_kolom == 1) checked @endif>&nbsp;<label for="tampilkan_kolom_1">Ya</label><br>
				<input type="radio" name="tampilkan_kolom" id="tampilkan_kolom_0" value="0" @if($data == null || ($data != null && $data->tampilkan_kolom == 0)) checked @endif>&nbsp;<label for="tampilkan_kolom_0">Tidak</label>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>