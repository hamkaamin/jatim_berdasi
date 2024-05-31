<div class="tab-pane fade {{ $active == 1 ? 'show active' : '' }}" id="tab-{{ $tahapan == null ? 0 : $tahapan->id }}"
    role="tabpanel" aria-labelledby="{{ $tahapan == null ? 0 : $tahapan->id }}-tab">
    <div class="row">
        <div class="col-md-12">
            <div style="width: 100%">
                <table class="table align-items-center table-flush" id="myTable{{ $tahapan == null ? 0 : $tahapan->id }}">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>No.</th>
                            <th style="min-width: 100px">Dibuat Oleh</th>
                            <th style="min-width: 200px">Nama</th>
                            <th>Tahapan</th>
                            <th>Kategori</th>
                            <th style="width: 100px; min-width: 100px">Status</th>
                            <th>Keterangan</th>
                            @foreach ($kolom as $thp)
                                <th style="min-width: 100px">Waktu {{ $thp->nama }} Inovasi</th>
                            @endforeach
                            <th>Kematangan</th>
                            <th style="width: 100px; min-width: 100px">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $status_label = 0;
                            if ($label == 'Awards') {
                                $status_label = 1;
                            }
                            $data = [];
                            if ($tahapan != null) {
                                if (Auth::user()->role == 4) {
                                    $data = $tahapan
                                        ->hasManyInovasi()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('label', $status_label)
                                        ->get();
                                } elseif (Auth::user()->role == 3) {
                                    $data = $tahapan
                                        ->hasManyInovasi()
                                        ->where('label', $status_label)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();
                                } elseif (Auth::user()->role == 5) {
                                    $data = $tahapan
                                        ->hasManyInovasi()
                                        ->where('user_id', Auth::user()->id)
                                        ->where('label', $status_label)
                                        ->get();
                                } else {
                                    $data = $tahapan
                                        ->hasManyInovasi()
                                        ->where('label', $status_label)
                                        ->where('status', '<>', 0)
                                        ->get();
                                }
                            } else {
                                $data = $inovasi;
                            }

                        @endphp
                        @foreach ($data as $item)
                            @php $disabled = ''; @endphp
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
                                @foreach ($kolom as $thp)
                                    @php
                                        $temp = $thp
                                            ->belongsToManyInovasi()
                                            ->where('inovasi_id', $item->id)
                                            ->first();
                                    @endphp
                                    <td>{{ $temp != null && $temp->pivot->waktu != null ? date('Y-m-d', strtotime($temp->pivot->waktu)) : '-' }}
                                    </td>
                                @endforeach
                                <td>{{ $item->indikator->sum('pivot.bobot_akhir') }}</td>
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
                                    <a href="{{ route('inovasi.indikator.index', ['id' => $item->id], ['area' => 'bank_data']) }}"
                                        class="btn m-1 btn-block btn-sm btn-secondary" data-toggle="tooltip"
                                        data-placement="top" title="Upload Indikator"><i
                                            class="fa fa-folder-open"></i>&nbsp;&nbsp;Indikator</a>
                                    @if (($item->status == 0 || $item->status == 4 || Auth::user()->role == 2) && $item->status != 2)
                                        <a href="{{ route('inovasi.edit', ['id' => encrypt($item->id)]) }}"
                                            class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip"
                                            data-placement="top" title="Edit Inovasi"><i
                                                class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                    @endif
                                    @if (
                                        ($item->status != 2 && $item->user_id == Auth::user()->id) ||
                                            Auth::user()->username == 'superadmin' ||
                                            Auth::user()->username == 'pemdkotkabatest')
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
