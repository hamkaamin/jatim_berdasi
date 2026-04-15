@extends('layouts.main')

@section('title')
    Penilaian Inovasi
@endsection

@section('title-desc')
    Form untuk Menilai Data Inovasi dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="container">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">Form Penilaian Inovasi {{ $inovasi->nama }}</h5>

                <div class="alert {{ @$penilaian_map->signature_path ? 'alert-success' : 'alert-warning' }} d-flex align-items-center"
                    role="alert">
                    <i
                        class="fas {{ @$penilaian_map->signature_path ? 'fa-check-circle' : 'fa-exclamation-triangle' }} fa-lg me-2"></i>
                    <div>
                        {{ @$penilaian_map->signature_path ? 'Sudah Ditandatangani' : 'Belum Ditandatangani' }}
                    </div>
                </div>
                <form
                    action="{{ route('penilaian.save', ['inovasi_id' => $inovasi->id, 'penilaian_map' => @$penilaian_map->id]) }}"
                    method="post" enctype="multipart/form-data" id="form-penilaian">
                    @csrf
                    <!-- Judul Kolom -->
                    <div class="row fw-bold border-bottom pb-2 mb-3">
                        <div class="col-md-3"><strong>Bagian</strong></div>
                        <div class="col-md-3"><strong>Indikator</strong></div>
                        <div class="col-md-3"><strong>Catatan / Saran</strong></div>
                        <div class="col-md-3"><strong>Nilai</strong></div>
                    </div>

                    @php
                        $no = 0;
                        $totalNilai = 0;
                    @endphp
                    @foreach ($data as $index => $item)
                        @php
                            $no++;
                            $totalNilai += optional($item->pivot)->nilai;
                        @endphp
                        <div class="card mb-3 border-0 shadow-sm p-3">
                            <div class="row">
                                <!-- Bagian -->
                                <div class="col-md-3 d-flex align-items-center">
                                    <label class="form-label"><strong>{{ $item->bagian }}</strong></label>
                                </div>

                                <!-- Indikator -->
                                <div class="col-md-3">
                                    <p class="mb-0">{!! $item->indikator !!}</p>
                                </div>

                                <!-- Catatan Saran -->
                                <div class="col-md-3">
                                    <input type="text" class="form-control"
                                        name="keterangan_{{ $item->pivot->penilaian_id }}"
                                        id="keterangan_{{ $item->pivot->penilaian_id }}"
                                        value="{{ optional($item->pivot)->catatan_saran }}">
                                </div>

                                <!-- Nilai -->
                                <div class="col-md-3">
                                    <input type="number" class="form-control" min="{{ $item->nilai_min }}"
                                        max="{{ $item->nilai_max }}" name="nilai_{{ $item->pivot->penilaian_id }}"
                                        id="nilai_{{ $item->pivot->penilaian_id }}"
                                        value="{{ optional($item->pivot)->nilai }}">
                                    <small>Nilai :{{ $item->nilai_min }} s.d. {{ $item->nilai_max }}</small>
                                </div>
                            </div>
                            <hr class="my-0">
                        </div>
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

                        <input type="hidden" name="signature_data" id="signature_data" value="">
                        <input type="hidden" name="juri_id" id="juri_id" value="{{ $juri->id }}">

                        <strong>Total Nilai:</strong>
                        <span class="h4 font-weight-bold">{{ $totalNilai }}</span>
                    </div>


                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penilaian.ranking', ['jenis' => $jenis, 'tahap' => $juri_tahap]) }}"
                            class="btn btn-secondary">Kembali</a>
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
