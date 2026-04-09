@extends('layouts.main')

@section('title')
    Master Fase Inovasi
@endsection

@section('title-desc')
    Daftar Fase untuk Data Inovasi
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
        onclick="modal(0, 'fase')">Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h4>Fase Inovasi</h4>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>Aktif</th>
                            <th>Tanggal Berakhir</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @foreach ($data as $item)
                            @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @if ($item->active == 1)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
                                </td>
                                <td>{{ $item->tgl_berakhir }}</td>
                                <td>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'fase')"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <form style="all: unset" action="{{ route('master.fase.delete', ['id' => $item->id]) }}"
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
