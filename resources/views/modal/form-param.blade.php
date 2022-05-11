<form action="{{ route('inovasi.indikator.saveParam', ['inovasi_id' => $inovasi_id, 'indikator_id' => $indikator_id]) }}" method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Pilih Parameter</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Parameter <span class="text-danger">*</span></label></div>
			<div class="col-sm-8">
				<select name="param" class="form-control" required>
					<option value="" selected disabled>-- Pilih Salah Satu --</option>
					@foreach ($param as $item)
						<option value="{{ $item->id }}">{{ $item->nama }}</option>
					@endforeach
				</select>
			</div>
		</div>
		@if (Auth::user()->role == 2)
			<div class="row my-2">
				<div class="col-sm-4 d-flex align-items-center"><label>Notes</label></div>
				<div class="col-sm-8">
					<input type="text" name="catatan" class="form-control">
				</div>
			</div>
		@endif
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>