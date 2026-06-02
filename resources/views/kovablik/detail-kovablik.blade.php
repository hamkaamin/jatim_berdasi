@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Proposal
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Proposal dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center"><label><b>Dibuat Oleh</b></label></div>
                    <div class="col-sm-8">
                        {{ $data->user->name . ' - ' . $data->user->username }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Judul Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->judul : old('judul') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Kategori</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->kategori ? $data->kategori->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Kelompok Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->kelompok ? $data->kelompok->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Jenis Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->jenis_inovasi ? $data->jenis_inovasi : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Waktu Mulai Implementasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->tanggal_mulai : old('tanggal_mulai') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Surat Pernyataan Implementasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->dokumen_surat_pernyataan_implementasi)
                            <a href="{{ url($data->dokumen_surat_pernyataan_implementasi) }}" target="_blank">Download Surat Pernyataan Implementasi</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Penanggung Jawab/Inovator</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->nama_inovator : old('nama_inovator') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Dokumen Pernyataan Inovator</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->dokumen_pernyataan_implementasi)
                            <a href="{{ url($data->dokumen_pernyataan_implementasi) }}" target="_blank">Download Dokumen Pernyataan Inovator</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Dokumen Kesediaan Umum</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->file_kesediaan_replikasi)
                            <a href="{{ url($data->file_kesediaan_replikasi) }}" target="_blank">Download Dokumen Kesediaan Umum</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>No Registrasi IGA</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->nip_inovator : old('nip_inovator') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link Video</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->link_video : old('link_video') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Keterangan Video</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->keterangan_video : old('keterangan_video') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Sektor Pemerintah</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->sektorPemerintah ? $data->sektorPemerintah->nama : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Asta Cita</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null && $data->astaCita ? $data->astaCita->name : 'Tidak Ada Data' }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Koordinat</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->koordinat : old('koordinat') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Latar Belakang</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->latar_belakang : old('latar_belakang') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Latar Belakang</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_latar_belakang : old('file_latar_belakang') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Tujuan, Outcome dan Output yang Diharapkan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->tujuan_outcome : old('tujuan_outcome') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Tujuan, Outcome dan Output yang Diharapkan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_tujuan_outcome : old('file_tujuan_outcome') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Cara Kerja Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->cara_kerja : old('cara_kerja') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Cara Kerja Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_cara_kerja : old('file_cara_kerja') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Cara Keunggulan Ide / Gagasan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->kebaharuan : old('kebaharuan') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Cara Keunggulan Ide / Gagasan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_kebaharuan : old('file_kebaharuan') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Mekanisme Evaluasi Pelaksanaan Inovasi & Tindak Lanjut</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->mekanisme_monitoring : old('mekanisme_monitoring') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Mekanisme Evaluasi Pelaksanaan Inovasi & Tindak Lanjut</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_mekanisme_monitoring : old('file_mekanisme_monitoring') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Bentuk Dampak Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->bentuk_dampak : old('bentuk_dampak') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Bentuk Dampak Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_bentuk_dampak : old('file_bentuk_dampak') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Difusi dan Replikasi Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->potensi_replikasi : old('potensi_replikasi') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Difusi dan Replikasi Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_potensi_replikasi : old('file_potensi_replikasi') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Sumber Daya</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->sumber_daya : old('sumber_daya') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Sumber Daya</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_sumber_daya : old('file_sumber_daya') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Strategi Keberlanjutan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {!! $data != null ? $data->strategi_keberlanjutan : old('strategi_keberlanjutan') !!}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Link File Strategi Keberlanjutan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->file_strategi_keberlanjutan : old('file_strategi_keberlanjutan') }}
                    </div>
                </div>
 
            </div>
        </div>
        @if (Auth::user()->role == 2)
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                onclick="modal({{ $data->id }}, 'kovablik_status')">Update Status Proposal</button>
        @endif
        <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light">
        Kembali
        </a>
    @endif

@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
