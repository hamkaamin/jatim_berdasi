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
                <input type="text" name="q" value="{{ $q }}" class="form-control me-2"
                    placeholder="Cari bagian / indikator...">
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
                                {{ $penilaianPerKategori[$item->id]->total() }}
                            </span>
                        </a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content">
                @foreach ($data_kategori as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}"
                        role="tabpanel">
                        <h4>Penilaian Inovasi</h4>
                        <div class="table-responsive p-3">
                            @php
                                $pg = $penilaianPerKategori[$data->id];
                                $grouped = collect($pg->items())->groupBy('bagian');
                                $baris = $pg->firstItem() ?? 0;
                            @endphp
                            <table class="table align-items-center table-flush" id="tabel-{{ $data->id }}">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Bagian</th>
                                        <th>Indikator</th>
                                        <th>Nilai Min - Max</th>
                                        <th>Bobot Nilai</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($grouped as $namaBagian => $items)
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $baris++ }}</td>
                                                @if ($loop->first)
                                                    <td rowspan="{{ $items->count() }}" class="align-middle fw-bold">
                                                        {{ $namaBagian !== '' ? $namaBagian : '-' }}
                                                    </td>
                                                @endif
                                                <td>{!! $item->indikator !!}</td>
                                                <td><b>{{ $item->nilai_min }}</b> - <b>{{ $item->nilai_max }}</b></td>
                                                <td>{{ $item->bobot_nilai }}%</td>
                                                <td>
                                                    <button data-target="#modalPopup" data-toggle="modal"
                                                        onclick="modal({{ $item->id }}, 'penilaian')"
                                                        class="btn m-1 btn-sm btn-block btn-warning"><i
                                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                    <form style="all: unset"
                                                        action="{{ route('master.penilaian.delete', ['id' => $item->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn m-1 btn-sm btn-block btn-danger"
                                                            onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                                                                class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Tidak ada data{{ $q !== '' ? ' untuk pencarian "' . $q . '"' : '' }}.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-2">{{ $pg->links() }}</div>
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
