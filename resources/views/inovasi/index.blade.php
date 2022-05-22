@extends('layouts.main')

@section('title')
    Inovasi {{ $label }}
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi dari {{ $label }}
@endsection

@if (Auth::user()->role != 2)
    @section('buttons')
        <a href="{{ route('inovasi.edit', ['id' => 0, 'label' => $label == 'Pemda' ? 1 : 0]) }}" class="btn btn-primary">Tambah Data</a>
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
                                                @if ($label == "Masyarakat")
                                                    {{ $item->hasManyInovasi()->where('label', 0)->count() }}
                                                @elseif ($label == "Pemda")
                                                    {{ $item->hasManyInovasi()->where('label', 1)->count() }}
                                                @else
                                                    {{ $item->hasManyInovasi()->count() }}
                                                @endif
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
        @if (Auth::user()->role != 1 && Auth::user()->role != 2 && Auth::user()->role != 6)
            <div class="col-12">
                <form action="{{ route('inovasi.filter-area') }}" method="get">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <b>Filter Berdasarkan Wilayah Pembuat Inovasi :</b>
                        </div>
                        <div class="col">
                            <select onchange="ubahScopeOpd(this.value, 'col')" class="form-control" required name="scope">
                                <option selected disabled>-- Pilih Salah Satu --</option>
                                @if (in_array(Auth::user()->role, [1,2,3]) || Helper::checkOpd('provinsi', Auth::user()))
                                    <option value="provinsi">Provinsi</option>
                                    <option value="kota">Kabupaten / Kota</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Auth::user()->role == 4 || Helper::checkOpd('kota', Auth::user()))
                                    <option value="kota">Kabupaten / Kota</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Helper::checkOpd('kecamatan', Auth::user()))
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Helper::checkOpd('kelurahan', Auth::user()))
                                    <option value="kelurahan">Kelurahan</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2" id="col_scope_container"></div>
                    <div class="row mt-2 mb-4 d-flex justify-content-center"><div class="col-4"><button class="btn btn-primary btn-sm btn-block" type="submit">Filter</button></div></div>
                </form>
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
        $(document).ready( function () {
            $('#myTable0').DataTable();
        } );
    </script>
    @foreach ($tahapan as $item)
        <script>
            $(document).ready( function () {
                $('#myTable{{ $item->id }}').DataTable();
            } );
        </script>
    @endforeach
    <script>
        $(function () {
            $('[data-toggle="tooltip"]')
        });
    </script>
@endsection
