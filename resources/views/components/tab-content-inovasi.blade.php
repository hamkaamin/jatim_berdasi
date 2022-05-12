<div class="tab-pane fade {{ $active == 1 ? 'show active' : '' }}" id="tab-{{ $tahapan == null ? 0 : $tahapan->id }}" role="tabpanel" aria-labelledby="{{ $tahapan == null ? 0 : $tahapan->id }}-tab">
    <div class="row">
        <div class="col">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="myTable{{ $tahapan == null ? 0 : $tahapan->id }}">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th style="min-width: 100px">Dibuat Oleh</th>
                            <th style="min-width: 200px">Nama</th>
                            <th>Tahapan</th>
                            <th style="width: 100px; min-width: 100px">Status</th>
                            @foreach ($kolom as $thp)
                                <th style="min-width: 100px">Waktu {{ $thp->nama }} Inovasi</th>
                            @endforeach
                            <th>Kematangan</th>
                            <th style="width: 100px; min-width: 100px"></th>
                        </tr>
                    </thead>
                        @php
                            $data = [];
                            if ($tahapan != null) {
                                $data = $tahapan->hasManyInovasi()->get();
                            } else {
                                $data = $inovasi;
                            }
                            
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->belongsToTahapan->nama }}</td>
                                <td>{!! Helper::getStatusInovasi($item->status) !!} @if($item->keterangan != null) <i class="fa fa-question-circle" data-toggle="tooltip" data-html="true" title="{{ $item->keterangan }}"></i> @endif</td>
                                @foreach ($kolom as $thp)
                                    @php
                                        $temp = $thp->belongsToManyInovasi()->where('inovasi_id', $item->id)->first();
                                    @endphp
                                    <td>{{ $temp != null && $temp->pivot->waktu != null ? date('Y-m-d', strtotime($temp->pivot->waktu)) : '-'  }}</td>
                                @endforeach
                                <td>{{ $item->indikator->sum('pivot.bobot_akhir') }}</td>
                                <td>
                                    @if ($item->status != 0)
                                        <a href="" class="btn m-1 btn-block btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Download Pdf"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;PDF</a>
                                        <a href="" class="btn m-1 btn-block btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Download Excel"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Excel</a>
                                    @endif
                                    <a href="{{ route('inovasi.indikator.index', ['id' => $item->id]) }}" class="btn m-1 btn-block btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Upload Indikator"><i class="fa fa-folder-open"></i>&nbsp;&nbsp;Indikator</a>
                                    @if ($item->status == 0 || Auth::user()->role == 2)
                                        <a href="{{ route('inovasi.edit', ['id' => $item->id]) }}" class="btn m-1 btn-block btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Inovasi"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                                    @endif
                                    <form style="all: unset" action="{{ route('inovasi.delete', ['id' => $item->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn m-1 btn-block btn-sm btn-danger" onclick="if(!confirm('{{ Config::get('delete_confirm') }}')){return false;}" data-toggle="tooltip" data-placement="top" title="Hapus Inovasi"><i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Hapus</button>
                                    </form>
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