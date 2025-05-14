@php
    $display = '';
    $display_nilai = '';
    $setting = App\Models\Setting::where('kode', 'bobot_akhir')->first();
@endphp

<div class="tab-pane fade {{ $active == 1 ? 'show active' : '' }}" id="tab-{{ $kategori == null ? 0 : $kategori->id }}"
    role="tabpanel" aria-labelledby="{{ $kategori == null ? 0 : $kategori->id }}-tab">

    <div class="row">
        <div class="col-md-12">
            <div style="width: 100%">
                <table class="table align-items-center table-flush"
                    id="myTable{{ $kategori == null ? 0 : $kategori->id }}">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>No.</th>
                            <th style="min-width: 100px">Dibuat Oleh</th>
                            <th style="min-width: 200px">Nama</th>
                            {{-- <th>Tahapan</th> --}}
                            <th>Kategori</th>
                            <th style="width: 100px; min-width: 100px">Status</th>
                            <th>Keterangan</th>
                            <th style="{!! $display !!}">Bobot Awal</th>
                            @if (Auth::user()->role == 2)
                                <th>Kematangan</th>
                                <th>Penilaian</th>
                            @endif
                            <th style="width: 100px; min-width: 100px">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $status_label = 0;
                            if ($label == 'Awards' || $label == 'Inotek') {
                                $status_label = 1;
                            }
                            $data = [];
                            if ($kategori != null) {
                                if (Auth::user()->role == 4) {
                                    $data = $kategori
                                        ->hasManyInovasi()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('label', $status_label)
                                        ->get();
                                } elseif (Auth::user()->role == 3) {
                                    $data = $kategori
                                        ->hasManyInovasi()
                                        ->where('label', $status_label)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();
                                } elseif (Auth::user()->role == 5) {
                                    $data = $kategori
                                        ->hasManyInovasi()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('label', $status_label)
                                        ->get();
                                } else {
                                    $data = $kategori
                                        ->hasManyInovasi()
                                        ->where('label', $status_label)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('status', '<>', 0)
                                        ->get()
                                        ->sortByDesc(function ($item) {
                                            $totalNilai = $item->indikator->sum('pivot.bobot_akhir');
                                            return $totalNilai;
                                        });
                                }
                            } else {
                                $data = $inovasi;
                            }
                        @endphp
                        @foreach ($data as $item)
                            @php
                                $tahap = "<span class='badge badge-secondary'>Belum Dinilai</span>";

                                $disabled = '';
                                if ($item->status != 2) {
                                    $display_nilai = 'display: none';
                                }
                                if ($item->juri_tahap == 1) {
                                    $tahap = "<span class='badge badge-primary rounded-pill'>Tahap 1</span>";
                                } elseif ($item->juri_tahap == 2) {
                                    $tahap = "<span class='badge badge-success'>Tahap 2</span>";
                                }
                            @endphp
                            <tr>
                                @if (env('APP_OPD_JATIM') == 1)
                                    @if ($item->status != 2)
                                        @php $disabled = 'disabled'; @endphp
                                    @endif
                                @endif

                                <td><input {!! $disabled !!} type="checkbox" style="transform: scale(2)"
                                        name="is_sent[]" id="is_sent[]" value="{{ $item->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->nama }}</td>
                                {{-- <td>{{ $item->belongsToTahapan->nama }}</td> --}}
                                <td>{{ $item->kategori->nama ?? ' ' }}</td>
                                <td>{!! Helper::getStatusInovasi($item->status) !!}</td>
                                <td>
                                    @if ($item->keterangan != null)
                                        {{ $item->keterangan }}
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- @foreach ($kolom as $thp)
                                    @php
                                        $temp = $thp->belongsToManyInovasi()->where('inovasi_id', $item->id)->first();
                                    @endphp
                                    <td>{{ $temp != null && $temp->pivot->waktu != null ? date('Y-m-d', strtotime($temp->pivot->waktu)) : '-' }}
                                    </td>
                                @endforeach --}}

                                <td style="{!! $display !!}">{{ $item->indikator->sum('pivot.bobot_awal') }}
                                </td>
                                @if (Auth::user()->role == 2)
                                    <td><b>{{ $item->indikator->sum('pivot.bobot_akhir') }}</b>
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

                                            @endphp
                                            {{-- {{ sizeof($item->kategori->juris) > 0 ? $item->penilaian->sum('pivot.nilai') / sizeof($item->kategori->juris) : 0 }} 
                                        --}}

                                            {!! $tahap !!}
                                            {{ $nilai }}
                                        @endfor

                                        @if ($item->juri_tahap == 0)
                                            <span class='badge badge-secondary'>Belum Dinilai</span>
                                        @endif
                                    </td>
                                @endif

                                {{-- <td style="{!! $display_nilai !!}">{{ number_format($rataRata, 2) }}
                                </td> --}}
                                <td>
                                    @if ($item->status != 0)
                                        <a target="_blank"
                                            href="{{ route('inovasi.export', ['type' => 'pdf', 'id' => $item->id]) }}"
                                            class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip"
                                            data-placement="top" title="Download Pdf"><i
                                                class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                        <a target="_blank"
                                            href="{{ route('inovasi.export', ['type' => 'excel', 'id' => $item->id]) }}"
                                            class="btn m-1 btn-block btn-sm btn-success" data-toggle="tooltip"
                                            data-placement="top" title="Download Excel"><i
                                                class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                    @endif
                                    @if (Auth::user()->tahun == date('Y'))
                                        <a href="{{ route('inovasi.indikator.index', ['id' => $item->id], ['area' => 'bank_data']) }}"
                                            class="btn m-1 btn-block btn-sm btn-secondary" data-toggle="tooltip"
                                            data-placement="top" title="Upload Indikator"><i
                                                class="fa fa-folder-open"></i>&nbsp;&nbsp;Indikator</a>
                                    @endif
                                    <a href="{{ route('inovasi.detail', ['id' => encrypt($item->id)]) }}"
                                        class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip"
                                        data-placement="top" title="Detail Inovasi"><i
                                            class="fa fa-eye"></i>&nbsp;&nbsp;Detail</a>
                                    @if (($item->status == 0 || $item->status == 4 || Auth::user()->role == 2) && $item->status != 2 && $item->status != 1)
                                        <a href="{{ route('inovasi.edit', ['id' => encrypt($item->id)]) }}"
                                            class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                            data-placement="top" title="Edit Inovasi"><i
                                                class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                        {{-- @if ($item->kategori_id == 5)
                                            <form style="all: unset" action="{{ route('inovasi.update') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="label" value="{{ $status_label }}">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="status" value="1">
                                                @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                                                    <button type="submit"
                                                        class="btn m-1 btn-block btn-sm btn btn-success" name="is_sent"
                                                        value="1"
                                                        onclick="if(!confirm('Apakah Anda yakin akan mengirim data Inovasi ini? (Pastikan Data Sudah Diisi dengan Benar)')){return false;}"><i
                                                            class="fa fa-paper-plane"></i>&nbsp;&nbsp;Kirim
                                                        Inovasi</button>
                                                @endif
                                            </form>
                                        @endif --}}
                                    @endif
                                    @if ($item->status == 2 && (Auth::user()->role != 4 && Auth::user()->role != 5))
                                        {{-- <a href="{{ route('penilaian.show', ['id' => encrypt($item->id)]) }}"
                                            class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                            data-placement="top" title="Penilaian Inovasi"><i
                                                class="fa fa-star"></i>&nbsp;&nbsp;Penilaian </a> --}}
                                        <button type="button"
                                            onclick="btn_selanjutnya('{{ csrf_token() }}','{{ $item->id }}',{{ $item->juri_tahap }})"
                                            class="btn m-1 btn-block btn-sm" style="background-color:green;color:white"
                                            data-toggle="tooltip" data-placement="top" title="Penilaian Inovasi"><i
                                                class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Selanjutnya </button>
                                    @endif
                                    @if ($item->status == 0 || $item->status == 4)
                                        <form id="deleteConfirm" style="all: unset"
                                            action="{{ route('inovasi.delete', ['id' => $item->id]) }}" method="post">
                                            @csrf
                                            {{-- <button type="button"
                                                class="btn m-1 btn-block btn-sm btn-danger delete-btn"
                                                data-toggle="modal" data-target="#confirmDeleteModal"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Inovasi">
                                                <i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus
                                            </button> --}}
                                            <button onclick="hapus_data('{{ csrf_token() }}','{{ $item->id }}')"
                                                type="button" class="btn m-1 btn-block btn-sm btn-danger delete-btn"
                                                data-toggle="modal" data-target="#confirmDeleteModal"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Inovasi">
                                                <i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function btn_selanjutnya(token, id, juri_tahap) {
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
                    var routeUrl = "{{ route('penilaian.move') }}";

                    $.post(routeUrl, {
                            _token: token,
                            id: id
                        },
                        function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: true,
                                timer: 1500
                            }).then(() => {
                                show_status('{{ csrf_token() }}', $('#statusFilter').val(),
                                    '{{ $area }}', '#show_inovasi');
                            });
                        });
                }
            });
        }

    }
</script>
<script>
    $(document).ready(function() {
        $('.table-flush').DataTable();
    });
</script>
