@extends('layouts.main')

@section('title')
    Detail Proposal
@endsection

@section('title-desc')
    Isian detail dari data Proposal dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                @include('kovablik.partials.detail-body', ['data' => $data])
            </div>
        </div>
        @if (Auth::user()->role == 2)
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                onclick="modal({{ $data->id }}, 'kovablik_status')">Update Status Proposal</button>
        @endif
        <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light">
            Kembali
        </a>
    @endif
@endsection

@section('script')
    @include('script.select2-multiple')
    @include('script.ck-editor')
    @include('script.modal')
@endsection
