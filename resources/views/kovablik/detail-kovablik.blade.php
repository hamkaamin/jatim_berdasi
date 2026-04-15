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
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Judul Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->judul : old('judul') }}
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
                        <label><b>Dokumen Standart Pelayanan</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->link_standart)
                            <a href="{{ url($data->link_standart) }}" target="_blank">Download File Dokumen Standart Pelayanan</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Dokumen Maklumat Pelayanan</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->link_maklumat)
                            <a href="{{ url($data->link_maklumat) }}" target="_blank">Download File Dokumen Maklumat Pelayanan</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Dokumen SK Pengelolaan Pengaduan</b></label>
                    </div>
                    <div class="col-sm-8">
                        @if ($data != null && $data->link_sk_pengaduan)
                            <a href="{{ url($data->link_sk_pengaduan) }}" target="_blank">Download File Dokumen SK Pengelolaan Pengaduan</a>
                        @else
                            Tidak Ada Data
                        @endif
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Instansi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->instansi : old('instansi') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Tanggal Inovasi Dimulai</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->tanggal_mulai : old('tanggal_mulai') }}
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
                        <label><b>No Tlpn.</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->no_telpon_inovator : old('no_telpon_inovator') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Email</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->email_inovator : old('email_inovator') }}
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
                        <label><b>Ringkasan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->ringkasan : old('ringkasan') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Latar Belakang dan Tujuan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->latar_belakang : old('latar_belakang') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Kebaruan/Nilai Tambah</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->nilai_tambah : old('nilai_tambah') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Implementasi Inovasi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->implementasi : old('implementasi') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Signifikansi</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->signifikansi : old('signifikansi') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Adaptabilitas</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->adaptabilitas : old('adaptabilitas') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Sumber Daya</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->sumber_daya : old('sumber_daya') }}
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-3 d-flex align-items-center">
                        <label><b>Strategi Keberlanjutan</b></label>
                    </div>
                    <div class="col-sm-8">
                        {{ $data != null ? $data->strategi_keberlanjutan : old('strategi_keberlanjutan') }}
                    </div>
                </div>    
            </div>
        </div>
        @if (Auth::user()->role == 2)
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                onclick="modal({{ $data->id }}, 'kovablik_status')">Update Status Proposal</button>
        @endif
        <a href="{{ $label == 2 ? route('kovablik.index', ['area' => 'masyarakat']) : route('kovablik.index', ['area' => 'kota']) }}" class="btn btn-light">
        Kembali
        </a>
    @endif

@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
