@extends('layouts.main')

@section('title')
    Penilaian Proposal
@endsection

@section('title-desc')
    Form untuk Menilai Proposal Kovablik dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="container">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">Form Penilaian Proposal</h5>

                <div class="alert {{ @$penilaian_map->signature_path ? 'alert-success' : 'alert-warning' }} d-flex align-items-center"
                    role="alert">
                    <i
                        class="fas {{ @$penilaian_map->signature_path ? 'fa-check-circle' : 'fa-exclamation-triangle' }} fa-lg me-2"></i>
                    <div>
                        {{ @$penilaian_map->signature_path ? 'Sudah Ditandatangani' : 'Belum Ditandatangani' }}
                    </div>
                </div>
                <form
                    action="{{ route('penilaian-kovablik.save', ['proposal_id' => $proposal->id, 'penilaian_map' => @$penilaian_map->id]) }}"
                    method="post" enctype="multipart/form-data" id="form-penilaian">
                    @csrf
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Judul Inovasi</b></label>
                        </div>
                        <div class="col-sm-8" style="word-wrap: break-word; overflow-wrap: break-word;">
                            {{ $proposal != null ? $proposal->judul : old('judul') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Kelompok Inovasi</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null && $proposal->kelompok ? $proposal->kelompok->nama : 'Tidak Ada Data' }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Dokumen Standart Pelayanan</b></label>
                        </div>
                        <div class="col-sm-8">
                            @if ($proposal != null && $proposal->link_standart)
                                <a href="{{ $proposal->link_standart }}" target="_blank">Download File Dokumen Standart Pelayanan</a>
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
                            @if ($proposal != null && $proposal->link_maklumat)
                                <a href="{{ $proposal->link_maklumat }}" target="_blank">Download File Dokumen Maklumat Pelayanan</a>
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
                            @if ($proposal != null && $proposal->link_sk_pengaduan)
                                <a href="{{ $proposal->link_sk_pengaduan }}" target="_blank">Download File Dokumen SK Pengelolaan Pengaduan</a>
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
                            {{ $proposal != null ? $proposal->instansi : old('instansi') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Tanggal Inovasi Dimulai</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->tanggal_mulai : old('tanggal_mulai') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Penanggung Jawab/Inovator</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->nama_inovator : old('nama_inovator') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>No Tlpn.</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->no_telpon_inovator : old('no_telpon_inovator') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Email</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->email_inovator : old('email_inovator') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Kategori</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null && $proposal->kategori ? $proposal->kategori->nama : 'Tidak Ada Data' }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-12 d-flex align-items-center">
                            <label>
                                <b>Ringkasan</b>
                                <ul>
                                    <li>Jelaskan secara ringkas mengenai inovasi yang diusulkan, setidaknya meliputi : implementasi, dampak, dan relevansi inovasi dengan kategori yang dipilih.</li>
                                    <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                    <li>maksimal 200 kata</li>
                                </ul>
                            </label>
                        </div>
                        <div class="col-12 form-control" style="height: auto; min-height: 60px; white-space: pre-wrap; overflow-wrap: break-word;">
                            {{ $proposal != null ? $proposal->ringkasan : old('ringkasan') }}
                        </div>
                    </div>
                    <hr class="border-dark">
                    <h4>Penilaian</h4>

                    @php
                        $no = 0;
                        $totalNilai = 0;
                    @endphp
                    @foreach ($data as $index => $item)
                        @if ($item->tahapan_id == $proposal->juri_tahap) 
                            @php
                                $no++;
                                $totalNilai += optional($item->pivot)->nilai;
                            @endphp
                        @endif
                        @if($proposal->juri_tahap == 1)
                            @if($item->bagian == 'Latar Belakang')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->latar_belakang : old('latar_belakang') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Tujuan')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->tujuan_outcome : old('tujuan_outcome') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Cara Kerja Inovasi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->cara_kerja : old('cara_kerja') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Mekanisme Monitoring dan Evaluasi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->mekanisme_monitoring : old('mekanisme_monitoring') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Dampak Inovasi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->bentuk_dampak : old('bentuk_dampak') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Kebaruan/Nilai Tambah')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->nilai_tambah : old('nilai_tambah') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Keunggulan Ide/Gagasan')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->kebaharuan : old('kebaharuan') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Implementasi Inovasi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->implementasi : old('implementasi') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Signifikansi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->signifikansi : old('signifikansi') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Adaptabilitas')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->adaptabilitas : old('adaptabilitas') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Sumber Daya')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->sumber_daya : old('sumber_daya') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Strategi Keberlanjutan')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->strategi_keberlanjutan : old('strategi_keberlanjutan') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Difusi dan Replikasi Inovasi')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control" style="height: auto; min-height: 40px; white-space: pre-wrap; overflow-wrap: break-word;">
                                                {{ $proposal != null ? $proposal->potensi_replikasi : old('potensi_replikasi') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row my-2">
                                            <label>Catatan/Saran</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $item->pivot->penilaian_id }}"
                                                id="keterangan_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->catatan_saran }}">
                                        </div>
                                        <div class="row">
                                            <label>Nilai</label>
                                            <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                                max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                                id="nilai_{{ $item->pivot->penilaian_id }}"
                                                value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @endif
                        @else
                            @if($item->bagian == 'Penyampaian Paparan')
                                <div class="row my-2">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label><b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Catatan/Saran</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_{{ $item->pivot->penilaian_id }}"
                                            id="keterangan_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->catatan_saran }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nilai</label>
                                        <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                            max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                            id="nilai_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                        <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                        <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                    </div>
                                </div>
                            @elseif($item->bagian == 'Materi Inovasi / Kemanfaatan / Replikasi')
                            <div class="row my-2">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label><b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Catatan/Saran</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_{{ $item->pivot->penilaian_id }}"
                                            id="keterangan_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->catatan_saran }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nilai</label>
                                        <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                            max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                            id="nilai_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                        <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                        <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                    </div>
                                </div>
                            @elseif($item->bagian == 'Video')
                            <div class="row my-2">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label><b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Catatan/Saran</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_{{ $item->pivot->penilaian_id }}"
                                            id="keterangan_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->catatan_saran }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nilai</label>
                                        <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                            max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                            id="nilai_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                        <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                        <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                    </div>
                                </div>
                            @elseif($item->bagian == 'Kehadiran Kepala Daerah / OPD / BUMD')
                            <div class="row my-2">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label><b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Catatan/Saran</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_{{ $item->pivot->penilaian_id }}"
                                            id="keterangan_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->catatan_saran }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nilai</label>
                                        <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                            max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                            id="nilai_{{ $item->pivot->penilaian_id }}"
                                            value="{{ optional($item->pivot)->nilai / ($item->bobot_nilai/100) }}">
                                        <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                        <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach

                    <div class="card-footer d-flex flex-column align-items-center">
                        <strong>Signature:</strong>
                        {{-- Signature Image (jika sudah ada) --}}
                        <img src="{{ asset($penilaian_map->signature_path ?? '') }}" alt="Signature" class="img-fluid mb-3"
                            id="signature-image"
                            style="{{ empty($penilaian_map->signature_path) ? 'display: none;' : '' }}">

                        {{-- Signature Canvas (untuk tanda tangan baru) --}}
                        <canvas id="signature-pad" class="border rounded mb-3" width="400" height="200"
                            style="{{ empty($penilaian_map->signature_path) ? '' : 'display: none;' }}"></canvas>
                        <button type="button" class="btn btn-danger mb-2" id="clear-signature">Clear Signature</button>

                        <strong>Total Nilai:</strong>
                        <span class="h4 font-weight-bold">{{ $totalNilai }}</span>
                    </div>
                    <input type="hidden" name="signature_data" id="signature_data"
                        value="{{ @$penilaian_map->signature_path }}">
                    <input type="hidden" value="{{ $juri->id }}" name="juri_id" id="juri_id">

                    <br>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penilaian.ranking', ['jenis' => 'inotek', 'tahap' => $juri_tahap]) }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <h3>
            Inotek Sudah Ditutup 
        </h3>
    @endif
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById("signature-pad");
        const ctx = canvas?.getContext("2d");
        const clearButton = document.getElementById("clear-signature");
        const signatureDataInput = document.getElementById("signature_data");
        const img = document.getElementById("signature-image");

        let drawing = false;

        // Event untuk menggambar tanda tangan
        if (canvas && ctx) {
            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            });

            canvas.addEventListener("mousemove", function(e) {
                if (drawing) {
                    ctx.lineTo(e.offsetX, e.offsetY);
                    ctx.stroke();
                }
            });

            canvas.addEventListener("mouseup", function() {
                drawing = false;
                saveSignature();
            });

            canvas.addEventListener("mouseleave", function() {
                drawing = false;
            });

            function saveSignature() {
                const dataURL = canvas.toDataURL("image/png");
                signatureDataInput.value = dataURL;
            }
        }

        // Tombol clear
        clearButton.addEventListener("click", function() {
            // Kalau sebelumnya ada gambar (sudah ditandatangani)
            if (img && img.style.display !== "none") {
                img.style.display = "none";
                canvas.style.display = "block";
                signatureDataInput.value = "";

                if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
            // Kalau lagi tanda tangan pakai canvas
            else if (canvas && ctx) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                signatureDataInput.value = "";
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);

        // Clear signature
        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Simpan signature sebelum form dikirim
        const form = document.getElementById('form-penilaian');
        form.addEventListener('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault(); // Mencegah form terkirim
                alert('Silakan tanda tangan terlebih dahulu sebelum menyimpan.');
                return false;
            } else {
                // Simpan signature ke dalam input hidden
                const signatureData = signaturePad.toDataURL();
                document.getElementById('signature_data').value = signatureData;
            }
        });

    });
</script>
@include('script.ck-editor')

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paginate: false
            });
        });
    </script>
    {{-- @include('script.select2-multiple') --}}
    @include('script.modal')
    @include('script.ck-editor')
@endsection
