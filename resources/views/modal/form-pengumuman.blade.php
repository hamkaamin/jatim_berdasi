<form action="{{ route('pengumuman.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
    enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Pengumuman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Judul <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="text" name="judul" class="form-control" required
                    value="{{ $data != null ? $data->judul : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Deskripsi</label></div>
            <div class="col-sm-8">
                <textarea name="deskripsi" class="ck-editor" id="editor1">
@if ($data != null)
{!! $data->deskripsi !!}
@endif
</textarea>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>File</label></div>
            <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png," name="file">
                @if ($data != null && $data->file != null && file_exists(public_path('/file_pengumuman/' . $data->file)))
                    <br><a target="_blank" href="{{ asset('file_pengumuman/' . $data->file) }}">Download File
                        Pengumuman</a>
                @endif
            </div>
        </div>


        <div class="row my-2">
            <label class="control-label col-sm-4">Aktif</label>
            <div class="col-sm-8">
                <select name="is_aktif" class="form-control" id="is_aktif">
                    <option {{ @$data->is_aktif == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                    <option {{ @$data->is_aktif == 1 ? 'selected' : '' }} value="1">Aktif</option>
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
