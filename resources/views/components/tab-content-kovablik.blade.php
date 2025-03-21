@php
    $display = '';
    $display_nilai = '';
    $setting = App\Models\Setting::where('kode', 'bobot_akhir')->first();
@endphp

<div class="tab-pane fade {{ $active == 1 ? 'show active' : '' }}" id="tab-{{ $kelompok == null ? 0 : $kelompok->id }}"
    role="tabpanel" aria-labelledby="{{ $kelompok == null ? 0 : $kelompok->id }}-tab">

    <div class="row">
        <div class="col-md-12">
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
                            <th>Tahapan</th>
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
                                $data = $proposal;
                            }
                        @endphp
                        @foreach ($data as $item)
                            @php
                                $disabled = '';
                            @endphp
                            <tr>
                                <td><input type="checkbox" style="transform: scale(2)" name="is_sent[]" id="is_sent[]" value="{{ $item->id }}"></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->instansi }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kategori->nama}}</td>
                                <td>{{ $item->kelompok->nama}}</td>
                                <td>{!! Helper::getStatusKovablik($item->status) !!}</td>
                                <td>{{ $item->tahapan->nama }}</td>
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
    $(document).ready(function() {
        $('.table-flush').DataTable();
    });
</script>
