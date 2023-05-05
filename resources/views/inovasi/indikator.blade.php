@extends('layouts.main')

@section('title')
    Indikator Inovasi {{ Helper::get_label_inovasi($inovasi->label) }}
@endsection

@section('title-desc')
    <b>
        Nama Inovasi : </b> {{ $inovasi->nama }} <br>
    <b>Status Inovasi : </b> {!! Helper::getStatusInovasi($inovasi->status) !!} <br>
@endsection

@section('buttons')
    @if (env('APP_CLOSE_APP') == 0)
        <a @if ($inovasi->label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
            class="btn btn-light">Kembali</a>
        @if ($inovasi->status == 0)
            <form style="all: unset" action="{{ route('inovasi.save', ['id' => request()->id]) }}" method="post">
                @csrf
                <input type="hidden" name="label" value="{{ $inovasi->label }}">
                <button type="submit" class="btn btn-primary" name="status" value="1"
                    onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Submit
                    Inovasi</button>
            </form>
        @endif
    @endif
    @if (Auth::user()->role == 2)
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
            onclick="modal({{ request()->id }}, 'inovasi_status')">Update Status Inovasi</button>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Indikator</th>
                            <th>Keterangan</th>
                            <th style="min-width: 100px">Bobot Awal</th>
                            @if (Auth::user()->role == 2)
                                <th style="min-width: 100px">Bobot Akhir</th>
                                <th>Catatan</th>
                            @endif
                            <th>Data Pendukung</th>
                            <th>Jenis File</th>
                            <th style="width: 100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }} @if ($item->wajib == 1)
                                        <span class="text-danger">*</span>
                                    @endif
                                </td>
                                <td>{!! $item->keterangan !!}</td>
                                <td class="text-center">
                                    <h4><b>{{ $item->pivot->bobot_awal }}</b></h4>{{ $item->pivot->param_awal }}
                                </td>
                                @if (Auth::user()->role == 2)
                                    <td class="text-center">
                                        <h4><b>{{ $item->pivot->bobot_akhir }}</b></h4>{{ $item->pivot->param_akhir }}
                                    </td>
                                    <td>
                                        @if ($item->pivot->catatan != null)
                                            {{ $item->pivot->catatan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $item->data_pendukung }}</td>
                                <td class="text-center">
                                    {{ $item->tipe_file }}
                                    @if ($item->upload()->where('inovasi_id', request()->id)->count() > 0)
                                        <br><span class="badge badge-pill badge-success"><i class="fa fa-check-circle"></i>
                                            &nbsp; Ada File</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('inovasi.indikator.upload.index', ['id' => request()->id, 'indikator' => $item->id]) }}"
                                        class="btn m-1 btn-block btn-sm btn-warning"><i
                                            class="fas fa-upload"></i>&nbsp;&nbsp;Upload</a>
                                    @if ($inovasi->status != 2)
                                        @if ($inovasi->status == 0 || Auth::user()->role == 2)
                                            <button class="btn m-1 btn-block btn-sm btn-info" type="button"
                                                data-toggle="modal" data-target="#modalPopup"
                                                onclick="chooseParam({{ request()->id }}, {{ $item->id }})"><i
                                                    class="fa fa-check-circle"></i>&nbsp;&nbsp;Beri Bobot</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paginate: false
            });
        });
    </script>
    @include('script.modal')
    <div class="modal fade" id="modalPopup" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modalContent">

            </div>
        </div>
    </div>

    <script>
        function chooseParam(inovasi_id, indikator_id) {
            $('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
            $.ajax({
                type: 'POST',
                url: '{{ route('inovasi.indikator.chooseParam') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'inovasi_id': inovasi_id,
                    'indikator_id': indikator_id,
                },
                success: function(data) {
                    $('#modalContent').html(data.msg);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
