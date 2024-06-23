<form action="{{ route('master.detail_tematik.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit detail Tematik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
            <div class="col-sm-8"><input type="text" name="nama" class="form-control" required
                    value="{{ $data != null ? $data->nama : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Tematik <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="tematik_id" id="tematik_id">
                    @foreach ($tematik as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->tematik_id == $item->id) || old('tematik_id') == $item->id) selected @endif>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>



    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
