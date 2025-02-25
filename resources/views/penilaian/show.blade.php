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
                <h5 class="mb-4">
                    Form Penilaian Inovasi {{ $inovasi->nama }}
                    <a href="{{ route('penilaian.print', encrypt($inovasi->id)) }}" target="_blank" class="btn btn-info">
                        <i class="uil-print"></i> Cetak Penilaian
                    </a>
                </h5>   
                @foreach ($kategori_juri as $user_id)
                    <div class="card mb-4">
                        <div class="card-header">
                            @php
                                $penilaian_map = App\Models\PenilaianMap::whereIn('juri_id', function ($query) use (
                                    $user_id,
                                ) {
                                    $query->select('id')->from('juris')->where('user_id', $user_id);
                                })->first();

                            @endphp
                            <div class="row">
                                <div class="col-md-10">
                                    <h5>{{ App\Models\User::find($user_id)->name }} </h5>
                                </div>

                                <div class="d-flex col-md-2">
                                    <i
                                        class="fas {{ @$penilaian_map->signature_path ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-warning' }} fa-2x"></i>
                                    <div class="fw-semibold">
                                        {{ @$penilaian_map->signature_path ? 'Sudah Ditandatangani' : 'Belum Ditandatangani' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Bagian</th>
                                        <th>Indikator</th>
                                        <th style="min-width: 150px;">Catatan & Saran</th>
                                        <th style="min-width: 100px;">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalNilai = 0;
                                        $no = 0;
                                    @endphp
                                    @foreach ($data as $item)
                                        @if ($item->pivot->user_id == $user_id)
                                            @php $no++; @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $item->bagian }}</td>
                                                <td>{!! $item->indikator !!}</td>
                                                <td>
                                                    @if ($item->pivot->catatan_saran)
                                                        {{ $item->pivot->catatan_saran }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <h4><b>{{ $item->pivot->nilai }}</b></h4>
                                                </td>
                                            </tr>
                                            @php
                                                $totalNilai += $item->pivot->nilai;
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <strong>Total Nilai:</strong>
                            <span class="h4 font-weight-bold">{{ $totalNilai }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
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
