@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Inovasi
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Inovasi dalam Sistem
@endsection

@section('buttons')
    <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @else href="{{ route('inovasi.index', ['area' => 'kota']) }}" @endif
        class="btn btn-light">
        Kembali</a>
    @if ($data != null && $data->status == 0)
        <form style="all: unset" action="{{ route('inovasi.save', ['id' => $data->id]) }}" method="post">
            @csrf
            <input type="hidden" name="label" value="{{ $data->label }}">
            <button type="submit" class="btn btn-primary" name="status" value="1"
                onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Submit
                Inovasi</button>
        </form>
    @endif

    @if (Auth::user()->role == 2)
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
            onclick="modal({{ request()->id }}, 'inovasi_status')">Update Status Inovasi</button>
    @endif
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                <form action="{{ route('inovasi.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
                    enctype="multipart/form-data" id="form-edit-inovasi">
                    <input type="hidden" name="label" value="{{ $label }}">
                    @csrf
                    @php
                        $user = $data != null ? $data->user : Auth::user();
                    @endphp
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Pemda</b></label></div>
                        <div class="col-sm-8">
                            @if ($user->province_id != null)
                                PROVINSI {{ $user->provinsi->name }}
                            @elseif ($user->regency_id != null)
                                {{ $user->kota->name }}
                            @elseif ($user->opd_id != null)
                                @if ($user->opd->provinsi_id != null)
                                    PROVINSI {{ $user->opd->provinsi->name }}
                                @elseif ($user->opd->kabkota_id != null)
                                    {{ $user->opd->kota->name }}
                                @elseif ($user->opd->kecamatan_id != null)
                                    KECAMATAN {{ $user->opd->kecamatan->name }}
                                @elseif ($user->opd->kelurahan_id != null)
                                    KELURAHAN {{ $user->opd->kelurahan->name }}
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Dibuat Oleh</b></label></div>
                        <div class="col-sm-8">
                            {{ $user->name . ' - ' . $user->username }}
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="nama" class="form-control"
                                value="{{ $data != null ? $data->nama : old('nama') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                @if (Auth::user()->role == 4 || Auth::user()->role == 5)
                                    {{-- @foreach ($kategori as $item) --}}
                                    <div class="col-12 d-flex align-items-center">
                                        {{-- <input type="radio" id="kategori_{{ $item->id }}"
                                            value="{{ $item->kategori->id }}" name="kategori_id"
                                            @if (old('kategori_id') == $item->id || ($data == null && $loop->iteration == 1) || ($data != null && $data->kategori_id == $item->id))  @endif><label class="pb-0 mb-0 ml-2"
                                            for="kategori_{{ $item->id }}"
                                            onclick="div_tahapan('{{ csrf_token() }}','#div_tahapan','#form-edit-inovasi')">{{ $item->kategori->nama }}</label> --}}
                                        <select name="kategori_id" id="kategori_id" class="form-control" required
                                            onchange="div_tahapan('{{ csrf_token() }}','#div_tahapan','#form-edit-inovasi')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->kategori->id }}">
                                                    {{ $item->kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- @endforeach --}}
                                @else
                                    @foreach ($kategori as $item)
                                        <div class="col-6 d-flex align-items-center">
                                            <input type="radio" id="kategori_{{ $item->id }}"
                                                value="{{ $item->id }}" name="kategori_id"
                                                @if (old('kategori_id') == $item->id ||
                                                        ($data == null && $loop->iteration == 1) ||
                                                        ($data != null && $data->kategori_id == $item->id))  @endif><label class="pb-0 mb-0 ml-2"
                                                onclick="div_tahapan('{{ csrf_token() }}','#div_tahapan','#form-edit-inovasi')">{{ $item->kategori->nama }}
                                                for="kategori_{{ $item->id }}">{{ $item->nama }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Tahapan Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">

                                    <select name="tahapan_id" id="tahapan_id" class="form-control" required>
                                        <option value="" selected disabled>-- Pilih Salah Satu --</option>
                                        <div id="div_tahapan">

                                        </div>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row my-3">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Inisiator Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                @foreach ($inisiator as $item)
                                    <div class="col-6 d-flex align-items-center">
                                        <input type="radio" id="inisiator_{{ $item->id }}"
                                            value="{{ $item->id }}" name="inisiator_id"
                                            @if (old('inisiator_id') == $item->id ||
                                                    ($data == null && $loop->iteration == 1) ||
                                                    ($data != null && $data->inisiator_id == $item->id)) checked @endif><label class="pb-0 mb-0 ml-2"
                                            for="inisiator_{{ $item->id }}">{{ $item->nama }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                @foreach ($jenis as $item)
                                    <div class="col-6 d-flex align-items-center">
                                        <input type="radio" id="jenis_{{ $item->id }}" value="{{ $item->id }}"
                                            name="jenis_id" @if (old('jenis_id') == $item->id ||
                                                    ($data == null && $loop->iteration == 1) ||
                                                    ($data != null && $data->jenis_id == $item->id)) checked @endif><label
                                            class="pb-0 mb-0 ml-2"
                                            for="jenis_{{ $item->id }}">{{ $item->nama }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Bentuk Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <select name="bentuk_id" class="form-control">
                                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                                @foreach ($bentuk as $item)
                                    <option value="{{ $item->id }}"
                                        @if (($data != null && $data->bentuk_id == $item->id) || old('bentuk_id') == $item->id) selected @endif>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Tematik</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <select name="tematik_id" class="form-control">
                                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                                @foreach ($tematik as $item)
                                    <option value="{{ $item->id }}"
                                        @if (($data != null && $data->tematik_id == $item->id) || old('tematik_id') == $item->id) selected @endif>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row my-3" style="display: none">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Covid 19</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <input type="radio" id="covid_0" value="0" name="covid"
                                        @if (old('covid') == 0 || $data == null || ($data != null && $data->covid == 0)) checked @endif><label class="pb-0 mb-0 ml-2"
                                        for="covid_0">Non Covid-19</label>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <input type="radio" id="covid_1" value="1" name="covid"
                                        @if (old('covid') == 1 || ($data != null && $data->covid == 1)) checked @endif><label class="pb-0 mb-0 ml-2"
                                        for="covid_1">Covid-19</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Urusan Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <select name="urusan_id[]" style="widows: 100%" required
                                class="js-example-basic-multiple w-100" multiple>
                                <option value="" disabled>-- Pilih Salah Satu --</option>
                                @foreach ($urusan as $item)
                                    <option value="{{ $item->id }}"
                                        @if (
                                            (old('urusan_id') != null && in_array($item->id, old('urusan_id'))) ||
                                                ($data != null &&
                                                    $data->urusan()->where('urusan_id', $item->id)->first() != null)) selected @endif>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    {{-- @foreach ($tahapanKolom as $item)
                        <div class="row my-2">
                            <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu
                                        {{ $item->nama }}
                                        Inovasi</b><span class="text-danger">*</span></label></div>
                            @php
                                $temp =
                                    $data != null
                                        ? $data
                                            ->tahapan()
                                            ->where('tahapan_id', $item->id)
                                            ->first()
                                        : null;
                            @endphp
                            <div class="col-sm-8"><input type="date" required
                                    name="waktu_tahapan_{{ $item->id }}" class="form-control"
                                    @if ($data != null && $temp != null && $temp->pivot->waktu != null) value="{{ date('Y-m-d', strtotime($temp->pivot->waktu)) }}" @else value="{{ old('waktu_tahapan_' . $item->id) }}" @endif>
                            </div>
                        </div>
                    @endforeach --}}
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Rancang bangun dan pokok perubahan yang
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
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Tujuan Inovasi</b><span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <textarea name="tujuan" required class="ck-editor" id="editor2">
@if ($data != null)
{!! $data->tujuan !!}
@else
{!! old('tujuan') !!}
@endif
</textarea>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Manfaat yang diperoleh</b><span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <textarea name="manfaat" required class="ck-editor" id="editor3">
@if ($data != null)
{!! $data->manfaat !!}
@else
{!! old('manfaat') !!}
@endif
</textarea>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Hasil Inovasi</b><span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <textarea name="hasil" class="ck-editor" required id="editor4">
@if ($data != null)
{!! $data->hasil !!}
@else
{!! old('hasil') !!}
@endif
</textarea>
                        </div>
                    </div>
                    @php
                        $anggaran = 'Anggaran (Jika diperlukan)';
                    @endphp
                    @if (Auth::user()->role == 4 || Auth::user()->role == 5)
                        @php $anggaran = 'Surat Pengantar Pemda'; @endphp
                    @endif
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>{{ $anggaran }}</b></label></div>
                        <div class="col-sm-8"><input type="file" name="anggaran" accept=".jpg,.jpeg,.png,.pdf">
                            @if ($data != null)
                                <br><a href="{{ $data->anggaran }}" target="_blank">Download File Anggaran</a>
                            @endif
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>File Rancang Bangun</b></label></div>
                        <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf"
                                name="file_rancang_bangun">
                            @if ($data != null)
                                <br><a href="{{ $data->file_rancang_bangun }}" target="_blank">Download
                                    File
                                    Rancang Bangun</a>
                            @endif
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
                    <div class="row mt-4">
                        <div class="col text-right">
                            <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
                                class="btn btn-light btn-lg">Batal</a>
                            <button class="btn btn-success btn-lg" type="submit" name="status"
                                value="0">Simpan</button>
                            @if ($data != null && $data->status == 0)
                                @if (env('APP_NAME') == 'INOVASI DAERAH')
                                    <button style="display: none" type="submit" class="btn btn-primary" name="status"
                                        value="1"
                                        onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Submit
                                        Inovasi</button>
                                @else
                                    <button type="submit" class="btn btn-primary" name="status" value="1"
                                        onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Submit
                                        Inovasi</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <h3>
            Inotek Sudah Ditutup Per 5 Mei 2023, 22.00
        </h3>
    @endif
@endsection
<script>
    function countWords() {
        var inputElement = document.getElementById("inputText");
        var wordCountElement = document.getElementById("wordCount");
        var wordCountLessElement = document.getElementById("wordCountLess");
        var warningMessage = document.getElementById("warningMessage");

        var text = inputElement.value.trim();
        var words = text.split(/\s+/);

        if (words.length < 300) {
            warningMessage.style.display = "block";
        } else {
            warningMessage.style.display = "none";
        }

        wordCountElement.textContent = words.length;
        wordCountLessElement.textContent = 300 - words.length;
    }

    function div_tahapan(token, target, form_id) {
        var kategori_id = $(form_id).find('select[name="kategori_id"] option:selected').val();
        var act = '{{ route('inovasi.show_tahapan') }}';

        $(form_id).find('#div_tahapan').html('<option value="">Waiting Data ...</option>');
        $.post(act, {
                _token: token,
                kategori_id: kategori_id
            },
            function(data) {
                $('#tahapan_id').prop("disabled", false);
                $(form_id).find('#tahapan_id').html(data);
                $(form_id).find('#tahapan_id').trigger('change');
            });
    }
</script>
@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
