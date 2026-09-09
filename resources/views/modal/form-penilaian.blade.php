<form action="{{ route('master.penilaian.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
    id="form-penilaian">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Indikator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="alert alert-info d-flex align-items-center py-2" role="alert">
            <i class="fas fa-info-circle fa-lg me-2"></i>
            <div>Tombol pintasan di bawah menyalin nama <b>Bagian</b> yang sudah ada ke kolom input.
                Klik satu tombol untuk mengisi otomatis; klik tombol lain untuk menggantinya. Anda tetap bisa mengetik
                manual.</div>
        </div>
        <div class="row my-2">
            <div class="col-12 d-flex flex-wrap">
                @forelse ($bagian_list as $b)
                    <button type="button" class="btn btn-sm btn-outline-secondary m-1 btn-bagian-shortcut"
                        data-bagian="{{ $b }}">{{ $b }}</button>
                @empty
                    <small class="text-muted">Belum ada Bagian tersimpan.</small>
                @endforelse
            </div>
        </div>
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
            <div class="col-sm-4 d-flex align-items-center"><label>Bobot Nilai (%) <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="bobot_nilai" id="bobot_nilai" required
                    class="form-control" value="{{ $data != null ? $data->bobot_nilai : '' }}"></div>
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

<script>
    (function () {
        var terpakai = @json($bobot_terpakai ?? []);
        var bobotLama = {{ $data->bobot_nilai ?? 0 }};
        var editMode = {{ $data != null ? 'true' : 'false' }};
        var form = document.getElementById('form-penilaian');
        if (!form) return;
        var grpSel = form.querySelector('[name=kategori_id]');
        var bobotInput = form.querySelector('[name=bobot_nilai]');
        var bagianInput = form.querySelector('[name=bagian]');

        form.querySelectorAll('.btn-bagian-shortcut').forEach(function (btn) {
            btn.addEventListener('click', function () {
                bagianInput.value = this.dataset.bagian;
                this.blur();
            });
        });

        form.addEventListener('submit', function (e) {
            var pakai = parseInt(terpakai[grpSel.value] || 0, 10);
            if (editMode) pakai -= bobotLama;
            var val = parseInt(bobotInput.value || 0, 10);
            if (pakai + val > 100) {
                e.preventDefault();
                Swal.fire({
                    title: 'Bobot Melebihi 100%',
                    html: 'Total bobot untuk kategori ini akan menjadi <b>' + (pakai + val) +
                        '%</b>.<br>Maksimal 100%. Sisa kuota: <b>' + Math.max(0, 100 - pakai) + '%</b>.',
                    icon: 'warning',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    })();
</script>

@include('script.ck-editor')
