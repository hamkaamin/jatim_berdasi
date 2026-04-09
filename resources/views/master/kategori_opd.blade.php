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
        <ul class="nav nav-tabs">
            @foreach ($data_kategori as $item)
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab-{{ $item->id }}"
                        data-url="{{ route('master.kategoriopd.show', ['id' => $item->id]) }}"
                        class="{{ $loop->iteration == 1 ? 'active' : '' }} nav-link">
                        Kategori {{ $item->kode }} <span class="badge badge-primary">
                            {{ sizeof($item->opd) }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div id="show_kategori">
            <div class="tab-content" id="tabdata">
                <!-- Content for each tab will be loaded dynamically here -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Function to load tab content via AJAX
            $('.nav-tabs a.nav-link').click(function(event) {
                event.preventDefault(); // Prevent the default link behavior

                var tabLink = $(this); // Get the clicked tab link
                var tabId = tabLink.attr('href'); // Get the href attribute (tab ID)
                var url = tabLink.attr('data-url'); // Get the data-url attribute

                // Make AJAX request
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        // Update the content of the tab with the response
                        $(tabdata).html(response);
                        // Activate the tab
                        tabLink.tab('show');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText); // Log error response to console
                    }
                });
            });
        });
    </script>
    @include('script.dataTable')
    @include('script.modal')
    @include('script.ubahWilayah')
    @include('script.ubahScopeOpd')
@endsection
