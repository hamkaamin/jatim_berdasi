<form id="frm-definisi-operasional" action="{{ route('master.definisi.save', ['id' => $data != null ? $data->id : 0]) }}"
    method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Definisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nama <span class="text-danger">*</span></label></div>
            <div class="col-sm-8"><input type="text" name="nama" class="form-control" required
                    value="{{ $data != null ? $data->nama : '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Kategori <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select onchange="indikatorKategori('{{ csrf_token() }}','#div_indikator','#frm-definisi-operasional')"
                    name="kategori_id" class="form-control" id="kategori_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" @if (($data != null && $data->kategori_id == $item->id) || old('kategori_id') == $item->id) selected @endif>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Indikator <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                <select name="indikator_id" class="form-control" id="indikator_id">
                    <option value="">-- Pilih Indikator --</option>
                    <div id="div_indikator"></div>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    function indikatorKategori(token, target, form_id) {
        var kategori_id = $(form_id).find('select[name="kategori_id"] option:selected').val();
        var act = '{{ route('master.definisi.show_indikator') }}';

        $(form_id).find('#div_indikator').html('<option value="">Waiting Data ...</option>');
        $.post(act, {
                _token: token,
                kategori_id: kategori_id
            },
            function(data) {
                $('#indikator_id').prop("disabled", false);
                $(form_id).find('#indikator_id').html(data);
                $(form_id).find('#indikator_id').trigger('change');
            });
    }
</script>
