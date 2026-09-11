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
            <form method="get" class="d-flex mb-3" style="max-width: 420px">
                <input type="text" name="q" value="{{ $q }}" class="form-control me-2" placeholder="Cari aspek...">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                @if ($q !== '')
                    <a href="{{ url()->current() }}" class="btn btn-secondary ms-2">Reset</a>
                @endif
            </form>

            <ul class="nav nav-tabs">
                @foreach ($data_tahapan as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary">
                                {{ \Helper::countAspek($treePerTahapan[$item->id]) }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($data_tahapan as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Kategori Nilai Kovablik</h4>
                            @if ($treePerTahapan[$data->id]->isNotEmpty())
                                <form method="post" action="{{ route('master.kategori_nilai_kovablik.delete-all') }}"
                                    style="all: unset" class="form-hapus-semua" data-nama="tahapan {{ $data->nama }}">
                                    @csrf
                                    <input type="hidden" name="tahapan_id" value="{{ $data->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus Semua</button>
                                </form>
                            @endif
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush" id="tabel-{{ $data->id }}">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Aspek</th>
                                        <th>Nilai Min - Max</th>
                                        <th>Bobot Nilai</th>
                                        <th style="width: 140px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($treePerTahapan[$data->id]->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Tidak ada data{{ $q !== '' ? ' untuk pencarian "' . $q . '"' : '' }}.
                                            </td>
                                        </tr>
                                    @else
                                        @include('master.partials.aspek-rows', [
                                            'nodes' => $treePerTahapan[$data->id],
                                            'depth' => 0,
                                            'prefix' => '',
                                            'modalType' => 'kategori_nilai_kovablik',
                                            'deleteRoute' => 'master.kategori_nilai_kovablik.delete',
                                        ])
                                    @endif
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
    @include('script.modal')
    <script>
        document.querySelectorAll('.form-hapus-semua').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Semua Aspek?',
                    html: 'Semua aspek penilaian pada <b>' + (form.dataset.nama || 'kelompok ini') +
                        '</b> akan dihapus.<br>Tindakan ini tidak bisa dibatalkan dari aplikasi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus semua',
                    cancelButtonText: 'Batal'
                }).then(function(r) {
                    if (r.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endsection
