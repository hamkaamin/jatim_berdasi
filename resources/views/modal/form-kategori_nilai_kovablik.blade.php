<form action="{{ route('master.kategori_nilai_kovablik.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
    id="form-kategori-nilai-kovablik">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah / Edit Aspek Penilaian Kovablik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @php $indukNode = $parent ?? ($data ? $data->parent : null); @endphp

        @if ($indukNode)
            <input type="hidden" name="parent_id" value="{{ $indukNode->id }}">
            <div class="alert alert-secondary py-2 mb-3">Aspek induk: <b>{{ $indukNode->bagian }}</b></div>
        @endif

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Aspek <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="text" name="bagian" class="form-control" required
                    value="{{ $data->bagian ?? '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nilai Minimum</label></div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="nilai_min" class="form-control"
                    value="{{ $data->nilai_min ?? '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Nilai Maximum</label></div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="nilai_max" class="form-control"
                    value="{{ $data->nilai_max ?? '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Bobot Nilai (%) <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8"><input type="number" min="0" max="100" name="bobot_nilai" id="bobot_nilai" required
                    class="form-control" value="{{ $data->bobot_nilai ?? '' }}"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-4 d-flex align-items-center"><label>Tahapan <span class="text-danger">*</span></label>
            </div>
            <div class="col-sm-8">
                @if ($indukNode)
                    <input type="text" class="form-control"
                        value="{{ optional($tahapan->firstWhere('id', $indukNode->tahapan_id))->nama ?? '-' }}" disabled>
                @elseif ($data)
                    <input type="hidden" name="tahapan_id" value="{{ $data->tahapan_id }}">
                    <input type="text" class="form-control"
                        value="{{ optional($tahapan->firstWhere('id', $data->tahapan_id))->nama ?? '-' }}" disabled>
                @else
                    <select class="form-control" name="tahapan_id" id="tahapan_id">
                        @foreach ($tahapan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                @endif
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
        var form = document.getElementById('form-kategori-nilai-kovablik');
        if (!form) return;
        var parentInput = form.querySelector('[name=parent_id]');
        var grpSel = form.querySelector('[name=tahapan_id]');
        var bobotInput = form.querySelector('[name=bobot_nilai]');

        function groupKey() {
            if (parentInput && parentInput.value && parentInput.value !== '0') return 'p' + parentInput.value;
            var tid = grpSel ? grpSel.value : '{{ $data->tahapan_id ?? '' }}';
            return 'root:' + tid;
        }

        form.addEventListener('submit', function (e) {
            var pakai = parseInt(terpakai[groupKey()] || 0, 10);
            if (editMode) pakai -= bobotLama;
            var val = parseInt(bobotInput.value || 0, 10);
            if (pakai + val > 100) {
                e.preventDefault();
                Swal.fire({
                    title: 'Bobot Melebihi 100%',
                    html: 'Total bobot untuk kelompok aspek ini akan menjadi <b>' + (pakai + val) +
                        '%</b>.<br>Maksimal 100%. Sisa kuota: <b>' + Math.max(0, 100 - pakai) + '%</b>.',
                    icon: 'warning',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    })();
</script>
