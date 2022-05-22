@extends('layouts.main')

@section('title')
    Detail Profil Pemda
@endsection

@section('title-desc')
	Halaman Detail Profil Pemerintah Daerah
@endsection

@section('buttons')
    <a href="{{ route('profil-pemda.index') }}" class="btn btn-light">Kembali</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="profil-tab" data-toggle="tab" href="#tab-profil" role="tab" aria-controls="tab-profil" aria-selected='true'>Profil Inovasi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="indikator-tab" data-toggle="tab" href="#tab-indikator" role="tab" aria-controls="tab-indikator">Indikator</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profil" role="tabpanel" aria-labelledby="profil-tab">
                    <div class="row">
                        <div class="col">
                            <div class="my-3">
                                <b>Tingkatan</b><br>
                                <span>Provinsi</span>
                            </div>
                            <div class="my-3">
                                <b>OPD yang menangani</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>Alamat Pemda</b><br>
                                <span>-</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="my-3">
                                <b>Email</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>No. Telpon</b><br>
                                <span>-</span>
                            </div>
                            <div class="my-3">
                                <b>Nama Admin</b><br>
                                <span>-</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-3">
                                <b>Dokumen Penelitian</b><br>
                                <span>-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-indikator" role="tabpanel" aria-labelledby="indikator-tab">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush" id="myTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Indikator SPD</th>
                                            <th>Informasi</th>
                                            <th class="text-center" style="width: 100px; min-width: 100px;">Dokumen Pendukung</th>
                                        </tr>
                                    </thead>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }} @if($item->wajib == 1) <span class="text-danger">*</span> @endif</td>
                                                <td>{!! $item->keterangan !!}</td>
                                                <td class="text-center">
                                                    @if ($item->upload()->where('provinsi_id', Auth::user()->province_id)->count() > 0)
                                                        <br><span class="badge badge-pill badge-success"><i class="fa fa-check-circle"></i> &nbsp; Ada File</span>
                                                    @endif
                                                    <a href="" class="btn m-1 btn-sm btn-warning"><i class="fas fa-upload"></i>&nbsp;&nbsp;Upload</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('script.dataTable')
@endsection
