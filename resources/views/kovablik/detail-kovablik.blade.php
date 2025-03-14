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
            </div>
        </div>
        <a @if ($label == 1) href="{{ route('kovablik.index', ['area' => 'masyarakat']) }}" @else href="{{ route('kovablik.index', ['area' => 'kota']) }}" @endif
            class="btn btn-light">
            Kembali</a>
        {{-- @if ($data != null && $data->status == 0)
            <form style="all: unset" action="{{ route('kovablik.save', ['id' => $data->id]) }}" method="post">
                @csrf
                <input type="hidden" name="label" value="{{ $data->label }}">
                <button type="submit" class="btn btn-primary" name="status" value="1"
                    onclick="if(!confirm('Apakah Anda yakin akan submit data Proposal ini? (Pastikan seluruh isian wajib telah terisi)')){return false;}">Kirim
                    Inovasi</button>
            </form>
        @endif --}}

        {{-- @if (Auth::user()->role == 2)
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                onclick="modal({{ request()->id }}, 'proposal_status')">Update Status Proposal</button>
        @endif --}}
    @endif

@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
