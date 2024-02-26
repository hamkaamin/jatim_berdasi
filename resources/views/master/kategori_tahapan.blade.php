@extends('layouts.main')

@section('title')
    Master Tahapan Inovasi
@endsection

@section('title-desc')
    Daftar Tahapan untuk Data Inovasi
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
        onclick="modal(0, 'kategori_tahapan')">Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs">
                @foreach ($data_kategori as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            Kategori {{ $item->kode }} <span class="badge badge-primary">
                                {{ sizeof($item->tahapan) }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach ($data_kategori as $datas)
                    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab-{{ $datas->id }}" role="tabpanel">
                        <h4>Tahapan Inovasi</h4>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Urutan</th>
                                        <th>Nama</th>
                                        <th>Tampilkan Kolom</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas->tahapan as $item)
                                        <tr>
                                            <td>{{ $item->tahapan->urutan }}</td>
                                            <td>{{ $item->tahapan->nama }}</td>
                                            <td>
                                                @if ($item->tahapan->tampilkan_kolom == 1)
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button data-target="#modalPopup" data-toggle="modal"
                                                    onclick="modal({{ $item->id }}, 'kategori_tahapan')"
                                                    class="btn m-1 btn-block btn-sm btn-warning"><i
                                                        class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                <form style="all: unset"
                                                    action="{{ route('master.kategoritahapan.delete', ['id' => $item->id]) }}"
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
                @endforeach

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.dataTable')
    @include('script.modal')
@endsection
