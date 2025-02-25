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
                                <small><b>{{ date('d-m-Y', strtotime($item->created_at)) }}</b></small> <span
                                    class="mx-2">|</span> <a href="#modalPopup" data-toggle="modal"
                                    onclick="modal({{ $item->id }}, 'pengumuman-preview')"
                                    class="text-dark">{{ $item->judul }}</a>
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

                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">{{ $rata_kab }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Total Inovasi Pemda</div>

                    </div>
                    <div class="card-body">
                        <h3>{{ $total_inovasi }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Total Perangkat Daerah Melapor</div>

                    </div>
                    <div class="card-body">
                        <h3>{{ $total_opd_melapor }}</h3>
                    </div>
                </div>
            </div>
            @foreach ($tahapan as $item)
                <div class="col my-2">
                    <div class="card bg-light">
                        <div class="card-header bg-light justify-content-between">
                            <div>{{ ucwords($item->nama) }}</div>

                        </div>
                        <div class="card-body">
                            @php
                                $totalTahapan = 0;
                                foreach (Auth::user()->provinsi->kota as $kota) {
                                    $totalTahapan += $kota
                                        ->inovasi()
                                        ->where('status', '<>', 0)
                                        ->where('tahapan_id', $item->id)
                                        ->count();
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
                        <h3 class="text-primary">{{ $rata_isi }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card bg-light">
                    <div class="card-header bg-light justify-content-between">
                        <div>Skor Tertinggi</div>

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
                            <table class="table align-items-center table-flush" id="myTable_iid">
                                <thead class="thead-light">
                                    <tr>
                                        {{-- <th>No.</th> --}}
                                        <th>Kota/Kabupaten</th>
                                        <th>Skor IID</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($iid as $item)
                                        <tr>
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
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
                        <div><a target="_blank" href="{{ route('export-inovasi', 0) }}" class="btn btn-primary">Unduh
                                Semua</a></div>
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
                                            <td><a target="_blank" href="{{ route('export-inovasi', $key) }}"
                                                    class="btn btn-primary">Unduh</a></td>
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
        {{-- <div class="">
            <div id="line_chart_inovasi" data-colors='["--bs-success", "--bs-warning","--bs-primary","--bs-danger"]'
                class="apex-charts" dir="ltr">
            </div>
            <div id="line_chart_inotek" data-colors='["--bs-success", "--bs-warning","--bs-primary","--bs-danger"]'
                class="apex-charts" dir="ltr">
            </div>
            <div id="column_chart_penilaian" data-colors='["--bs-success", "--bs-warning","--bs-primary","--bs-danger"]'
                class="apex-charts" dir="ltr">
            </div>
        </div> --}}
        @if (!empty($arrayCount))
            <div class="row">
                @for ($j = 0; $j <= 1; $j++)
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="col-sm-4">
                            <div class="card m-2">
                                <div class="card-header">
                                    Jumlah {{ Helper::get_label_inovasi($j) }} &nbsp; {!! Helper::getStatusInovasi($i) !!}
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
    @endif
    <div class="row">
        <div class="col-sm-4">
            <div class="card card-body m-2 d-flex flex-column justify-content-between align-items-center">
                <i class="uil-phone-alt font-size-24"></i>
                <h3>Contact Us</h3>
                <div class="d-flex flex-column align-items-center">
                    <p class="mb-0">Nama Badan : {{ $contact->nama }}</p>
                    <p class="mb-0">Alamat : {{ $contact->alamat }}</p>
                    <p class="mb-0">No telp : {{ $contact->no_telp }}</p>
                    <p class="mb-0">Email : {{ $contact->email }}</p>
                    <p class="mb-0">IG : <a target="_blank"
                            href="{{ 'https://www.instagram.com/' . $contact->instagram }}">
                            {{ $contact->instagram }}</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Auth::user()->role == 3)
    @section('script')
        @include('script.modal')
        @include('script.dataTable')
        <script>
            $(function() {
                $('[data-toggle="tooltip"]')
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable1').DataTable();

                $('#myTable_iid').DataTable({
                    order: [
                        [1, 'desc'],
                        [0, 'asc']
                    ],
                });
            });
        </script>
    @endsection
@endif

@push('scripts')
    @if (Auth::user()->role == 3)
    @elseif (Auth::user()->role == 1)
    @else
        <script>
            var LinechartDatalabelColors = getChartColorsArray("line_chart_inovasi");
            LinechartDatalabelColors &&
                ((options = {
                        chart: {
                            height: 380,
                            type: "line",
                            zoom: {
                                enabled: !1
                            },
                            toolbar: {
                                show: !1
                            },
                        },
                        colors: LinechartDatalabelColors,
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            width: [3, 3],
                            curve: "straight"
                        },
                        series: [{
                                name: "Disetujui",
                                data: [35, 15, 26, 36, 31, 24, 37]
                            },
                            {
                                name: "Revisi",
                                data: [24, 15, 21, 33, 14, 13, 41]
                            },
                            {
                                name: "Diproses",
                                data: [26, 24, 32, 36, 33, 31, 33]
                            },
                            {
                                name: "Ditolak",
                                data: [14, 11, 16, 12, 17, 13, 12]
                            },
                        ],
                        title: {
                            text: "Jumlah Inovasi Daerah",
                            align: "left"
                        },
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: 0.2
                            },
                            borderColor: "#f1f1f1",
                        },
                        markers: {
                            style: "inverted",
                            size: 6
                        },
                        xaxis: {
                            categories: ["2019", "2020", "2021", "2022", "2023", "2024", "2025"],
                            title: {
                                text: "Month"
                            },
                        },
                        yaxis: {
                            title: {
                                text: "Jumlah"
                            },
                            min: 5,
                            max: 40
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right",
                            floating: !0,
                            offsetY: -25,
                            offsetX: -5,
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    toolbar: {
                                        show: !1
                                    }
                                },
                                legend: {
                                    show: !1
                                },
                            },
                        }, ],
                    }),
                    (chart = new ApexCharts(
                        document.querySelector("#line_chart_inovasi"),
                        options
                    )).render());
            var LinechartDatalabelColors = getChartColorsArray("line_chart_inotek");
            LinechartDatalabelColors &&
                ((options = {
                        chart: {
                            height: 380,
                            type: "line",
                            zoom: {
                                enabled: !1
                            },
                            toolbar: {
                                show: !1
                            },
                        },
                        colors: LinechartDatalabelColors,
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            width: [3, 3],
                            curve: "straight"
                        },
                        series: [{
                                name: "Disetujui",
                                data: [35, 15, 26, 36, 31, 24, 37]
                            },
                            {
                                name: "Revisi",
                                data: [24, 15, 21, 33, 14, 13, 41]
                            },
                            {
                                name: "Diproses",
                                data: [26, 24, 32, 36, 33, 31, 33]
                            },
                            {
                                name: "Ditolak",
                                data: [14, 11, 16, 12, 17, 13, 12]
                            },
                        ],
                        title: {
                            text: "Jumlah Inotek Awards",
                            align: "left"
                        },
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: 0.2
                            },
                            borderColor: "#f1f1f1",
                        },
                        markers: {
                            style: "inverted",
                            size: 6
                        },
                        xaxis: {
                            categories: ["2019", "2020", "2021", "2022", "2023", "2024", "2025"],
                            title: {
                                text: "Month"
                            },
                        },
                        yaxis: {
                            title: {
                                text: "Jumlah"
                            },
                            min: 5,
                            max: 40
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right",
                            floating: !0,
                            offsetY: -25,
                            offsetX: -5,
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    toolbar: {
                                        show: !1
                                    }
                                },
                                legend: {
                                    show: !1
                                },
                            },
                        }, ],
                    }),
                    (chart = new ApexCharts(
                        document.querySelector("#line_chart_inotek"),
                        options
                    )).render());

            var BarchartColumnColors = getChartColorsArray("column_chart_penilaian");
            BarchartColumnColors &&
                ((options = {
                        chart: {
                            height: 350,
                            type: "bar",
                            toolbar: {
                                show: !1
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: !1,
                                columnWidth: "45%",
                                endingShape: "rounded"
                            },
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            show: !0,
                            width: 2,
                            colors: ["transparent"]
                        },
                        series: [{
                                name: "Unggul",
                                data: [46, 57, 59, 54, 62, 58, 64]
                            },
                            {
                                name: "Cukup",
                                data: [74, 83, 102, 97, 86, 106, 93]
                            },
                            {
                                name: "Bagus",
                                data: [37, 42, 38, 26, 47, 50, 54],
                            },
                        ],
                        title: {
                            text: "Jumlah Penilaian",
                            align: "left"
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right",
                            floating: !0,
                            offsetY: -25,
                            offsetX: -5,
                        },
                        colors: BarchartColumnColors,
                        xaxis: {
                            categories: [
                                "2019",
                                "2020",
                                "2021",
                                "2022",
                                "2023",
                                "2024",
                                "2025",
                            ],
                        },
                        yaxis: {
                            title: {
                                text: "Jumlah Penilaian"
                            }
                        },
                        grid: {
                            borderColor: "#f1f1f1"
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(e) {
                                    return "$ " + e + " thousands";
                                },
                            },
                        },
                    }),
                    (chart = new ApexCharts(
                        document.querySelector("#column_chart_penilaian"),
                        options
                    )).render());
        </script>
    @endif
@endpush
