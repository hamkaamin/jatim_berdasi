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
                <input type="text" name="q" value="{{ $q }}" class="form-control me-2"
                    placeholder="Cari bagian / indikator...">
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
                                {{ $nilaiPerTahapan[$item->id]->total() }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($data_tahapan as $data)
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}" role="tabpanel">
                        <h4>Kategori Nilai Kovablik</h4>
                        <div class="table-responsive p-3">
                            @php
                                $pg = $nilaiPerTahapan[$data->id];
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
                                                        onclick="modal({{ $item->id }}, 'kategori_nilai_kovablik')"
                                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                    <form style="all: unset"
                                                        action="{{ route('master.kategori_nilai_kovablik.delete', ['id' => $item->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
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
@endsection

@section('script')
    @include('script.modal')
@endsection
