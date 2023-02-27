@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Inovasi
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Inovasi dalam Sistem
@endsection

@section('buttons')
    <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
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
    <div class="row">
        <div class="col">
            <form action="{{ route('inovasi.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
                enctype="multipart/form-data">
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
                <div class="row my-3">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Tahapan Inovasi</b> <span
                                class="text-danger">*</span></label></div>
                    <div class="col-sm-8">
                        <div class="row">
                            @foreach ($tahapan as $item)
                                <div class="col-6 d-flex align-items-center">
                                    <input type="radio" id="tahapan_{{ $item->id }}" value="{{ $item->id }}"
                                        name="tahapan_id" @if (old('tahapan_id') == $item->id ||
                                                ($data == null && $loop->iteration == 1) ||
                                                ($data != null && $data->tahapan_id == $item->id)) checked @endif><label
                                        class="pb-0 mb-0 ml-2"
                                        for="tahapan_{{ $item->id }}">{{ $item->nama }}</label>
                                </div>
                            @endforeach
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
                                    <input type="radio" id="inisiator_{{ $item->id }}" value="{{ $item->id }}"
                                        name="inisiator_id" @if (old('inisiator_id') == $item->id ||
                                                ($data == null && $loop->iteration == 1) ||
                                                ($data != null && $data->inisiator_id == $item->id)) checked @endif><label
                                        class="pb-0 mb-0 ml-2"
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
                                        class="pb-0 mb-0 ml-2" for="jenis_{{ $item->id }}">{{ $item->nama }}</label>
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
                                <option value="{{ $item->id }}" @if (($data != null && $data->bentuk_id == $item->id) || old('bentuk_id') == $item->id) selected @endif>
                                    {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row my-3">
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
                        <select name="urusan_id[]" style="widows: 100%" required class="js-example-basic-multiple w-100" multiple>
                            <option value="" disabled>-- Pilih Salah Satu --</option>
                            @foreach ($urusan as $item)
                                <option value="{{ $item->id }}" @if (
                                    (old('urusan_id') != null && in_array($item->id, old('urusan_id'))) ||
                                        ($data != null &&
                                            $data->urusan()->where('urusan_id', $item->id)->first() != null)) selected @endif>
                                    {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach ($tahapanKolom as $item)
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
                        <div class="col-sm-8"><input type="date" required name="waktu_tahapan_{{ $item->id }}"
                                class="form-control"
                                @if ($data != null && $temp != null && $temp->pivot->waktu != null) value="{{ date('Y-m-d', strtotime($temp->pivot->waktu)) }}" @else value="{{ old('waktu_tahapan_' . $item->id) }}" @endif>
                        </div>
                    </div>
                @endforeach
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Rancang bangun dan pokok perubahan yang
                                dilakukan</b><span class="text-danger">*</span></label></div>
                    <div class="col-sm-8">
                        <textarea name="rancang_bangun" class="ck-editor" required id="editor1">
@if ($data != null)
{!! $data->rancang_bangun !!}
@else
{!! old('rancang_bangun') !!}
@endif
</textarea>
                        <b><span class="text-danger"> * Minimal 300 Kata</span></b>
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
                    <div class="col-sm-8"><input type="file" name="anggaran">
                        @if ($data != null && file_exists(public_path('/file_anggaran/' . $data->anggaran)))
                            <br><a href="{{ asset('file_anggaran/' . $data->anggaran) }}">Download File Anggaran</a>
                        @endif
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Profil Bisnis (.ppt) (Jika ada)</b></label>
                    </div>
                    <div class="col-sm-8"><input type="file" name="profil_bisnis">
                        @if ($data != null && file_exists(public_path('/file_profil_bisnis/' . $data->profil_bisnis)))
                            <br><a href="{{ asset('file_profil_bisnis/' . $data->profil_bisnis) }}">Download File Profil
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
                            <button type="submit" class="btn btn-primary" name="status" value="1"
                                onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Submit
                                Inovasi</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
