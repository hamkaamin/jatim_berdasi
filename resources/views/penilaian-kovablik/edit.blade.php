@extends('layouts.main')

@section('title')
    Penilaian Kovablik
@endsection

@section('title-desc')
    Form untuk Menilai Proposal Kovablik dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        @include('penilaian.partials.split-pane-assets')

        <h5 class="mb-3">Form Penilaian Kovablik {{ $proposal->judul }} <small class="text-muted">— Tahap
                {{ $proposal->juri_tahap }}</small></h5>

        <form action="{{ route('penilaian-kovablik.save', ['proposal_id' => $proposal->id, 'penilaian_map' => optional($penilaian_map)->id]) }}"
            method="post" id="form-penilaian">
            @csrf
            <input type="hidden" name="juri_id" value="{{ $juri->id }}">
            <input type="hidden" name="signature_data" id="signature_data" value="">

            <div class="split-container" data-storage-key="penilaian-kovablik">
                <div class="split-pane split-left">
                    <h6 class="fw-bold mb-2 sticky-top bg-white py-1">Data Proposal</h6>
                    @include('kovablik.partials.detail-body', ['data' => $proposal])
                </div>

                <div class="split-gutter" role="separator" aria-orientation="vertical"></div>

                <div class="split-pane split-right" id="scoring-pane"
                    data-has-signature="{{ optional($penilaian_map)->signature_path ? 1 : 0 }}">
                    <div class="alert {{ optional($penilaian_map)->signature_path ? 'alert-success' : 'alert-warning' }} d-flex align-items-center py-2"
                        role="alert">
                        <i class="fas {{ optional($penilaian_map)->signature_path ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2"></i>
                        <div>{{ optional($penilaian_map)->signature_path ? 'Sudah Ditandatangani' : 'Belum Ditandatangani' }}</div>
                    </div>

                    <div class="rubric-tree">
                        @include('penilaian.partials.rubric-node', [
                            'nodes' => $tree,
                            'depth' => 0,
                            'prefix' => '',
                        ])
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-3">
                        <strong>Total Nilai</strong>
                        <span class="h4 mb-0" id="grand-total">{{ round($grandTotal, 2) }}</span>
                    </div>

                    <div class="d-flex flex-column align-items-center mt-3">
                        <strong>Tanda Tangan</strong>
                        <img src="{{ asset(optional($penilaian_map)->signature_path ?? '') }}" alt="Signature"
                            class="img-fluid mb-2" id="signature-image"
                            style="{{ optional($penilaian_map)->signature_path ? '' : 'display: none;' }}">
                        <canvas id="signature-pad" class="border rounded mb-2" width="360" height="180"
                            style="{{ optional($penilaian_map)->signature_path ? 'display: none;' : '' }}"></canvas>
                        <button type="button" class="btn btn-danger btn-sm" id="clear-signature">Clear</button>
                        <small class="text-muted mt-1">Wajib tanda tangan baru setiap menyimpan.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('penilaian-kovablik.ranking', ['tahap' => $juri_tahap]) }}"
                    class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    @else
        <h3>Aplikasi Sudah Ditutup</h3>
    @endif
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    @include('penilaian.partials.rubric-scripts')
@endsection
