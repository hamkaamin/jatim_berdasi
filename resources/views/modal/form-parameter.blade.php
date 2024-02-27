<form action="{{ route('master.parameter.save', ['indikator_id' => $indi->id]) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Parameter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col">
                <b>Nama Indikator : </b>{{ $indi->nama }}
            </div>
            <div class="col-auto">
                <button class="btn btn-success" type="button" onclick="tambahParameter()">Tambah Parameter
                    Baru</button>
            </div>
        </div>
        <div id="parameter_container">
            @foreach ($data as $item)
                <x-field-parameter :param="$item" :param2="$parameters" />
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
