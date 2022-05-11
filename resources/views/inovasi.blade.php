@extends('layouts.main')

@section('title')
    Inovasi Masyarakat
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi dari Masyarakat
@endsection

@if (Auth::user()->role != 2)
    @section('buttons')
        <a href="{{ route('inovasi.edit', ['id' => 0]) }}" class="btn btn-primary">Tambah Data</a>
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
                                        <div class="widget-numbers text-white"><span>{{ $item->hasManyInovasi()->count() }}</span></div>
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
    <script>
        $(document).ready( function () {
            $('#myTable0').DataTable();
        } );

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    @foreach ($tahapan as $item)
        <script>
            $(document).ready( function () {
                $('#myTable{{ $item->id }}').DataTable();
            } );
        </script>
    @endforeach
@endsection