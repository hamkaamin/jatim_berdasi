@extends('layouts.main')

@section('title')
    Daftar Pengguna
@endsection

@section('title-desc')
    Daftar Seluruh Pengguna yang ada di dalam Database Sistem
@endsection

@if (Auth::user()->role != 6 && Auth::user()->role != 2)
    @section('buttons')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPopup"
            onclick="modal(0, 'pengguna')">Tambah Data</button>
    @endsection
@endif

@section('content')
    @if (Auth::user()->role != 1 && Auth::user()->role != 2 && Auth::user()->role != 6)
        <div class="row p-1">
            <div class="col">
                <form action="{{ route('pengguna.filter-area') }}" method="get">
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
        <div class="col">
            <ul class="nav nav-tabs">
                @foreach ($roles as $item)
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-{{ $item->id }}"
                            class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                            {{ $item->nama }} <span class="badge badge-primary txt_jml_user_{{ $item->id }}"></span>
                        </a>
                    </li>
                @endforeach 
            </ul>
            <div class="tab-content">
                @foreach ($roles as $data)
                    @php 
                        $users = $data->get_user($request, $data->id);
                    @endphp
                    <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="tab-{{ $data->id }}"
                        role="tabpanel">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                {{ Helper::getRole($item->role) }}
                                                @if ($item->role == 5)
                                                    @if ($item->opd->provinsi_id != null)
                                                        - Provinsi
                                                    @elseif ($item->opd->kabkota_id != null)
                                                        - Kota
                                                    @elseif ($item->opd->kecamatan_id != null)
                                                        - Kecamatan
                                                    @elseif ($item->opd->kelurahan_id != null)
                                                        - Kelurahan
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array(Auth::user()->role, [1, 3, 4]) || (Auth::user()->role == 5 && $item->opd_id == Auth::user()->opd_id))
                                                    <button data-target="#modalPopup" data-toggle="modal"
                                                        onclick="modal({{ $item->id }}, 'pengguna')"
                                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                                            class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                                    <form style="all: unset"
                                                        action="{{ route('pengguna.reset-pass', ['id' => $item->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-success"
                                                            onclick="if(!confirm('Apakah Anda yakin akan me-Reset Passwords pengguna ini ?')){return false;}"><i
                                                                class="fa fa-key"></i>&nbsp;&nbsp;Reset Pass</button>
                                                    </form>
                                                    @if(Auth::user()->id != $item->id)
                                                    <form style="all: unset"
                                                        action="{{ route('pengguna.delete', ['id' => $item->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                                                            onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                                                                class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                                    </form>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @push('scripts')
                    <script>
                        $('.txt_jml_user_{{ $data->id }}').html('{{ sizeof($users) }}');
                    </script>
                    @endpush
                @endforeach
            </div>
            {{-- <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    {{ Helper::getRole($item->role) }}
                                    @if ($item->role == 5)
                                        @if ($item->opd->provinsi_id != null)
                                            - Provinsi
                                        @elseif ($item->opd->kabkota_id != null)
                                            - Kota
                                        @elseif ($item->opd->kecamatan_id != null)
                                            - Kecamatan
                                        @elseif ($item->opd->kelurahan_id != null)
                                            - Kelurahan
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (in_array(Auth::user()->role, [1, 3, 4]) || (Auth::user()->role == 5 && $item->opd_id == Auth::user()->opd_id))
                                        <button data-target="#modalPopup" data-toggle="modal"
                                            onclick="modal({{ $item->id }}, 'pengguna')"
                                            class="btn m-1 btn-block btn-sm btn-warning"><i
                                                class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                        <form style="all: unset"
                                            action="{{ route('pengguna.reset-pass', ['id' => $item->id]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn m-1 btn-block btn-sm btn-success"
                                                onclick="if(!confirm('Apakah Anda yakin akan me-Reset Passwords pengguna ini ?')){return false;}"><i
                                                    class="fa fa-key"></i>&nbsp;&nbsp;Reset Pass</button>
                                        </form>
                                        <form style="all: unset"
                                            action="{{ route('pengguna.delete', ['id' => $item->id]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn m-1 btn-block btn-sm btn-danger"
                                                onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}"><i
                                                    class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
    </div>
@endsection

@section('script') 
    @include('script.modal')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
    <script>
        $(document).ready( function () {
            $('.datatable').DataTable();
        } );
        function ubahRole(type) {
            $('#role_container').html("<div class=\"text-center my-1\"><h4><b>Loading...</b></h4></div>");
            $.ajax({
                type: 'POST',
                url: '{{ route('pengguna.change-role') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'type': type,
                },
                success: function(data) {
                    $('#role_container').html(data.msg);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
