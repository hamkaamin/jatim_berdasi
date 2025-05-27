@extends('layouts.main')

@section('title')
    Master Verifikator Kovablik
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'verifikator_kovablik')">
        Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <ul class="nav nav-tabs">
                @foreach ($data_kelompok as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary">
                                {{ sizeof($item->verifikators) }}
                            </span>
                        </a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content">
                @foreach ($data_kelompok as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}"
                        role="tabpanel">
                        <h4>Verifikator Inovasi</h4>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Verifikator</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->verifikators as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}
                                            <td>
                                                <button data-target="#modalPopup" data-toggle="modal"
                                                    onclick="modal({{ $item->id }}, 'verifikator_kovablik')"
                                                    class="btn m-1 btn-sm btn-block btn-warning"><i
                                                        class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                <form style="all: unset"
                                                    action="{{ route('master.verifikator_kovablik.delete', ['id' => $item->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn m-1 btn-sm btn-block btn-danger"
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
    <hr>
@endsection

@section('script')
    @include('script.dataTable')
    @include('script.modal')
    <script>
        $(document).ready(function() {
            $('#myTable1').DataTable();
        });
    </script>
@endsection
