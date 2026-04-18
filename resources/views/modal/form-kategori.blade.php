<form action="{{ route('master.kategori.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-3">
            <div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
            <div class="col-sm-8"><input type="text" name="nama" class="form-control" required
                    value="{{ $data != null ? $data->nama : '' }}"></div>
        </div>
        <div class="row mb-3">
            <label class="control-label col-sm-4">Status</label>
            <div class="col-sm-8">
                <select name="is_active" class="form-control" id="is_active">
                    <option {{ @$data->is_aktif == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                    <option {{ @$data->is_aktif == 1 ? 'selected' : '' }} value="1">Aktif</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="control-label col-sm-4">Kovablik?</label>
            <div class="col-sm-8">
                <select name="is_kovablik" class="form-control" id="is_kovablik">
                    <option {{ @$data->is_kovablik == 0 ? 'selected' : '' }} value="0">Tidak</option>
                    <option {{ @$data->is_kovablik == 1 ? 'selected' : '' }} value="1">Ya</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
