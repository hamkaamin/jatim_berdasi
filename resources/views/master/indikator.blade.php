@extends('layouts.main')

@section('title')
    Master Indikator dan Parameter Inovasi
@endsection

@section('title-desc')
    Daftar Indikator dan masing-masing Parameternya untuk Penilaian Inovasi
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'indikator')">
        Tambah Data</button>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <ul class="nav nav-tabs">
                @foreach ($data_kategori as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary">
                                {{ sizeof($item->indikators) }}
                            </span>
                        </a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content">
                @foreach ($data_kategori as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}"
                        role="tabpanel">
                        <h4>Indikator Inovasi</h4>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Data Pendukung</th>
                                        <th>Tipe File</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->indikators as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }} @if ($item->wajib == 1)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </td>
                                            <td>{!! $item->keterangan !!}</td>
                                            <td>{{ $item->data_pendukung }}</td>
                                            <td>{{ $item->tipe_file }}</td>
                                            <td>
                                                <button data-target="#modalPopup" data-toggle="modal"
                                                    onclick="modal({{ $item->id }}, 'indikator')"
                                                    class="btn m-1 btn-sm btn-block btn-warning"><i
                                                        class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                <button data-target="#modalPopup" data-toggle="modal"
                                                    onclick="modal({{ $item->id }}, 'parameter')"
                                                    class="btn m-1 btn-sm btn-block btn-success"><i
                                                        class="fa fa-list-ul"></i>&nbsp;&nbsp;Parameter</button>
                                                <form style="all: unset"
                                                    action="{{ route('master.indikator.delete', ['id' => $item->id]) }}"
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
    <div class="row mt-3">
        <div class="col">
            <h4>Indikator Provinsi</h4>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable1">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Data Pendukung</th>
                            <th>Tipe File</th>
                            <th>Bobot</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($indikator_inovasi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }} @if ($item->wajib == 1)
                                        <span class="text-danger">*</span>
                                    @endif
                                </td>
                                <td>{!! $item->keterangan !!}</td>
                                <td>{{ $item->data_pendukung }}</td>
                                <td>{{ $item->tipe_file }}</td>
                                <td>{{ $item->param->sum('bobot') }}</td>
                                <td>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'indikator')"
                                        class="btn m-1 btn-sm btn-block btn-warning"><i
                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <button data-target="#modalPopup" data-toggle="modal"
                                        onclick="modal({{ $item->id }}, 'parameter')"
                                        class="btn m-1 btn-sm btn-block btn-success"><i
                                            class="fa fa-list-ul"></i>&nbsp;&nbsp;Parameter</button>
                                    <form style="all: unset"
                                        action="{{ route('master.indikator.delete', ['id' => $item->id]) }}"
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
    </div>
@endsection

@section('script')
    @include('script.dataTable')
    @include('script.modal')
    <script>
        $(document).ready(function() {
            $('#myTable1').DataTable();
        });
    </script>
    <script>
        function tambahParameter() {
            $.ajax({
                type: 'POST',
                url: '{{ route('master.parameter.add') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    $('#parameter_container').append(data.msg);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function hapusParameter(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('master.parameter.delete') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#parameter_' + id).remove();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
