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
        @include('penilaian.partials.split-pane-assets')

        <h5 class="mb-3">Rekap Penilaian Inovasi {{ $inovasi->nama }}</h5>

        <div class="split-container" data-storage-key="penilaian-inovasi-show">
            <div class="split-pane split-left">
                <h6 class="fw-bold mb-2 sticky-top bg-white py-1">Data Inovasi</h6>
                @include('inovasi.partials.detail-body', ['data' => $inovasi])
            </div>

            <div class="split-gutter" role="separator" aria-orientation="vertical"></div>

            <div class="split-pane split-right">
                <ul class="nav nav-tabs mb-3 sticky-top bg-white pt-1">
                    @for ($i = 1; $i <= $inovasi->juri_tahap; $i++)
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-juri-{{ $i }}"
                                class="{{ $i == $inovasi->juri_tahap ? 'active' : '' }} nav-link">
                                {{ 'Tahap ' . $i }} <span class="badge badge-primary"></span>
                            </a>
                        </li>
                    @endfor
                </ul>
                <div class="tab-content">
                    @for ($i = 1; $i <= $inovasi->juri_tahap; $i++)
                        <div class="tab-pane {{ $i == $inovasi->juri_tahap ? 'active' : '' }}" id="tab-juri-{{ $i }}"
                            role="tabpanel">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('penilaian.print', [encrypt($inovasi->id), $i]) }}" target="_blank"
                                    class="btn btn-info btn-sm">
                                    <i class="uil-print"></i> Cetak Penilaian
                                </a>
                            </div>
                            @foreach ($kategori_juri as $user_id)
                                <div class="card mb-4 border">
                                    <div class="card-header bg-light">
                                        @php
                                            $penilaian_map = App\Models\PenilaianMap::where('inovasi_id', $inovasi->id)
                                                ->where('juri_tahap', $i)
                                                ->whereIn('juri_id', function ($query) use ($user_id) {
                                                    $query->select('id')->from('juris')->where('user_id', $user_id);
                                                })
                                                ->first();
                                        @endphp
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="mb-0 fw-bold">{{ App\Models\User::find($user_id)->name }}</h6>
                                            </div>

                                            <div class="col-md-4 text-md-end">
                                                <i
                                                    class="fas {{ @$penilaian_map->signature_path ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-warning' }} me-1"></i>
                                                <small class="fw-semibold">
                                                    {{ @$penilaian_map->signature_path ? 'Sudah Ditandatangani' : 'Belum Ditandatangani' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Bagian</th>
                                                        <th>Indikator</th>
                                                        <th style="min-width: 150px;">Catatan & Saran</th>
                                                        <th style="min-width: 80px;">Nilai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $rows = $inovasi
                                                            ->penilaian()
                                                            ->wherePivot('user_id', $user_id)
                                                            ->wherePivot('juri_tahap', $i)
                                                            ->get()
                                                            ->sortBy('id')
                                                            ->values();
                                                        $tree = \App\Helper\Helper::buildAspekTree($rows);
                                                        $totalNilai = $rows
                                                            ->whereNull('parent_id')
                                                            ->sum(fn($r) => optional($r->pivot)->nilai);
                                                    @endphp

                                                    @include('penilaian.partials.rekap-node', [
                                                        'nodes' => $tree,
                                                        'depth' => 0,
                                                        'prefix' => '',
                                                    ])
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center py-2">
                                        <strong>Total Nilai:</strong>
                                        <span class="h5 mb-0 font-weight-bold">{{ round($totalNilai, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-start mt-3">
            <a href="{{ route('penilaian.index', ['jenis' => $jenis ?? 'inotek']) }}" class="btn btn-secondary">Kembali</a>
        </div>
    @else
        <h3>
            Inotek Sudah Ditutup
        </h3>
    @endif
@endsection
@include('script.ck-editor')

@section('script')
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
