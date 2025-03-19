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
                        <div class="col-sm-8">
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
                            <label><b>Link Google Drive Standart Pelayanan</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->link_standart : old('link_standart') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Link Google Drive Maklumat Pelayanan</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->link_maklumat : old('link_maklumat') }}
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center">
                            <label><b>Link Google Drive SK Pengelolaan Pengaduan</b></label>
                        </div>
                        <div class="col-sm-8">
                            {{ $proposal != null ? $proposal->link_sk_pengaduan : old('link_sk_pengaduan') }}
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
                        <div class="col-12 form-control">
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
                        @if ($item->tahapan_id == $proposal->tahapan_id) 
                            @php
                                $no++;
                                $totalNilai += optional($item->pivot)->nilai;
                            @endphp
                        @endif
                        @if($proposal->tahapan_id == 1)
                            @if($item->bagian == 'Latar Belakang dan Tujuan')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
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
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
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
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
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
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
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
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Penguatan Sumber Daya')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
                                            <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                            <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                            @elseif($item->bagian == 'Strategi Penguatan Keberlanjutan')
                                <div class="row my-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label>
                                                <b>{{ $item->bagian }} ({{ $item->bobot_nilai }}%)</b>
                                                {!! $item->indikator !!}
                                            </label>
                                        </div>
                                        <div class="row mx-1">
                                            <div class="form-control">
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
                                                value="{{ optional($item->pivot)->nilai }}">
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
                                            value="{{ optional($item->pivot)->nilai }}">
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
                                            value="{{ optional($item->pivot)->nilai }}">
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
                                            value="{{ optional($item->pivot)->nilai }}">
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
                                            value="{{ optional($item->pivot)->nilai }}">
                                        <input type="hidden" name="bobot_nilai_{{ $item->pivot->penilaian_id }}" value="{{ $item->bobot_nilai }}">
                                        <small>min : {{ $item->nilai_min }} ; max : {{ $item->nilai_max }}</small>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach

                    <div class="card-footer d-flex flex-column align-items-center">
                        <strong>Signature:</strong>
                        <canvas id="signature-pad" class="border rounded mb-3" width="400" height="200"></canvas>
                        <button type="button" class="btn btn-danger mb-2" id="clear-signature">Clear Signature</button>

                        <strong>Total Nilai:</strong>
                        <span class="h4 font-weight-bold">{{ $totalNilai }}</span>
                    </div>
                    <input type="hidden" name="signature_data" id="signature_data"
                        value="{{ @$penilaian_map->signature_path }}">
                    <input type="hidden" value="{{ $juri->id }}" name="juri_id" id="juri_id">

                    <br>

                    <img src="{{ asset(@$penilaian_map->signature_path) }}">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penilaian-kovablik.index') }}" class="btn btn-secondary">Kembali</a>
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
    // Inisialisasi Canvas
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Load existing signature jika ada
    const existingSignature = document.getElementById('signature_data').value;
    if (existingSignature) {
        const image = new Image();
        image.onload = () => {
            ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        };
        image.src = existingSignature.startsWith('data:image') ? existingSignature : `/${existingSignature}`;
    }

    // Event menggambar di canvas
    canvas.addEventListener('mousedown', (e) => {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (drawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', () => {
        drawing = false;
    });

    canvas.addEventListener('mouseout', () => {
        drawing = false;
    });

    // Clear signature
    document.getElementById('clear-signature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('signature_data').value = '';
    });

    // Simpan tanda tangan sebelum form dikirim
    const form = document.getElementById('form-penilaian');
    form.addEventListener('submit', () => {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById('signature_data').value = signatureData;
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
