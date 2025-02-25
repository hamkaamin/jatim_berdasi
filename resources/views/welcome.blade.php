@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('title-desc')
    Informasi mengenai keadaan sistem saat ini
@endsection

@section('content')
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
        {{-- @else
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
    @endif --}}
    @endif
@endpush
