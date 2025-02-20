@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Inovasi
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Inovasi dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Pemda</b></label></div>

                    @php
                        $user = $data != null ? $data->user : Auth::user();
                    @endphp
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
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->nama : old('nama') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->kategori ? $data->kategori->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Tahapan Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->belongsToTahapan ? $data->belongsToTahapan->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Inisiator Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->inisiator ? $data->inisiator->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inisiator</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->nama_inisiator : old('nama_inisiator') }}
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->jenis ? $data->jenis->nama : 'Tidak Ada Data' }}
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Bentuk Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->bentuk ? $data->bentuk->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Tematik</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->tematik ? $data->tematik->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Urusan Inovasi</b></label></div>
                    <div class="col-sm-8">
                        @if ($data && $data->urusan->count())
                            <ul>
                                @foreach ($data->urusan as $urusan)
                                    <li>{{ $urusan->nama }}</li>
                                @endforeach
                            </ul>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Ujicoba Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->waktu_uji_coba : old('waktu_uji_coba') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Waktu Penerapan Inovasi</b></label></div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->waktu_penerapan : old('waktu_penerapan') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Waktu Pengembangan Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? ($data->is_pengembangan ? 'Ya' : 'Tidak') : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Covid 19</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? ($data->covid ? 'Covid-19' : 'Non Covid-19') : 'Tidak Ada Data' }}
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Anggaran (Jika diperlukan)</b></label></div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->file_anggaran)
                            <a href="{{ $data->file_anggaran }}" target="_blank">Download File Anggaran</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2" style="display: none">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>File Rancang Bangun</b></label></div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->file_rancang_bangun)
                            <a href="{{ $data->file_rancang_bangun }}" target="_blank">Download File Rancang Bangun</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Profil Bisnis (.ppt) (Jika ada)</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->profil_bisnis)
                            <a href="{{ $data->profil_bisnis }}" target="_blank">Download File Profil Bisnis</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Dokumen HAKI</b></label></div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->file_dokumen_haki)
                            <a href="{{ $data->file_dokumen_haki }}" target="_blank">Download File Dokumen HAKI</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>
                @if ($data->kategori_id == 5)
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Penghargaan</b></label></div>
                        <div class="col-sm-8">
                            @if ($data != null && $data->file_penghargaan)
                                <a href="{{ $data->file_penghargaan }}" target="_blank">Download File Penghargaan</a>
                            @else
                                Tidak Ada Data
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @else href="{{ route('inovasi.index', ['area' => 'kota']) }}" @endif
            class="btn btn-light">
            Kembali</a>
        @if ($data != null && $data->status == 0)
            <form style="all: unset" action="{{ route('inovasi.save', ['id' => $data->id]) }}" method="post">
                @csrf
                <input type="hidden" name="label" value="{{ $data->label }}">
                <button type="submit" class="btn btn-primary" name="status" value="1"
                    onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Kirim
                    Inovasi</button>
            </form>
        @endif

        {{-- @if (Auth::user()->role == 2)
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                onclick="modal({{ request()->id }}, 'inovasi_status')">Update Status Inovasi</button>
        @endif --}}
    @endif

@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
