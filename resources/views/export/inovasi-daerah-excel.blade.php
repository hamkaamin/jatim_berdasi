<table>
    <tr>
        <td>No.</td>
        <td>Judul Inovasi</td>
        <td>Pemda</td>
        <td>Admin OPD</td>
        <td>Bentuk Inovasi</td>
        <td>Jenis</td>
        <td>Inisiator</td>
        <td>Urusan Pemerintah</td>
        <td>Kematangan</td>
        <td>Tahapan</td>
        <td>Tanggal Input</td>
        @foreach ($kolom as $item)
            <td>Tanggal {{ $item->nama }}</td>
        @endforeach
        <td>C-19</td>
        <td>Video</td>
        <td>Youtube</td>
    </tr>
    @foreach ($data as $inovasi)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $inovasi->nama }}</td>
            <td>
                @if ($inovasi->kelurahan_id != null)
                    KELURAHAN {{ $inovasi->kelurahan->name }}
                @elseif ($inovasi->kecamatan_id != null)
                    KECAMATAN {{ $inovasi->kecamatan->name }}
                @elseif ($inovasi->kota_id != null)
                    {{ $inovasi->kota->name }}
                @else
                    {{ $inovasi->provinsi->name }}
                @endif
            </td>
            <td>
                @if ($inovasi->user->opd_id != null)
                    {{ $inovasi->user->opd->nama }}
                @else
                    -
                @endif
            </td>
            <td>{{ $inovasi->bentuk_id != null ? $inovasi->bentuk->nama : '-' }}</td>
            <td>{{ $inovasi->jenis_id != null ? $inovasi->jenis->nama : '-' }}</td>
            <td>{{ $inovasi->inisiator_id != null ? $inovasi->inisiator->nama : '-' }}</td>
            <td>
                @foreach ($inovasi->urusan()->get() as $item)
                    {{ $item->nama }}@if (!$loop->last),&nbsp; @endif
                @endforeach
            </td>
            <td>{{ $inovasi->indikator->sum('pivot.bobot_akhir') }}</td>
            <td>{{ $inovasi->belongsToTahapan->nama }}</td>
            <td>{{ date('d-m-Y', strtotime($inovasi->created_at)) }}</td>
            @foreach ($kolom as $item)
                <td>
                    @php
                        $temp = $item->belongsToManyInovasi()->where('inovasi_id', $inovasi->id)->first();
                    @endphp
                    {{ $temp != null && $temp->pivot->waktu != null ? date('d-m-Y', strtotime($temp->pivot->waktu)) : '-'  }}
                </td>
            @endforeach
            <td>{{ $inovasi->covid == 1 ? 'Ya' : 'Tidak' }}</td>
            <td>
                @foreach ($inovasi->indikator()->where('tipe_file', 'mp4')->get() as $indikator)
                    @foreach ($indikator->upload()->where('inovasi_id', $item->id)->get() as $item)
                        @if ($item->file != null && file_exists(public_path('/indikator_uploads/'.$item->file)))
                            {{ asset('indikator_uploads/'.$item->file) }}@if (!$loop->last) <br> @endif
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td>
                @foreach ($inovasi->indikator()->where('tipe_file', 'mp4')->get() as $indikator)
                    @foreach ($indikator->upload()->where('inovasi_id', $item->id)->get() as $item)
                        {{ $item->url }}@if (!$loop->last) <br> @endif
                    @endforeach
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
