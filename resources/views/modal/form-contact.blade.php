<form action="{{ route('master.contact.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nama" required=""
                    value="{{ $data != null ? $data->nama : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Alamat</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="alamat" required=""
                    value="{{ $data != null ? $data->alamat : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Email</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="email" required=""
                    value="{{ $data != null ? $data->email : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="control-label col-sm-3">No Telp</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="no_telp" required=""
                    value="{{ $data != null ? $data->no_telp : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Instagram</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="instagram" required=""
                    value="{{ $data != null ? $data->instagram : '' }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
