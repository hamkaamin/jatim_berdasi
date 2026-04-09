<form action="{{ route('master.faq.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Tambah / Edit FAQ</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Pertanyaan <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><input type="text" name="pertanyaan" class="form-control" required value="{{ $data != null ? $data->pertanyaan : '' }}"></div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Jawaban <span class="text-danger">*</span></label></div>
			<div class="col-sm-8"><textarea name="jawaban" rows="5" class="form-control ck-editor" id="editor1">@if($data != null) {!! $data->jawaban !!} @endif</textarea></div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>

@include('script.ck-editor')