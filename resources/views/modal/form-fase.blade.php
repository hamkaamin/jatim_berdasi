<form action="{{ route('master.fase.save', ['id' => $data != null ? $data->id : 0]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Fase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Tahun</label>
            <div class="col-sm-9">

                <select class="form-control select22_modal_setting_tahun" id="setting_tahun" name="tahun"
                    required="">
                    {{ $last = date('Y') - 5 }}
                    {{ $now = date('Y') + 2 }}
                    @for ($i = $now; $i >= $last; $i--)
                        @php
                            $selected = '';
                        @endphp
                        <option value="{{ $i }}" {{ $i == @$data->tahun ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="control-label col-sm-3">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nama" required=""
                    value="{{ $data != null ? $data->nama : '' }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="control-label col-sm-3">Keterangan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="keterangan"
                    value="{{ $data != null ? $data->keterangan : '' }}" required="">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="control-label col-sm-3">Tgl Berakhir</label>
            <div class="col-sm-9">
                <input type="datetime-local" class="form-control" name="tgl_berakhir"
                    value="{{ $data != null ? $data->tgl_berakhir : '' }}" required="">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="control-label col-sm-3">Aktif</label>
            <div class="col-sm-9">
                <select name="active" class="form-control" id="active">
                    <option {{ @$data->active == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                    <option {{ @$data->active == 1 ? 'selected' : '' }} value="1">Aktif</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
