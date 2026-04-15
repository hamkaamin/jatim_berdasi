@extends('layouts.main')

@section('title')
    Penilaian Inovasi
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi yang Sudah Disetujui
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <div style="width: 100%">
                        <table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th style="min-width: 100px">Dibuat Oleh</th>
                                    <th style="min-width: 200px">Nama</th>
                                    <th>Tahapan</th>
                                    <th>Kategori</th>
                                    <th style="width: 100px; min-width: 100px">Status</th>
                                    <th>Keterangan</th>
                                    <th>Kematangan</th>
                                    <th>Nilai</th>
                                    <th style="width: 100px; min-width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $data = [];

                                @endphp
                                @foreach ($inovasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->belongsToTahapan->nama }}</td>
                                        <td>{{ $item->kategori->nama ?? ' ' }}</td>
                                        <td>{!! Helper::getStatusInovasi($item->status) !!}</td>
                                        <td>
                                            @if ($item->keterangan != null)
                                                {{ $item->keterangan }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->indikator->sum('pivot.bobot_akhir') }}</td>
                                        <td>

                                            {{ $item->penilaian->sum('pivot.nilai') / sizeof($item->kategori->juris) }}
                                        </td>
                                        <td>
                                            @if ($item->status != 0)
                                                <a target="_blank"
                                                    href="{{ route('inovasi.export', ['type' => 'pdf', 'id' => $item->id]) }}"
                                                    class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip"
                                                    data-placement="top" title="Download Pdf"><i
                                                        class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                                <a target="_blank"
                                                    href="{{ route('inovasi.export', ['type' => 'excel', 'id' => $item->id]) }}"
                                                    class="btn m-1 btn-block btn-sm btn-success" data-toggle="tooltip"
                                                    data-placement="top" title="Download Excel"><i
                                                        class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                            @endif
                                            <a href="{{ route('inovasi.indikator.index', ['id' => $item->id, 'area' => 'bank_data']) }}"
                                                class="btn m-1 btn-block btn-sm btn-secondary" data-toggle="tooltip"
                                                data-placement="top" title="Upload Indikator"><i
                                                    class="fa fa-folder-open"></i>&nbsp;&nbsp;Indikator</a>
                                            @if (($item->status == 0 || Auth::user()->role == 2) && $item->status != 2)
                                                <a href="{{ route('inovasi.edit', ['id' => encrypt($item->id), 'tahap' => $juri_tahap]) }}"
                                                    class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                                    data-placement="top" title="Edit Inovasi"><i
                                                        class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                            @endif
                                            @if (
                                                ($item->status != 2 && $item->user_id == Auth::user()->id) ||
                                                    Auth::user()->username == 'salehsayanglatifah' ||
                                                    Auth::user()->username == 'pemdkotkabatest')
                                                <form style="all: unset"
                                                    action="{{ route('inovasi.delete', ['id' => $item->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                                                        onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"
                                                        data-toggle="tooltip" data-placement="top" title="Hapus Inovasi"><i
                                                            class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                                </form>
                                            @endif

                                            @if (Auth::user()->role == 7)
                                                <a href="{{ route('penilaian.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id, 'jenis' => $jenis]) }}"
                                                    class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                                    data-placement="top" title="Penilaian Inovasi"><i
                                                        class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                            @else
                                                <a href="{{ route('penilaian.show', ['id' => encrypt($item->id), 'jenis' => $jenis]) }}"
                                                    class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                                    data-placement="top" title="Penilaian Inovasi"><i
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
