@extends('layouts.main')

@section('title')
    Master Penilaian
@endsection

@section('title-desc')
    Daftar Penilaian dan masing-masing Parameternya untuk Penilaian Inovasi
@endsection

@section('buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup" onclick="modal(0, 'penilaian')">
        Tambah Data</button>
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
                @foreach ($data_kategori as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary">
                                {{ \Helper::countAspek($treePerKategori[$item->id]) }}
                            </span>
                        </a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content">
                @foreach ($data_kategori as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}"
                        role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Penilaian Inovasi</h4>
                            @if ($treePerKategori[$data->id]->isNotEmpty())
                                <form method="post" action="{{ route('master.penilaian.delete-all') }}" style="all: unset"
                                    class="form-hapus-semua" data-nama="kategori {{ $data->nama }}">
                                    @csrf
                                    <input type="hidden" name="kategori_id" value="{{ $data->id }}">
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
                                    @if ($treePerKategori[$data->id]->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Tidak ada data{{ $q !== '' ? ' untuk pencarian "' . $q . '"' : '' }}.
                                            </td>
                                        </tr>
                                    @else
                                        @include('master.partials.aspek-rows', [
                                            'nodes' => $treePerKategori[$data->id],
                                            'depth' => 0,
                                            'prefix' => '',
                                            'modalType' => 'penilaian',
                                            'deleteRoute' => 'master.penilaian.delete',
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
    <hr>
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
    <script>
        var appendCount = 0; // Initialize the count variable outside the function

        function tambahParameter(indikator_id) {
            appendCount++;
            $.ajax({
                type: 'POST',
                url: '{{ route('master.parameter.add') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    appendCount: appendCount,
                    indikator_id: indikator_id
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
