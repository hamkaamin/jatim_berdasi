<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">{{ $data->judul }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>
        {!! $data->deskripsi !!}
    </p>
    <p>
        @if($data->file != null && file_exists(public_path('/file_pengumuman/'.$data->file)))
            <a class="btn btn-sm btn-primary" target="_blank" href="{{ asset('file_pengumuman/'.$data->file) }}">Unduh File</a>
        @endif
    </p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
</div>
