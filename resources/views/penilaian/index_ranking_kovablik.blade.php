@extends('layouts.main')

@section('title')
    Penilaian Proposal Kovablik
@endsection

@section('title-desc')
    Daftar Pengajuan Proposal Kovablik yang Sudah Disetujui
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        @foreach ($data_kelompok as $key => $item)
                            <x-tab-kovablik :kelompok="$item" :key="$key + 1" :active="$loop->iteration == 1 ? 1 : 0" />
                        @endforeach
                    </ul>
                    <div style="width: 100%">
                        <div class="tab-content">
                            @foreach ($data_kelompok as $datas)
                                @php
                                    $get_penilaian_kovablik = $datas->get_penilaian_kovablik(
                                        $datas->id,
                                        $juri_tahap,
                                    );
                                @endphp
                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab-{{ $datas->id }}"
                                    role="tabpanel">
                                    <h4>Proposal Kovablik</h4>
                                    <div class="row">
                                        <div class="col-md-11">
                                        </div>
                                        <div class="col-md-1">
                                            <a target="_blank"
                                                href="{{ route('penilaian-kovablik.export', ['kelompok_id' => $datas->id]) }}"
                                                class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                                title="Download Excel"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                        </div>
                                    </div>
                                    @if (Auth::user()->role == 2)
                                        <div class="d-flex justify-content-end">
                                            <div class="mt-2 mb-2">
                                                <button type="button" id="btnPass" class="btn btn-primary d-none" onclick="batch_selanjutnya('{{ csrf_token() }}')">Lolos ke Tahap Selanjutnya</button>
                                            </div>
                                        </div>
                                    @endif

                                    <table class="table align-items-center table-flush" id="myTable">
                                        <thead class="thead-light">
                                            <tr>
                                                @if ($juri_tahap == '1' && Auth::user()->role == 2)
                                                    <th></th>    
                                                @endif
                                                <th>No.</th>
                                                <th style="min-width: 100px">Dibuat Oleh</th>
                                                <th style="min-width: 200px">Nama</th>
                                                <th>Kategori</th>
                                                <th style="width: 100px; min-width: 100px">Status</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                                <th style="width: 100px; min-width: 100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $data = [];
                                            @endphp
                                            @foreach ($get_penilaian_kovablik as $item)
                                                @php
                                                    $row_class = '';
                                                    $background_color = ''; // default, jika belum diisi

                                                    if ($item->status != 2) {
                                                        $display_nilai = 'display: none';
                                                    }
                                                @endphp
                                                @foreach ($item->penilaian as $penilaian)
                                                    @if (Auth::id() == $penilaian->pivot->user_id && $penilaian->pivot->nilai > 0)
                                                        @php
                                                            $row_class = 'table-success';
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                <tr class="{{ $row_class }}">
                                                    @if ($item->juri_tahap == 1 && Auth::user()->role == 2)
                                                        <td>
                                                            <input type="checkbox" style="transform: scale(2)" name="is_pass[]" 
                                                                class="is_pass" value="{{ $item->id }}" data-tahap="{{ $item->juri_tahap }}">
                                                        </td>
                                                    @endif
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->kategori->nama ?? ' ' }}</td>
                                                    <td>{!! Helper::getStatusInovasi($item->status) !!}</td>
                                                    <td>
                                                        @if ($item->keterangan != null)
                                                            {{ $item->keterangan }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @for ($i = 1; $i <= $item->juri_tahap; $i++)
                                                            @php
                                                                if ($i == 1) {
                                                                    $tahap =
                                                                        "<span class='badge badge-primary rounded-pill'>Tahap 1</span>";
                                                                } elseif ($i == 2) {
                                                                    $tahap =
                                                                        "<span class='badge badge-success rounded-pill'>Tahap 2</span>";
                                                                }
                                                                $nilai = $item->penilaian
                                                                    ->where('pivot.juri_tahap', $i)
                                                                    ->sum(function ($pen) {
                                                                        return $pen->pivot->nilai;
                                                                    });
                                                                $jumlahJuri = $item->kelompok->juris->count();
                                                                $nilai = $nilai / $jumlahJuri;
                                                            @endphp

                                                            {!! $tahap !!}
                                                            {{ $nilai }}
                                                        @endfor

                                                        @if ($item->juri_tahap == 0)
                                                            <span class='badge badge-secondary'>Belum Dinilai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (Auth::user()->role == 7)
                                                            <a href="{{ route('penilaian-kovablik.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id, 'tahap' => $item->juri_tahap]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Penilaian Proposal"><i
                                                                    class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                        @else
                                                            <a href="{{ route('penilaian-kovablik.show', ['id' => encrypt($item->id)]) }}"
                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Penilaian Proposal"><i
                                                                    class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                            @if ($item->juri_tahap < 2)
                                                                <button type="button"
                                                                    onclick="btn_selanjutnya('{{ csrf_token() }}','{{ $item->id }}',{{ $item->juri_tahap }})"
                                                                    class="btn m-1 btn-block btn-sm" style="background-color:green;color:white"
                                                                    data-toggle="tooltip" data-placement="top" title="Penilaian Inovasi"><i
                                                                    class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Selanjutnya </button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @push('scripts')
                                    <script>
                                        $('.txt_jml_kovablik_{{ $datas->id }}').html('{{ sizeof($get_penilaian_kovablik) }}');
                                    </script>
                                @endpush
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        @include('script.ubahWilayah')
        @include('script.ubahScopeOpd')

        <script>
            //Masukkan proposal yang dicentang untuk ke tahap selanjutnya per batch
            $(document).ready(function() {
                document.querySelectorAll(".is_pass").forEach(function (checkbox) {
                    checkbox.addEventListener("change", function () {
                        let anyChecked = document.querySelectorAll(".is_pass:checked").length > 0;
                        document.getElementById("btnPass").classList.toggle("d-none", !anyChecked);
                    });
                });
            });
            //Button masuk tahap selanjutnya per batch
            function batch_selanjutnya(token) {
                let checkedIds = [];
                var juri_tahap = null;
                const checked = document.querySelectorAll('.is_pass:checked');
                checked.forEach(cb => {
                    checkedIds.push(cb.value);
                });

                if (checked.length > 0) {
                    juri_tahap = parseInt(checked[0].dataset.tahap);
                }
                btn_selanjutnya(token, checkedIds, juri_tahap);
            }
            //Button masuk tahap selanjutnya
            function btn_selanjutnya(token, ids, juri_tahap) {
                var id = Array.isArray(ids) ? ids : [ids];
                var next_juri = juri_tahap + 1;
                if (next_juri > 2) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Penilaian sudah di tahap 2',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#d33', // merah, cocok untuk error
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    Swal.fire({
                        title: `Lanjutkan ke Penilaian Tahap ` + (juri_tahap + 1) + ` ?`,
                        text: "Pastikan data sebelumnya sudah disimpan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjutkan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var routeUrl = "{{ route('penilaian-kovablik.move') }}";

                            $.post(routeUrl, {
                                    _token: token,
                                    id: id
                                },
                                function(data) {
                                    if (data.status == true) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            showConfirmButton: true,
                                            timer: 1500
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal',
                                            text: data.message,
                                            icon: 'error',
                                            showCancelButton: false,
                                            confirmButtonColor: '#d33', // merah, cocok untuk error
                                            confirmButtonText: 'Tutup'
                                        });
                                    }
                                });
                        }
                    });
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable0').DataTable({});
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]')
            });
        </script>
    @endsection
