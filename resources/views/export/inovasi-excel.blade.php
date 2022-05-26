<table>
    <tr>
        <th>Data</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>Nomor Registrasi</td>
        <td>{{ $inovasi->kode }}</td>
    </tr>
    <tr>
        <td>Nama Inovasi</td>
        <td>{{ $inovasi->nama }}</td>
    </tr>
    <tr>
        <td>Dibuat Oleh</td>
        <td>{{ $inovasi->user->name }}</td>
    </tr>
    <tr>
        <td>Tahapan Inovasi</td>
        <td>{{ $inovasi->belongsToTahapan->nama }}</td>
    </tr>
    <tr>
        <td>Inisiator Inovasi</td>
        <td>{{ $inovasi->inisiator_id != null ? $inovasi->inisiator->nama : '-' }}</td>
    </tr>
    <tr>
        <td>Jenis Inovasi</td>
        <td>{{ $inovasi->jenis_id != null ? $inovasi->jenis->nama : '-' }}</td>
    </tr>
    <tr>
        <td>Bentuk Inovasi Daerah</td>
        <td>{{ $inovasi->bentuk_id != null ? $inovasi->bentuk->nama : '-' }}</td>
    </tr>
    <tr>
        <td>Klaster COVID-19</td>
        <td>{{ $inovasi->covid == 1 ? 'Ya' : 'Tidak' }}</td>
    </tr>
    <tr>
        <td>Urusan Inovasi Daerah</td>
        <td>
            @foreach ($inovasi->urusan()->get() as $item)
                {{ $item->nama }}@if (!$loop->last),&nbsp; @endif
            @endforeach
        </td>
    </tr>
    <tr>
        <td>Rancang Bangun dan Pokok Perubahan Yang Dilakukan</td>
        <td>{{ strip_tags($inovasi->rancang_bangun) }}</td>
    </tr>
    <tr>
        <td>Tujuan Inovasi Daerah</td>
        <td>{{ strip_tags($inovasi->tujuan) }}</td>
    </tr>
    <tr>
        <td>Manfaat Yang Diperoleh</td>
        <td>{{ strip_tags($inovasi->manfaat) }}</td>
    </tr>
    <tr>
        <td>Hasil Inovasi</td>
        <td>{{ strip_tags($inovasi->hasil) }}</td>
    </tr>
    @foreach ($kolom as $item)
        <tr>
            <td>Waktu {{ $item->nama }} Inovasi</td>
            <td>
                @php
                    $temp = $item->belongsToManyInovasi()->where('inovasi_id', $inovasi->id)->first();
                @endphp
                {{ $temp != null && $temp->pivot->waktu != null ? date('d-m-Y', strtotime($temp->pivot->waktu)) : '-'  }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td>Anggaran</td>
        <td>
            @if ($inovasi->anggaran != null && file_exists(public_path('/file_anggaran/'.$inovasi->anggaran)))
                {{ asset('file_anggaran/'.$inovasi->anggaran) }}
            @endif
        </td>
    </tr>
    <tr>
        <td>Profil Bisnis</td>
        <td>
            @if ($inovasi->profil_bisnis != null && file_exists(public_path('/file_profil_bisnis/'.$inovasi->profil_bisnis)))
                {{ asset('file_profil_bisnis/'.$inovasi->profil_bisnis) }}
            @endif
        </td>
    </tr>
    <tr>
        <td>Kematangan</td>
        <td>{{ $inovasi->indikator->sum('pivot.bobot_akhir') }}</td>
    </tr>
</table>
