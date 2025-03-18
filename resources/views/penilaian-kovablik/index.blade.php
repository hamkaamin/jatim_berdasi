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
            <ul class="nav nav-tabs">
                @foreach ($tahapan as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary">
                                {{ sizeof($item->proposals) }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content mt-2">
                @foreach ($tahapan as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}" role="tabpanel">
                        <h4>Proposal Kovablik</h4>
                        <form action="{{ route('penilaian-kovablik.pass') }}" method="POST" class="table-responsive p-3">
                            @csrf
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
                                    @foreach ($data->proposals as $item)
                                        @php
                                            $user = \App\Models\User::find($item->penilaian->pluck('pivot.user_id')->first());
                                        @endphp
                                        <tr>
                                            <td><input type="checkbox" style="transform: scale(2)" name="is_pass[]" class="is_pass" value="{{ $item->id }}"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->instansi }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->kategori->nama}}</td>
                                            <td>{{ $item->kelompok->nama}}</td>
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $item->penilaian->sum('pivot.nilai') ?? '-' }}</td>
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
                                                        title="Penilaian Proposal"><i
                                                            class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                @else
                                                    <a href="{{ route('penilaian-kovablik.show', ['id' => encrypt($item->id)]) }}"
                                                        class="btn m-1 btn-block btn-sm btn-warning"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Penilaian Proposal"><i
                                                            class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" id="btnPass" class="btn btn-primary d-none">Lolos ke Tahap Wawancara</button>
                        </form>
                    </div>
                @endforeach
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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".is_pass").forEach(function (checkbox) {
                    checkbox.addEventListener("change", function () {
                        let anyChecked = document.querySelectorAll(".is_pass:checked").length > 0;
                        document.getElementById("btnPass").classList.toggle("d-none", !anyChecked);
                    });
                });
            });
        </script>
    @endsection
