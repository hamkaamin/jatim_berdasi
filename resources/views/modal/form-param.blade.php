<form @if ($type == 'provinsi')
    action="{{ route('profil-pemda.saveParam', ['provinsi_id' => $data_id, 'indikator_id' => $indikator->id]) }}"
@else
    action="{{ route('inovasi.indikator.saveParam', ['inovasi_id' => $data_id, 'indikator_id' => $indikator->id]) }}"
@endif method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">{{ $type == 'provinsi' ? 'Input Bobot' : 'Pilih Parameter' }}</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row mb-2">
			<div class="col">
				<h6><b>{{ $indikator->nama }}</b></h6>
				{!! $indikator->keterangan !!}
			</div>
		</div>
		@if ($type == 'provinsi')
            <div class="row my-2">
                <div class="col-sm-4 d-flex align-items-center"><label>Bobot <span class="text-danger">*</span></label></div>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="bobot_akhir" step="any">
                </div>
            </div>
        @else
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
        @endif
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>
