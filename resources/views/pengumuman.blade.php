@extends('layouts.main')

@section('title')
    Master Pengumuman
@endsection

@section('title-desc')
    Daftar Pengumuman untuk ditampilkan pada Dashboard
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
        onclick="modal(0, 'pengumuman')">Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>File</th>
                            <th>Dibuat Pada</th>
                            <th>Update Terakhir</th>
                            <th>Aktif</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{!! $item->deskripsi !!}</td>
                                <td>
                                    @if ($item->file != null && file_exists(public_path('/file_pengumuman/' . $item->file)))
                                        <a target="_blank" href="{{ asset('file_pengumuman/' . $item->file) }}">View</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>

                                <td>
                                    @if ($item->is_aktif == 1)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'pengumuman')"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <form style="all: unset" action="{{ route('pengumuman.delete', ['id' => $item->id]) }}"
                                        method="post">
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
