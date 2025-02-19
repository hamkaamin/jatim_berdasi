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
                <h5 class="mb-3">Form Penilaian Inovasi</h5>

                <form action="{{ route('penilaian.save', ['inovasi_id' => $inovasi->id]) }}" method="post"
                    enctype="multipart/form-data" id="form-penilaian">
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
                                </div>
                            </div>
                            <hr class="my-0">
                        </div>
                    @endforeach
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <strong>Total Nilai:</strong>
                        <span class="h4 font-weight-bold">{{ $totalNilai }}</span>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <h3>
            Inotek Sudah Ditutup Per 5 Mei 2023, 22.00
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
