<form action="{{ route('master.juri.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Juri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" required name="user_id" id="user_id">
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->user_id == $item->id) || old('user_id') == $item->id) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Kategori <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="kategori_id" id="kategori_id">
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->kategori_id == $item->id) || old('kategori_id') == $item->id) selected @endif>
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

@include('script.ck-editor')
