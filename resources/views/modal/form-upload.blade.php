<form
    @if ($type == 1) action="{{ route('profil-pemda.upload.save', ['id' => $data != null ? $data->id : 0, 'indikator_id' => $indikator_id, 'provinsi_id' => $id, 'type' => $type]) }}"
    @else
        action="{{ route('inovasi.indikator.upload.save', ['id' => $data != null ? $data->id : 0, 'indikator_id' => $indikator_id, 'inovasi_id' => $id, 'type' => $type]) }}" @endif
    method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Data Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @foreach ($kolom as $item)
            <div class="row my-2">
                <div class="col-sm-4 d-flex align-items-center"><label>{{ $item[0] }} @if ($item[3] == 1)
                            <span class="text-danger">*</span>
                        @endif
                    </label></div>
                <div class="col-sm-8">
                    @if ($item[2] != 'textarea' && $item[2] != 'file')
                        <input type="{{ $item[2] }}" name="{{ $item[1] }}" class="form-control"
                            @if ($item[3] == 1) required @endif
                            value="{{ $data != null ? $data->{$item[1]} : '' }}">
                    @elseif($item[2] == 'file')
                        <input type="{{ $item[2] }}" name="{{ $item[1] }}" class="form-control"
                            @if ($item[3] == 1) required @endif
                            value="{{ $data != null ? $data->{$item[1]} : '' }}">
                        <span class="text-danger">Maximal : 2MB</span>
                    @else
                        <textarea name="{{ $item[1] }}" class="form-control" @if ($item[3] == 1) required @endif
                            rows="5">{{ $data != null ? $data->{$item[1]} : '' }}</textarea>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
