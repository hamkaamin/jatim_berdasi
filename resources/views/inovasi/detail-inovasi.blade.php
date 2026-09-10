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
                @include('inovasi.partials.detail-body', ['data' => $data])
            </div>
        </div>
        <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light">Kembali</a>
    @endif
@endsection
