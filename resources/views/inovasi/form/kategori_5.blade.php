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
<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Visi</b><span class="text-danger">*</span></label></div>
    <div class="col-sm-8">
        <textarea name="visi" required class="ck-editor" id="editor1">
@if ($data != null)
{!! $data->visi !!}
@else
{!! old('visi') !!}
@endif
</textarea>
    </div>
</div>


<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Misi</b><span class="text-danger">*</span></label></div>
    <div class="col-sm-8">
        <textarea name="misi" required class="ck-editor" id="editor2">
            
@if ($data != null)
{!! $data->misi !!}
@else
{!! old('misi') !!}
@endif
</textarea>
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>File Struktur Organisasi</b></label></div>
    <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_struktur_organisasi">
        @if ($data != null)
            <br><a href="{{ $data->file_struktur_organisasi }}" target="_blank">Download
                File
                Struktur Organisasi</a>
        @endif
    </div>
</div>
<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>File Anggaran</b></label>
    </div>
    <div class="col-sm-8"><input accept=".jpg,.jpeg,.png,.pdf" type="file" name="file_anggaran">
        @if ($data != null)
            <br><a href="{{ $data->file_anggaran }}" target="_blank">Download File
                File Anggaran</a>
        @endif
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Hasil Inovasi </b></label>
    </div>
    <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_hasil_inovasi">
        @if ($data != null)
            <br><a href="{{ $data->file_hasil_inovasi }}" target="_blank">Download
                File
                Hasil Inovasi</a>
        @endif
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Kajian / Riset</b></label></div>
    <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="file_kajian">
        @if ($data != null)
            <br><a href="{{ $data->file_kajian }}" target="_blank">Download
                File
                Kajian / Riset</a>
        @endif
    </div>
</div>
@include('script.ck-editor')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
