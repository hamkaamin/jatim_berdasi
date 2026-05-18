<div class="step-panel" id="step-panel-2">
    <p class="step-panel-title">Langkah 2 &mdash; Klasifikasi Inovasi</p>
    <p class="step-panel-subtitle">Identitas inovator dan waktu penerapan</p>
    <hr class="step-divider">

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Perangkat Daerah</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="text" required name="perangkat_daerah" class="form-control"
                value="{{ $data != null ? $data->perangkat_daerah : old('perangkat_daerah') }}"></div>
    </div>

    <div class="row my-3">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Inisiator Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <div class="row">
                @foreach ($inisiator as $item)
                    <div class="col-6 d-flex align-items-center">
                        <input type="radio" id="inisiator_{{ $item->id }}" value="{{ $item->id }}"
                            name="inisiator_id" @if (old('inisiator_id') == $item->id ||
                                    ($data == null && $loop->iteration == 1) ||
                                    ($data != null && $data->inisiator_id == $item->id)) checked @endif><label
                            class="pb-0 mb-0 ml-2" for="inisiator_{{ $item->id }}">{{ $item->nama }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <div class="row">
                @foreach ($jenis as $item)
                    <div class="col-6 d-flex align-items-center">
                        <input type="radio" id="jenis_{{ $item->id }}" value="{{ $item->id }}" name="jenis_id"
                            @if (old('jenis_id') == $item->id ||
                                    ($data == null && $loop->iteration == 1) ||
                                    ($data != null && $data->jenis_id == $item->id)) checked @endif><label
                            class="pb-0 mb-0 ml-2" for="jenis_{{ $item->id }}">{{ $item->nama }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inisiator</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="text" required name="nama_inisiator" class="form-control"
                value="{{ $data != null ? $data->nama_inisiator : old('nama_inisiator') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Ujicoba Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="date" required name="waktu_uji_coba" class="form-control"
                value="{{ $data != null ? $data->waktu_uji_coba : old('waktu_uji_coba') }}">
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Penerapan Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="date" required name="waktu_penerapan" class="form-control"
                value="{{ $data != null ? $data->waktu_penerapan : old('waktu_penerapan') }}">
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center">
            <label><b>Apakah sudah ada pengembangan inovasi tersebut</b> <span
                    class="text-danger">*</span></label>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_1" value="1"
                        name="is_pengembangan" @if ($data != null && $data->is_pengembangan == 1) checked @endif>
                    <label class="pb-0 mb-0 ml-2" for="pengembangan_1">Iya</label>
                    <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_0" value="0"
                        name="is_pengembangan" @if ($data == null || ($data != null && $data->is_pengembangan == 0)) checked @endif>
                    <label class="pb-0 mb-0 ml-2" for="pengembangan_0">Tidak</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2" id="waktu_penerapan_row" style="display: none;">
        <div class="col-sm-3 d-flex align-items-center">
            <label><b>Waktu Pengembangan Inovasi</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-sm-9">
            <input type="date" name="waktu_pengembangan" class="form-control"
                value="{{ $data != null ? $data->waktu_pengembangan : old('waktu_pengembangan') }}">
        </div>
    </div>

    <div class="stepper-nav">
        <span class="step-badge">Langkah 2 dari 3</span>
        <div>
            <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light btn-lg mr-2">Batal</a>
            <button type="button" class="btn btn-light btn-lg mr-2" onclick="stepperPrev(2)">
                <i class="uil-arrow-left"></i> Sebelumnya
            </button>
            <button type="button" class="btn btn-primary btn-lg" onclick="stepperNext(2)">
                Selanjutnya <i class="uil-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<div class="step-panel" id="step-panel-3">
    <p class="step-panel-title">Langkah 3 &mdash; Deskripsi &amp; Dokumen</p>
    <p class="step-panel-subtitle">Narasi inovasi dan dokumen pendukung</p>
    <hr class="step-divider">

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-start"><label><b>Rancang bangun dan pokok perubahan
                    yang dilakukan</b><span class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <textarea name="rancang_bangun" oninput="countWords()" class="form-control" required
                id="inputText">
@if ($data != null)
{!! $data->rancang_bangun !!}
@else
{!! old('rancang_bangun') !!}
@endif
</textarea>
            <b><span class="text-danger"> * Minimal 300 Kata</span></b>
            <p>Jumlah Kata: <span id="wordCount">0</span></p>
            <p>Kurang Kata: <span id="wordCountLess">300</span></p>
            <p id="warningMessage" style="color: red; display: none;">Minimum 300 words required.</p>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Profil Bisnis (.ppt) (Jika
                    ada)</b></label>
        </div>
        <div class="col-sm-9"><input accept=".jpg,.jpeg,.png,.pdf" type="file" name="profil_bisnis">
            @if ($data != null)
                <br><a href="{{ $data->profil_bisnis }}" target="_blank">Download File Profil Bisnis</a>
            @endif
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Penghargaan</b></label></div>
        <div class="col-sm-9"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_penghargaan">
            @if ($data != null)
                <br><a href="{{ $data->file_penghargaan }}" target="_blank">Download File Penghargaan</a>
            @endif
        </div>
    </div>

    <div class="stepper-nav">
        <span class="step-badge">Langkah 3 dari 3</span>
        <div>
            <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light btn-lg mr-2">Batal</a>
            <button type="button" class="btn btn-light btn-lg mr-2" onclick="stepperPrev(3)">
                <i class="uil-arrow-left"></i> Sebelumnya
            </button>
            @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                <button class="btn btn-success btn-lg" type="submit" name="status" value="0">Simpan</button>
            @else
                <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                    class="btn btn-danger">Simpan</a>
            @endif
        </div>
    </div>
</div>

@include('script.ck-editor')
<script>
    (function () {
        var KEY = 'step2_{{ $kategori_id }}';

        function save() {
            var out = {};
            document.querySelectorAll('.step-panel input:not([type="file"]):not([type="hidden"]), .step-panel select, .step-panel textarea').forEach(function (el) {
                if (!el.name) return;
                if (el.type === 'radio' || el.type === 'checkbox') {
                    if (el.checked) out[el.name] = el.value;
                } else {
                    out[el.name] = el.value;
                }
            });
            localStorage.setItem(KEY, JSON.stringify(out));
        }

        function restore() {
            var raw = localStorage.getItem(KEY);
            if (!raw) return;
            var data; try { data = JSON.parse(raw); } catch (e) { return; }

            Object.keys(data).forEach(function (name) {
                document.querySelectorAll('[name="' + name + '"]').forEach(function (el) {
                    if (el.type === 'radio' || el.type === 'checkbox') {
                        el.checked = (el.value === data[name]);
                    } else if (el.type !== 'file') {
                        el.value = data[name];
                    }
                });
            });
        }

        document.querySelectorAll('[onclick*="stepperNext"]').forEach(function (btn) {
            btn.addEventListener('click', save);
        });

        @if ($data == null)
        restore();
        @endif
        window.clearStep2Storage = function () { localStorage.removeItem(KEY); };
    }());

    (function() {
        var pengembangan1 = document.getElementById('pengembangan_1');
        var pengembangan0 = document.getElementById('pengembangan_0');
        var waktuPenerapanRow = document.getElementById('waktu_penerapan_row');

        function toggleWaktuPenerapanRow() {
            waktuPenerapanRow.style.display = pengembangan1.checked ? 'flex' : 'none';
        }

        toggleWaktuPenerapanRow();
        pengembangan1.addEventListener('change', toggleWaktuPenerapanRow);
        pengembangan0.addEventListener('change', toggleWaktuPenerapanRow);
    })();
</script>
