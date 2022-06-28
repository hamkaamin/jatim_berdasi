@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('title-desc')
    Informasi mengenai keadaan sistem saat ini
@endsection

@section('content')
    @if (Auth::user()->role == 3)
        <div class="row">
            <div class="col">
                <div class="card bg-light">
                    <div class="card-header bg-light">Pengumuman</div>
                    <div class="card-body" style="overflow-y: scroll; height:100px;">
                        @foreach ($pengumuman as $item)
                            <p class="card-text">
                                <small><b>{{ date('d-m-Y', strtotime($item->created_at)) }}</b></small> <span class="mx-2">|</span> <a href="#modalPopup" data-toggle="modal" onclick="modal({{ $item->id }}, 'pengumuman-preview')" class="text-dark">{{ $item->judul }}</a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <div class="col">
                <div class="card bg-light">
                    <div class="card-header bg-light">Presentasi Kepala Daerah</div>
                    <div class="card-body" style="height:100px;">
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mt-5">
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Indeks Rata-Rata Kota</div>
                        {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">{{ $rata_kota }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Indeks Rata-Rata Kabupaten</div>
                        {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">{{ $rata_kab }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-12 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Total Inovasi Pemda</div>
                        {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                    </div>
                    <div class="card-body">
                        <h3>{{ $total_inovasi }}</h3>
                    </div>
                </div>
            </div>
            @foreach ($tahapan as $item)
                <div class="col my-2">
                    <div class="card bg-light">
                        <div class="card-header bg-light justify-content-between">
                            <div>{{ ucwords($item->nama) }}</div>
                            {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                        </div>
                        <div class="card-body">
                            @php
                                $totalTahapan = 0;
                                foreach (Auth::user()->provinsi->kota as $kota) {
                                    $totalTahapan += $kota->inovasi()->where('status', '<>', 0)->where('tahapan_id', $item->id)->count();
                                }
                            @endphp
                            <h3>{{ $totalTahapan }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Rata - rata Kematangan</div> 
                    </div>
                    <div class="card-body">
                        <h3 class="text-danger">{{ rand(0,1000) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Skor Tertinggi</div>
                        {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                    </div>
                    <div class="card-body">
                        <h3>{{ $max['nama'] }} ({{ $max['skor'] }})</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Skor Terendah</div>
                        {{-- <div><h4 class="p-0 m-0"><i class="fa fa-info-circle" data-toggle="tooltip" data-html="true" title="Halo"></i></h4></div> --}}
                    </div>
                    <div class="card-body">
                        <h3>{{ $min['nama'] }} ({{ $min['skor'] }})</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="card bg-light">
                    <div class="card-header bg-light">Indeks Inovasi Daerah</div>
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kota/Kabupaten</th>
                                        <th>Skor IID</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($iid as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['nama'] }}</td>
                                            <td>{{ $item['iid'] }}</td>
                                            <td>
                                                @if ($item['iid'] >= 60)
                                                    <span class="badge badge-success">Sangat Inovatif</span>
                                                @elseif ($item['iid'] >= 30)
                                                    <span class="badge badge-primary">Inovatif</span>
                                                @elseif ($item['iid'] >= 0.01)
                                                    <span class="badge badge-warning">Kurang Inovatif</span>
                                                @else
                                                    <span class="badge badge-danger">Belum ada data</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Data Daerah</div>
                        <div><a target="_blank" href="{{ route('export-inovasi', 0) }}" class="btn btn-primary">Unduh Semua</a></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="myTable1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kota/Kabupaten</th>
                                        <th>Jumlah Inovasi</th>
                                        <th>Jumlah Video</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_daerah as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['nama'] }}</td>
                                            <td>{{ $item['inovasi'] }}</td>
                                            <td>{{ $item['video'] }}</td>
                                            <td><a target="_blank" href="{{ route('export-inovasi', $key) }}" class="btn btn-primary">Unduh</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role == 1)
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Daftar OPD
                    </div>
                    <div class="card-body text-center p-1">
                        <h1>{{ $count_opd }}</h1>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('opd.index') }}">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Daftar Pengguna
                    </div>
                    <div class="card-body text-center p-1">
                        <h1>{{ $count_user }}</h1>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('pengguna.index') }}">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @for ($j = 0; $j <= 1; $j++)
                @for ($i = 1; $i <= 4; $i++)
                    <div class="col-sm-4">
                        <div class="card m-2">
                            <div class="card-header">
                                Jumlah Inovasi {{ Helper::get_label_inovasi($j) }} &nbsp; {!! Helper::getStatusInovasi($i) !!}
                            </div>
                            <div class="card-body text-center p-1">
                                <h1>{{ $arrayCount[$j][$i] }}</h1>
                            </div>
                            {{-- <div class="card-footer">
                                <a href="">View Details</a>
                            </div> --}}
                        </div>
                    </div>
                @endfor
            @endfor
        </div>
    @endif
@endsection

@if (Auth::user()->role == 3)
    @section('script')
        @include('script.modal')
        @include('script.dataTable')
        <script>
            $(function () {
                $('[data-toggle="tooltip"]')
            });
        </script>
        <script>
            $(document).ready( function () {
                $('#myTable1').DataTable();
            } );
        </script>
    @endsection
@endif
