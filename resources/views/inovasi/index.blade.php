@extends('layouts.main')

@section('title')
    Inovasi {{ $label }}
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi dari {{ $label }}
@endsection

@if (Auth::user()->role != 2)
    @section('buttons')
        <a href="{{ route('inovasi.edit', ['id' => 0, 'label' => $label == 'Awards' ? 1 : 0]) }}"
            class="btn btn-primary">Tambah Data</a>
    @endsection
@endif

@section('content')
    <div class="row">
        @if (Auth::user()->role != 2)
            <div class="col-12">
                <div class="row">
                    @foreach ($tahapan as $item)
                        <div class="col-3">
                            <div class="card mb-3 widget-content bg-midnight-bloom">
                                <div class="widget-content-wrapper text-white">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">{{ $item->nama }}</div>
                                        <div class="widget-subheading">Inovasi Tahap <b>{{ $item->nama }}</b></div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-white">
                                            <span>
                                                @php
                                                    $inov = $item->hasManyInovasi();
                                                    if ($label == 'Masyarakat' || $label == 'Awards') {
                                                        $inov = $inov->where('label', 0);
                                                    } elseif ($label == 'Pemda') {
                                                        $inov = $inov->where('label', 1);
                                                    } elseif ($label == 'Daerah') {
                                                        $inov = $inov->where('status', 2);
                                                    }
                                                    if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
                                                        $inov = $inov->where('provinsi_id', Auth::user()->province_id);
                                                    } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
                                                        $inov = $inov->where('provinsi_id', Auth::user()->opd->provinsi_id);
                                                    } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
                                                        $inov = $inov->where('kota_id', Auth::user()->regency_id);
                                                    } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
                                                        $inov = $inov->where('kota_id', Auth::user()->opd->kabkota_id);
                                                    } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
                                                        $inov = $inov->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
                                                    } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
                                                        $inov = $inov->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
                                                    }
                                                @endphp
                                                {{ $inov->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <x-tab-inovasi :tahapan="null" :active="1" />
                @foreach ($tahapan as $item)
                    <x-tab-inovasi :tahapan="$item" :active="0" />
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                <x-tab-content-inovasi :tahapan="null" :active="1" :kolom="$tahapanKolom" :inovasi="$inovasi" />
                @foreach ($tahapan as $item)
                    <x-tab-content-inovasi :tahapan="$item" :active="0" :kolom="$tahapanKolom" :inovasi="[]" />
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
    <script>
        $(document).ready(function() {
            $('#myTable0').DataTable({});
        });
    </script>
    @foreach ($tahapan as $item)
        <script>
            $(document).ready(function() {
                $('#myTable{{ $item->id }}').DataTable();
            });
        </script>
    @endforeach
    <script>
        $(function() {
            $('[data-toggle="tooltip"]')
        });
    </script>
@endsection
