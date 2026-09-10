@extends('layouts.main')

@section('title')
    Detail Inovasi
@endsection

@section('title-desc')
    Isian detail dari data inovasi
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                @include('inovasi.partials.detail-body-kategori-5', ['data' => $data])
            </div>
        </div>
        <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @else href="{{ route('inovasi.index', ['area' => 'kota']) }}" @endif
            class="btn btn-light">
            Kembali</a>
    @endif
@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
