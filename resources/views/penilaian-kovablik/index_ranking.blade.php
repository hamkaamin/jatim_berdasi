@extends('layouts.main')

@section('title')
    Penilaian Proposal Kovablik
@endsection

@section('title-desc')
    Daftar Pengajuan Proposal Kovablik yang Sudah Disetujui
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <div style="width: 100%">
                        <div class="tab-content">
                            <h4>Proposal Kovablik</h4>
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Instansi</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Kelompok</th>
                                        <th>Juri</th>
                                        <th>Nilai</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [];
                                    @endphp
                                    @foreach ($proposal as $item)
                                        <tr>
                                            <td><input type="checkbox" style="transform: scale(2)" name="is_sent[]" id="is_sent[]" value="{{ $item->id }}"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->instansi }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->kategori->nama}}</td>
                                            <td>{{ $item->kelompok->nama}}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @if ($item->status != 0)
                                                    <a target="_blank"
                                                        href="{{ route('kovablik.export', ['type' => 'pdf', 'id' => $item->id]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-info"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Download Pdf"><i
                                                            class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                                    <a target="_blank"
                                                        href="{{ route('kovablik.export', ['type' => 'excel', 'id' => $item->id]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-success"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Download Excel"><i
                                                            class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                                @endif
                                                @if (($item->status == 0 || Auth::user()->role == 2) && $item->status != 2)
                                                    <a href="{{ route('kovablik.edit', ['id' => encrypt($item->id)]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-warning"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Edit Inovasi"><i
                                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                                @endif
                                                @if (
                                                    ($item->status != 2 && $item->user_id == Auth::user()->id) ||
                                                        Auth::user()->username == 'salehsayanglatifah' ||
                                                        Auth::user()->username == 'pemdkotkabatest')
                                                    <form style="all: unset"
                                                        action="{{ route('kovablik.delete', ['id' => $item->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn m-1 btn-block btn-sm btn-danger"
                                                            onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Hapus Inovasi"><i
                                                                class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                                    </form>
                                                @endif

                                                @if (Auth::user()->role == 7)
                                                    <a href="{{ route('penilaian-kovablik.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-warning"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Penilaian Inovasi"><i
                                                            class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                @else
                                                    <a href="{{ route('penilaian-kovablik.show', ['id' => encrypt($item->id)]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-warning"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Penilaian Inovasi"><i
                                                            class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection

    @section('script')
        @include('script.ubahWilayah')
        @include('script.ubahScopeOpd')
        <script>
            $(document).ready(function() {
                $('#myTable0').DataTable({});
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]')
            });
        </script>
    @endsection
