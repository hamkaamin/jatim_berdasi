@extends('layouts.main')

@section('title')
    Master Contact Inovasi
@endsection

@section('title-desc')
    Daftar Contact untuk Data Inovasi
@endsection


@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email / No Telp</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->email }} <br> {{ $item->no_telp }}</td>
                                <td>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'contact')"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <form style="all: unset"
                                        action="{{ route('master.contact.delete', ['id' => $item->id]) }}" method="post">
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
