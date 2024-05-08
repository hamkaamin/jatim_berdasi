@extends('layouts.main')

@section('title')
    Daftar OPD
@endsection

@section('title-desc')
    Daftar Seluruh OPD yang ada di dalam Database Sistem
@endsection

@if (Auth::user()->role != 6 && Auth::user()->role != 2)
    @section('buttons')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
            onclick="modal(0, 'kategori_opd')">Tambah Data</button>
    @endsection
@endif

@section('content')
    @if (Auth::user()->role != 1 && Auth::user()->role != 2 && Auth::user()->role != 6)
        <div class="row p-1">
            <div class="col">
                <form action="{{ route('opd.filter-area') }}" method="get">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <b>Filter Berdasarkan Wilayah OPD :</b>
                        </div>
                        <div class="col">
                            <select onchange="ubahScopeOpd(this.value, 'col')" class="form-control" required name="scope">
                                <option selected disabled>-- Pilih Salah Satu --</option>
                                @if (in_array(Auth::user()->role, [1, 2, 3]) || Helper::checkOpd('provinsi', Auth::user()))
                                    <option value="provinsi">Provinsi</option>
                                    <option value="kota">Kabupaten / Kota</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Auth::user()->role == 4 || Helper::checkOpd('kota', Auth::user()))
                                    <option value="kota">Kabupaten / Kota</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Helper::checkOpd('kecamatan', Auth::user()))
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kelurahan">Kelurahan</option>
                                @elseif (Helper::checkOpd('kelurahan', Auth::user()))
                                    <option value="kelurahan">Kelurahan</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2" id="col_scope_container"></div>
                    <div class="row mt-2 mb-4 d-flex justify-content-center">
                        <div class="col-4"><button class="btn btn-primary btn-sm btn-block" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="row">
        <h4>OPD Inovasi</h4>
        <div class="table-responsive p-3">
            <table class="kategoriopd_datatable">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Wilayah</th>
                        <th>Aktif</th>
                        <th style="width: 100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
@section('script')
    <script>
        var table = $('.kategoriopd_datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthMenu: [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            ajax: "{{ route('master.kategori_opd.table', $kategori_id) }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    width: "5px"
                },
                {
                    data: 'nama',
                    name: 'kategori.nama'
                }, // Assuming 'nama' is a column in the 'kategori' relationship
                {
                    data: 'wilayah',
                    name: 'opd.nama'
                }, // Assuming 'wilayah' is a column in the 'opd' relationship
                {
                    data: 'aktif',
                    name: 'is_aktif'
                }, // Assuming 'aktif' corresponds to 'is_aktif' directly in the dataset
                {
                    data: 'action',
                    name: 'action',
                    class: 'text-center',
                    orderable: true,
                    searchable: true
                }
            ]
        });
    </script>
    @include('script.dataTable')
    @include('script.modal')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
@endsection
