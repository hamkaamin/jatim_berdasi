<form action="{{ route('master.kategori_nilai_kovablik.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Kategori Penilaian Kovablik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Bagian <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="text" name="bagian" class="form-control" required
                    value="{{ $data != null ? $data->bagian : '' }}"></div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Indikator <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <textarea name="indikator" required class="ck-editor" id="editor1">
                    {!! old('indikator', optional($data)->indikator) !!}
                </textarea>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nilai Minimum </label></div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="nilai_min"
                    class="form-control" value="{{ $data != null ? $data->nilai_min : '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nilai Maximum </label></div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="nilai_max"
                    class="form-control" value="{{ $data != null ? $data->nilai_max : '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Bobot Nilai (%) </label></div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="bobot_nilai"
                    class="form-control" value="{{ $data != null ? $data->bobot_nilai : '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Tahapan <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="tahapan_id" id="tahapan_id">
                    @foreach ($tahapan as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->tahapan_id == $item->id) || old('tahapan_id') == $item->id) selected @endif>
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