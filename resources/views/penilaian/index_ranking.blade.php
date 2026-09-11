@extends('layouts.main')

@section('title')
    Penilaian Inovasi
@endsection

@section('title-desc')
    Daftar Pengajuan Inovasi yang Sudah Disetujui
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">

                    <ul class="nav nav-tabs">
                        @foreach ($data_kategori as $key => $item)
                            <x-tab-inovasi :kategori="$item" :key="$key + 1" :active="$loop->iteration == 1 ? 1 : 0" />
                        @endforeach
                    </ul>
                    <div style="width: 100%">
                        @php $data_kelompok = $data_kelompok ?? collect(); @endphp
                        <div class="tab-content">
                            @foreach ($data_kategori as $datas)
                                @php
                                    $get_penilaian_inovasi = $datas->is_kovablik
                                        ? collect()
                                        : $datas->get_penilaian_inovasi($jenis, $datas->id, $juri_tahap);
                                @endphp
                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab-{{ $datas->id }}"
                                    role="tabpanel">

                                    @if($datas->is_kovablik)
                                        {{-- Kovablik: tab filter kelompok + tabel proposal --}}
                                        <ul class="nav nav-tabs mt-3">
                                            @foreach ($data_kelompok as $kel)
                                                <li class="nav-item">
                                                    <a data-toggle="tab" href="#kov-kel-{{ $kel->id }}"
                                                        class="{{ $loop->first ? 'active' : '' }} nav-link">
                                                        {{ $kel->nama }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content mt-2">
                                            @foreach ($data_kelompok as $kel)
                                                @php
                                                    $get_penilaian_kovablik = $kel->get_penilaian_kovablik($kel->id, $juri_tahap);
                                                @endphp
                                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="kov-kel-{{ $kel->id }}" role="tabpanel">
                                                    @if (Auth::user()->role == 2)
                                                        <div class="row mt-2">
                                                            <div class="col-md-12 text-end">
                                                                <a target="_blank"
                                                                    href="{{ route('penilaian-kovablik.export', ['kelompok_id' => $kel->id, 'juri_tahap' => $juri_tahap]) }}"
                                                                    class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                                                    title="Download Excel"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-2 mb-2">
                                                            <button type="button" id="btnPassKov" class="btn btn-primary d-none"
                                                                onclick="batch_selanjutnya('{{ csrf_token() }}')">Lolos ke Tahap Selanjutnya</button>
                                                        </div>
                                                    @endif
                                                    <table class="table align-items-center table-flush data-table-kov">
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
                                                            @foreach ($get_penilaian_kovablik as $item)
                                                                @php
                                                                    $row_class = '';
                                                                @endphp
                                                                @foreach ($item->penilaian as $penilaian)
                                                                    @if (Auth::id() == $penilaian->pivot->user_id && $penilaian->pivot->nilai > 0)
                                                                        @php $row_class = 'table-success'; break; @endphp
                                                                    @endif
                                                                @endforeach
                                                                <tr class="{{ $row_class }}">
                                                                    @if ($item->juri_tahap == 1 && Auth::user()->role == 2)
                                                                        <td>
                                                                            <input type="checkbox" style="transform: scale(2)" name="is_pass[]"
                                                                                class="is_pass_kov" value="{{ $item->id }}" data-tahap="{{ $item->juri_tahap }}">
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $item->user->name }}</td>
                                                                    <td>{{ $item->judul }}</td>
                                                                    <td>{{ $item->kategori->nama ?? ' ' }}</td>
                                                                    <td>{!! Helper::getStatusInovasi($item->status) !!}</td>
                                                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                                                    <td>
                                                                        @for ($i = 1; $i <= $item->juri_tahap; $i++)
                                                                            @php
                                                                                $tahap_label = $i == 1
                                                                                    ? "<span class='badge badge-primary rounded-pill'>Tahap 1</span>"
                                                                                    : "<span class='badge badge-success rounded-pill'>Tahap 2</span>";
                                                                                $nilai_kov = $item->penilaian
                                                                                    ->whereNull('parent_id')
                                                                                    ->where('pivot.juri_tahap', $i)
                                                                                    ->sum(fn($p) => $p->pivot->nilai);
                                                                                $jumlahJuri = $item->kelompok->juris->count();
                                                                                $nilai_kov = $jumlahJuri > 0 ? $nilai_kov / $jumlahJuri : 0;
                                                                            @endphp
                                                                            {!! $tahap_label !!} {{ $nilai_kov }} <br>
                                                                        @endfor
                                                                        @if ($item->juri_tahap == 0)
                                                                            <span class='badge badge-secondary'>Belum Dinilai</span>
                                                                        @endif
                                                                    </td>
                                                                    <td style="max-width: 100px;">
                                                                        @if (Auth::user()->role == 7)
                                                                            <a href="{{ route('penilaian-kovablik.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id, 'tahap' => $item->juri_tahap]) }}"
                                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Penilaian Proposal">
                                                                                <i class="fa fa-star"></i>&nbsp;&nbsp;Penilaian
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ route('penilaian-kovablik.show', ['id' => encrypt($item->id)]) }}"
                                                                                class="btn m-1 btn-block btn-sm btn-warning"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Penilaian Proposal">
                                                                                <i class="fa fa-star"></i>&nbsp;&nbsp;Penilaian
                                                                            </a>
                                                                            @if ($item->juri_tahap < 2)
                                                                                <button type="button"
                                                                                    onclick="btn_selanjutnya_kov('{{ csrf_token() }}','{{ $item->id }}',{{ $item->juri_tahap }},{{ json_encode($item->judul) }},{{ json_encode($item->user->name) }})"
                                                                                    class="btn m-1 btn-block btn-sm" style="background-color:green;color:white"
                                                                                    data-toggle="tooltip" data-placement="top" title="Tahap Selanjutnya">
                                                                                    <i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Selanjutnya
                                                                                </button>
                                                                            @elseif ($item->juri_tahap == 2 && $item->nilai_juri_tahap_show != 2)
                                                                                <button type="button"
                                                                                    onclick="btn_bagikan_kov('{{ csrf_token() }}','{{ $item->id }}',{{ json_encode($item->judul) }},{{ json_encode($item->user->name) }})"
                                                                                    class="btn m-1 btn-block btn-sm"
                                                                                    style="background-color:green;color:white"
                                                                                    data-toggle="tooltip" data-placement="top"
                                                                                    title="Bagikan Nilai"><i
                                                                                        class="fa fa-share"></i>&nbsp;&nbsp;Bagikan Nilai
                                                                                </button>
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
                                                        $('.txt_jml_kovablik_{{ $kel->id }}').html('{{ sizeof($get_penilaian_kovablik) }}');
                                                    </script>
                                                @endpush
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Inovasi biasa --}}
                                        <div class="row mt-3">
                                            <div class="col-md-12 text-end">
                                                <a target="_blank"
                                                    href="{{ route('penilaian.export', ['kategori_id' => $datas->id, 'jenis' => $jenis]) }}"
                                                    class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                                    title="Download Excel"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                            </div>
                                        </div>
                                        <br><br>

                                        <table class="table align-items-center table-flush" id="myTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No.</th>
                                                    <th style="min-width: 100px">Dibuat Oleh</th>
                                                    {{-- <th style="min-width: 200px">Label</th> --}}
                                                    <th style="min-width: 200px">Nama</th>
                                                    <th>Tahapan</th>
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
                                                @foreach ($get_penilaian_inovasi as $item)
                                                    @php
                                                        $tahap =
                                                            "<span class='badge badge-secondary rounded-pill'>Belum Dinilai</span>";

                                                        $row_class = '';
                                                        $background_color = ''; // default, jika belum diisi

                                                        if ($item->status != 2) {
                                                            $display_nilai = 'display: none';
                                                        }
                                                        if ($item->juri_tahap == 1) {
                                                            $tahap =
                                                                "<span class='badge badge-primary rounded-pill'>Tahap 1</span>";
                                                        } elseif ($item->juri_tahap == 2) {
                                                            $tahap =
                                                                "<span class='badge badge-success rounded-pill'>Tahap 2</span>";
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
                                                    @php
                                                        $nilai = $item->penilaian
                                                            ->whereNull('parent_id')
                                                            ->where('pivot.juri_tahap', $item->juri_tahap)
                                                            ->sum(function ($pen) {
                                                                return $pen->pivot->nilai;
                                                            });

                                                    @endphp

                                                    <tr class="{{ $row_class }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        {{-- <td>{{ $item->label }}</td> --}}
                                                        <td>{{ $item->user->name }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->belongsToTahapan->nama }}</td>
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
                                                            <div class="d-flex flex-column gap-1">
                                                                <div class="d-flex gap-1 align-items-center">
                                                                    <span class='badge badge-primary rounded-pill'>Kematangan</span> {{ $item->indikator->sum('pivot.bobot_akhir') }}
                                                                </div>
                                                                <div class="d-flex align-items-center gap-1">
                                                                    {!! $tahap !!}
                                                                    {{ $nilai }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>

                                                            @if (Auth::user()->role == 7)
                                                                <a href="{{ route('penilaian.edit', ['id' => encrypt($item->id), 'user_id' => Auth::user()->id, 'jenis' => $jenis, 'tahap' => $item->juri_tahap]) }}"
                                                                    class="btn m-1 btn-block btn-sm btn-warning"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Penilaian Inovasi"><i
                                                                        class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>
                                                            @else
                                                                <a href="{{ route('penilaian.show', ['id' => encrypt($item->id), 'jenis' => $jenis]) }}"
                                                                    class="btn m-1 btn-block btn-sm btn-warning"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Penilaian Inovasi"><i
                                                                        class="fa fa-star"></i>&nbsp;&nbsp;Penilaian</a>

                                                                @if ($item->juri_tahap < 2)
                                                                    <button type="button"
                                                                        onclick="btn_selanjutnya('{{ csrf_token() }}','{{ $item->id }}',{{ $item->juri_tahap }},{{ json_encode($item->nama) }},{{ json_encode($item->user->name) }})"
                                                                        class="btn m-1 btn-block btn-sm"
                                                                        style="background-color:green;color:white"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Tahap Selanjutnya"><i
                                                                            class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Selanjutnya
                                                                    </button>
                                                                @elseif ($item->juri_tahap == 2 && $item->nilai_juri_tahap_show != 2)
                                                                    <button type="button"
                                                                        onclick="btn_bagikan('{{ csrf_token() }}','{{ $item->id }}')"
                                                                        class="btn m-1 btn-block btn-sm"
                                                                        style="background-color:green;color:white"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Bagikan Nilai"><i
                                                                            class="fa fa-share"></i>&nbsp;&nbsp;Bagikan Nilai
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @push('scripts')
                                            <script>
                                                $('.txt_jml_inovasi_{{ $datas->id }}').html('{{ sizeof($get_penilaian_inovasi) }}');
                                            </script>
                                        @endpush
                                    @endif

                                </div>
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
            function btn_selanjutnya(token, id, juri_tahap, nama, user_name) {
                var next_juri = juri_tahap + 1;
                if (next_juri > 2) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Penilaian sudah di tahap 2',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    Swal.fire({
                        title: 'Lanjutkan ke Penilaian Tahap ' + next_juri + '?',
                        html: `<div style="text-align:left; padding:4px 8px">
                            <table style="width:100%; font-size:14px; border-collapse:collapse">
                                <tr>
                                    <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top; width:110px">Nama Inovasi</td>
                                    <td style="padding:5px 6px; vertical-align:top">:</td>
                                    <td style="padding:5px 0; color:#333">${nama}</td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top">Dibuat Oleh</td>
                                    <td style="padding:5px 6px; vertical-align:top">:</td>
                                    <td style="padding:5px 0; color:#333">${user_name}</td>
                                </tr>
                            </table>
                            <div style="margin-top:12px; padding:8px 12px; background:#fff3cd; border-left:4px solid #ffc107; border-radius:4px; color:#856404; font-size:13px">
                                ⚠️ Pastikan data sebelumnya sudah disimpan!
                            </div>
                        </div>`,
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonColor: '#28a745',
                        denyButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Lanjut & Bagikan',
                        denyButtonText: 'Bagikan Saja',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        var is_next;
                        if (result.isConfirmed) {
                            is_next = true;
                        } else if (result.isDenied) {
                            is_next = false;
                        } else {
                            return;
                        }
                        $.post("{{ route('penilaian.move') }}", { _token: token, id: id, is_next: is_next }, function(data) {
                            if (data.status == true) {
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500 }).then(() => location.reload());
                            } else {
                                Swal.fire({ title: 'Gagal', html: data.message, icon: 'error', confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
                            }
                        });
                    });
                }
            }

            function btn_bagikan(token, id) {
                Swal.fire({
                    title: 'Bagikan Hasil Penilaian?',
                    text: "Pastikan semua juri sudah menilai!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Bagikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    $.post("{{ route('penilaian.move') }}", { _token: token, id: id, is_next: false }, function(data) {
                        if (data.status == true) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500 }).then(() => location.reload());
                        } else {
                            Swal.fire({ title: 'Gagal', html: data.message, icon: 'error', confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
                        }
                    });
                });
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
            $(document).ready(function() {
                $('.data-table-kov').DataTable();
            });
        </script>
        <script>
            // Checkbox batch kovablik
            $(document).ready(function() {
                document.querySelectorAll(".is_pass_kov").forEach(function(checkbox) {
                    checkbox.addEventListener("change", function() {
                        let anyChecked = document.querySelectorAll(".is_pass_kov:checked").length > 0;
                        let btnPass = document.getElementById("btnPassKov");
                        if (btnPass) btnPass.classList.toggle("d-none", !anyChecked);
                    });
                });
            });
            function btn_selanjutnya_kov(token, ids, juri_tahap, nama, user_name) {
                var id = Array.isArray(ids) ? ids : [ids];
                var next_juri = juri_tahap + 1;
                if (next_juri > 2) {
                    Swal.fire({ title: 'Gagal', text: 'Penilaian sudah di tahap 2', icon: 'error', confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
                } else {
                    Swal.fire({
                        title: 'Lanjutkan ke Penilaian Tahap ' + next_juri + '?',
                        html: `<div style="text-align:left; padding:4px 8px">
                            <table style="width:100%; font-size:14px; border-collapse:collapse">
                                <tr>
                                    <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top; width:110px">Nama Proposal</td>
                                    <td style="padding:5px 6px; vertical-align:top">:</td>
                                    <td style="padding:5px 0; color:#333">${nama}</td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top">Dibuat Oleh</td>
                                    <td style="padding:5px 6px; vertical-align:top">:</td>
                                    <td style="padding:5px 0; color:#333">${user_name}</td>
                                </tr>
                            </table>
                            <div style="margin-top:12px; padding:8px 12px; background:#fff3cd; border-left:4px solid #ffc107; border-radius:4px; color:#856404; font-size:13px">
                                ⚠️ Pastikan data sebelumnya sudah disimpan!
                            </div>
                        </div>`,
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonColor: '#28a745',
                        denyButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Lanjut & Bagikan',
                        denyButtonText: 'Bagikan Saja',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        var is_next;
                        if (result.isConfirmed) {
                            is_next = true;
                        } else if (result.isDenied) {
                            is_next = false;
                        } else {
                            return;
                        }
                        $.post("{{ route('penilaian-kovablik.move') }}", { _token: token, id: id, is_next: is_next }, function(data) {
                            if (data.status == true) {
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500 }).then(() => location.reload());
                            } else {
                                Swal.fire({ title: 'Gagal', html: data.message, icon: 'error', confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
                            }
                        });
                    });
                }
            }

            function btn_bagikan_kov(token, id, nama, user_name) {
                Swal.fire({
                    title: 'Bagikan Hasil Penilaian?',
                    html: `<div style="text-align:left; padding:4px 8px">
                        <table style="width:100%; font-size:14px; border-collapse:collapse">
                            <tr>
                                <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top; width:110px">Nama Proposal</td>
                                <td style="padding:5px 6px; vertical-align:top">:</td>
                                <td style="padding:5px 0; color:#333">${nama}</td>
                            </tr>
                            <tr>
                                <td style="padding:5px 0; color:#6c757d; font-weight:600; white-space:nowrap; vertical-align:top">Dibuat Oleh</td>
                                <td style="padding:5px 6px; vertical-align:top">:</td>
                                <td style="padding:5px 0; color:#333">${user_name}</td>
                            </tr>
                        </table>
                        <div style="margin-top:12px; padding:8px 12px; background:#fff3cd; border-left:4px solid #ffc107; border-radius:4px; color:#856404; font-size:13px">
                            ⚠️ Pastikan semua juri sudah menilai!
                        </div>
                    </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Bagikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    $.post("{{ route('penilaian-kovablik.move') }}", { _token: token, id: id, is_next: false }, function(data) {
                        if (data.status == true) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500 }).then(() => location.reload());
                        } else {
                            Swal.fire({ title: 'Gagal', html: data.message, icon: 'error', confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
                        }
                    });
                });
            }
        </script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]')
            });
        </script>
    @endsection
