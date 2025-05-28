@php
    $display = '';
    $display_nilai = '';
@endphp

<div class="tab-pane fade {{ $active == 1 ? 'show active' : '' }}" id="tab-{{ $kelompok == null ? 0 : $kelompok->id }}"
    role="tabpanel" aria-labelledby="{{ $kelompok == null ? 0 : $kelompok->id }}-tab">

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                <div class="mt-2 mb-2">
                    <button type="button" id="btnPass" class="btn btn-primary d-none" onclick="batch_selanjutnya('{{ csrf_token() }}')">Lolos ke Tahap Selanjutnya</button>
                </div>
            </div>
            <div style="width: 100%">
                <table class="table align-items-center table-flush text-center"
                    id="myTable{{ $kelompok == null ? 0 : $kelompok->id }}">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Instansi</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Kelompok</th>
                            <th>Status</th>
                            @if (Auth::user()->role == 2)
                                <th>Penilaian</th>
                            @endif
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $status_label = 2;
                            $data = [];
                            if ($kelompok != null) {
                                if (Auth::user()->role == 4) {
                                    $data = $kelompok
                                        ->hasManyKovablik()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('label', $status_label)
                                        ->get();
                                } elseif (Auth::user()->role == 3) {
                                    $data = $kelompok
                                        ->hasManyKovablik()
                                        ->where('label', $status_label)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();
                                } elseif (Auth::user()->role == 5) {
                                    $data = $kelompok
                                        ->hasManyKovablik()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('label', $status_label)
                                        ->get();
                                } else {
                                    $data = $kelompok
                                        ->hasManyKovablik()
                                        ->where('label', $status_label)
                                        ->where('tahun', Auth::user()->tahun)
                                        ->where('status', '<>', 0)
                                        ->get();
                                }
                            } else {
                                if (Auth::user()->role == 2) {
                                    $kelompok = App\Models\VerifikatorKovablik::where('user_id', Auth::user()->id)->pluck('kelompok_id');
                                    $data = $proposal->whereIn('kelompok_id', $kelompok);
                                } else {
                                    $data = $proposal;
                                }
                            }
                        @endphp
                        @foreach ($data as $item)
                            @php
                                $disabled = '';
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" style="transform: scale(2)" name="is_pass[]" 
                                           class="is_pass" value="{{ $item->id }}" data-tahap="{{ $item->juri_tahap }}"
                                           @if (!($item->status == 2 && (Auth::user()->role != 4 && Auth::user()->role != 5) 
                                                  && $item->juri_tahap < 2))
                                              disabled
                                           @endif
                                           >
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->instansi }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kategori->nama}}</td>
                                <td>{{ $item->kelompok->nama}}</td>
                                <td>{!! Helper::getStatusKovablik($item->status) !!}</td>
                                @if (Auth::user()->role == 2)
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
                                @endif
                                <td>
                                    @if ($item->status != 0)
                                        <a target="_blank"
                                            href="{{ route('kovablik.export', ['type' => 'pdf', 'id' => $item->id]) }}"
                                            class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip"
                                            data-placement="top" title="Download Pdf"><i
                                                class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                        <a target="_blank"
                                            href="{{ route('kovablik.export', ['type' => 'excel', 'id' => $item->id]) }}"
                                            class="btn m-1 btn-block btn-sm btn-success" data-toggle="tooltip"
                                            data-placement="top" title="Download Excel"><i
                                                class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                    @endif
                                    <a href="{{ route('kovablik.detail', ['id' => encrypt($item->id)]) }}"
                                        class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip"
                                        data-placement="top" title="Detail Proposal"><i
                                            class="fa fa-eye"></i>&nbsp;&nbsp;Detail</a>
                                    @if ($item->status == 2 && (Auth::user()->role != 4 && Auth::user()->role != 5) && $item->juri_tahap < 2)
                                        <button type="button"
                                            onclick="btn_selanjutnya('{{ csrf_token() }}','{{ $item->id }}',{{ $item->juri_tahap }})"
                                            class="btn m-1 btn-block btn-sm" style="background-color:green;color:white"
                                            data-toggle="tooltip" data-placement="top" title="Penilaian Inovasi"><i
                                            class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Selanjutnya </button>
                                    @endif
                                    @if (($item->status == 0 || $item->status == 4) && $item->status != 2 && $item->status != 1)
                                        <a href="{{ route('kovablik.edit', ['id' => encrypt($item->id), 'label' => 2]) }}"
                                            class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                            data-placement="top" title="Edit Proposal"><i
                                                class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>

                                        <form style="all: unset" action="{{ route('kovablik.update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="label" value="{{ $status_label }}">
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="status" value="1">
                                            @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                                                <button type="submit"
                                                    class="btn m-1 btn-block btn-sm btn btn-success" name="is_sent"
                                                    value="1"
                                                    onclick="if(!confirm('Apakah Anda yakin akan mengirim data Proposal ini? (Pastikan Data Sudah Diisi dengan Benar)')){return false;}"><i
                                                        class="fa fa-paper-plane"></i>&nbsp;&nbsp;Kirim Proposal</button>
                                            @endif
                                        </form>
                                    @endif
                                    @if ($item->status == 0 || $item->status == 4)
                                        <form id="deleteConfirm" style="all: unset"
                                            action="{{ route('kovablik.delete', ['id' => $item->id]) }}" method="post">
                                            @csrf
                                            <button onclick="hapus_data('{{ csrf_token() }}','{{ $item->id }}')"
                                                type="button" class="btn m-1 btn-block btn-sm btn-danger delete-btn"
                                                data-toggle="modal" data-target="#confirmDeleteModal"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Proposal">
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
    //Button tahap selanjutnya individu
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: true,
                                timer: 1500
                            }).then(() => {
                                show_status('{{ csrf_token() }}', $('#statusFilter').val(),
                                    '#show_kovablik');
                            });
                        });
                }
            });
        }

    }
    $(document).ready(function() {
        $('.table-flush').DataTable();
    });
</script>
