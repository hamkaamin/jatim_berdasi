<form action="{{ route('kovablik.update', ['id' => $data->id]) }}" method="post">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Update Status Proposal Kovablik</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
        <div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Status</label></div>
			<div class="col-sm-8">
                <select name="status" class="form-control" required>
                    <option value="0" @if($data->status == 0) selected @endif>Draft</option>
                    <option value="1" @if($data->status == 1) selected @endif>Diproses</option>
                    <option value="2" @if($data->status == 2) selected @endif>Disetujui</option>
                    <option value="3" @if($data->status == 3) selected @endif>Ditolak</option>
                    <option value="4" @if($data->status == 4) selected @endif>Revisi</option>
                </select>
            </div>
		</div>
		<div class="row my-2">
			<div class="col-sm-4 d-flex align-items-center"><label>Keterangan</label></div>
			<div class="col-sm-8">
                <input type="text" name="keterangan" class="form-control" value="{{ $data->keterangan }}">
            </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</form>