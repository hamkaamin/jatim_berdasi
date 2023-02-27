@extends('layouts.main')

@section('title')
    Profil Pemda
@endsection

@section('title-desc')
    Halaman Profil Pemerintah Daerah
@endsection

@section('content')
    @if (Auth::user()->role == 2)
        <div class="row">
            <div class="col">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Provinsi</th>
                                <th style="width: 100px"></th>
                            </tr>
                        </thead>
                        @foreach ($provinsi as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route('profil-pemda.detail', ['id' => $item->id]) }}"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;
                                        Detail</a>
                                </td>
                            </tr>
                        @endforeach
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role == 3)
        <div class="row">
            <div class="col">
                <h5>PROVINSI {{ Auth::user()->provinsi->name }}</h5>
                <br>
                <form action="{{ route('profil-pemda.upload-pakta') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row my-2">
                        <div class="col-auto d-flex align-items-center"><label class="m-0 p-0">Upload Pakta
                                Integritas</label></div>
                        <div class="col">
                            <input type="file" name="pakta_integritas" class="mr-2" required>
                            <button class="btn btn-sm btn-primary mr-2" type="submit">Upload File (Maks 2MB)</button>
                            @if (Auth::user()->pakta_integritas != null &&
                                    file_exists(public_path('/pakta_integritas/' . Auth::user()->pakta_integritas)))
                                <a target="_blank"
                                    href="{{ asset('pakta_integritas/' . Auth::user()->pakta_integritas) }}">Download Pakta
                                    Integritas</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Tingkatan</th>
                                <th style="width: 100px"></th>
                            </tr>
                        </thead>
                        <tr>
                            <td>1.</td>
                            <td>Provinsi</td>
                            <td>
                                <a href="{{ route('profil-pemda.detail') }}" class="btn m-1 btn-block btn-sm btn-warning"><i
                                        class="fa fa-edit"></i>&nbsp;&nbsp; Detail</a>
                                <a target="_blank" href="{{ asset('pakta_integritas/' . Auth::user()->pakta_integritas) }}"
                                    class="btn m-1 btn-block btn-sm btn-info"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    Pakta</a>
                                <a target="_blank" href="{{ route('profil-pemda.export', ['type' => 'pdf']) }}"
                                    class="btn m-1 btn-block btn-sm btn-danger"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    PDF</a>
                                <a target="_blank" href="{{ route('profil-pemda.export', ['type' => 'excel']) }}"
                                    class="btn m-1 btn-block btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    Excel</a>
                            </td>
                        </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role == 4)
        <div class="row">
            <div class="col">
                <h5>KOTA / KABUPATEN {{ Auth::user()->kota->name }}</h5>
                <br>
                <form action="{{ route('profil-pemda.upload-pakta') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row my-2">
                        <div class="col-auto d-flex align-items-center"><label class="m-0 p-0">Upload Pakta
                                Integritas</label></div>
                        <div class="col">
                            <input type="file" name="pakta_integritas" class="mr-2" required>
                            <button class="btn btn-sm btn-primary mr-2" type="submit">Upload File (Maks 2MB)</button>
                            @if (Auth::user()->pakta_integritas != null &&
                                    file_exists(public_path('/pakta_integritas/' . Auth::user()->pakta_integritas)))
                                <a target="_blank"
                                    href="{{ asset('pakta_integritas/' . Auth::user()->pakta_integritas) }}">Download Pakta
                                    Integritas</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Tingkatan</th>
                                <th style="width: 100px"></th>
                            </tr>
                        </thead>
                        <tr>
                            <td>1.</td>
                            <td>KOTA / KABUPATEN </td>
                            <td>
                                <a href="{{ route('profil-pemda.detail_kota_kab') }}"
                                    class="btn m-1 btn-block btn-sm btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;
                                    Detail</a>
                                <a target="_blank" href="{{ asset('pakta_integritas/' . Auth::user()->pakta_integritas) }}"
                                    class="btn m-1 btn-block btn-sm btn-info"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    Pakta</a>
                                <a target="_blank" href="{{ route('profil-pemda.export', ['type' => 'pdf']) }}"
                                    class="btn m-1 btn-block btn-sm btn-danger"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    PDF</a>
                                <a target="_blank" href="{{ route('profil-pemda.export', ['type' => 'excel']) }}"
                                    class="btn m-1 btn-block btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;&nbsp;
                                    Excel</a>
                            </td>
                        </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    @include('script.dataTable')
@endsection
