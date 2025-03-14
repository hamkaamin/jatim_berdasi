@extends('layouts.main')

@section('title')
    Master Kategori Penilaian Kovablik
@endsection

@section('title-desc')
    Daftar Kategori untuk Penilaian Kovablik
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
        onclick="modal(0, 'kategori_nilai_kovablik')">Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Bagian</th>
                            <th>Indikator</th>
                            <th>Nilai Min - Max</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->bagian }}</td>
                                <td>{!! $item->indikator !!}</td>
                                <td><b>{{ $item->nilai_min }}</b> - <b>{{ $item->nilai_max }}</b>
                                <td>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'kategori_nilai_kovablik')"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <form style="all: unset"
                                        action="{{ route('master.kategori_nilai_kovablik.delete', ['id' => $item->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                                            onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                                                class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.dataTable')
    @include('script.modal')
@endsection
