<form action="{{ route('master.verifikator_kovablik.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Juri Kovablik</h5>
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
            <div class="col-sm-4 d-flex align-items-center"><label>Kelompok <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="kelompok_id" id="kelompok_id">
                    @foreach ($kelompok as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->kelompok_id == $item->id) || old('kelompok_id') == $item->id) selected @endif>
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
