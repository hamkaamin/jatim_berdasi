<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Perangkat Daerah</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8"><input type="text" required name="perangkat_daerah" class="form-control"
            value="{{ $data != null ? $data->perangkat_daerah : old('perangkat_daerah') }}"></div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Rancang bangun dan pokok perubahan
                yang
                dilakukan</b><span class="text-danger">*</span></label></div>
    <div class="col-sm-8">
        {{-- <textarea id="inputText" oninput="countWords()" rows="4" cols="50"></textarea> --}}



        <textarea name="rancang_bangun" oninput="countWords()" class="form-control" required id="inputText">
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
<div class="row my-3">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Inisiator Inovasi</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8">
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

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inisiator</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8"><input type="text" required name="nama_inisiator" class="form-control"
            value="{{ $data != null ? $data->nama_inisiator : old('nama_inisiator') }}"></div>
</div>
<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Ujicoba Inovasi</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8"><input type="date" required name="waktu_uji_coba" class="form-control"
            value="{{ $data != null ? $data->waktu_uji_coba : old('waktu_uji_coba') }}">
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Penerapan Inovasi</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8"><input type="date" required name="waktu_penerapan" class="form-control"
            value="{{ $data != null ? $data->waktu_penerapan : old('waktu_penerapan') }}">
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center">
        <label><b>Waktu Pengembangan Inovasi</b> <span class="text-danger">*</span></label>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_1" value="1" name="is_pengembangan"
                    @if ($data != null && $data->is_pengembangan == 1) checked @endif>
                <label class="pb-0 mb-0 ml-2" for="pengembangan_1">Iya</label>
                <input type="radio" class="pb-0 mb-0 ml-2" id="pengembangan_0" value="0" name="is_pengembangan"
                    @if ($data == null || ($data != null && $data->is_pengembangan == 0)) checked @endif>
                <label class="pb-0 mb-0 ml-2" for="pengembangan_0">Tidak</label>
            </div>
        </div>
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Profil Bisnis (.ppt) (Jika
                ada)</b></label>
    </div>
    <div class="col-sm-8"><input accept=".jpg,.jpeg,.png,.pdf" type="file" name="profil_bisnis">
        @if ($data != null)
            <br><a href="{{ $data->profil_bisnis }}" target="_blank">Download File
                Profil
                Bisnis</a>
        @endif
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Penghargaan</b></label></div>
    <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_penghargaan">
        @if ($data != null)
            <br><a href="{{ $data->file_penghargaan }}" target="_blank">Download
                File
                Penghargaan</a>
        @endif
    </div>
</div>
@include('script.ck-editor')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
