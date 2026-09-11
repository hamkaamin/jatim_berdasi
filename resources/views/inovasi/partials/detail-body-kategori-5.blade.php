{{-- Isi hanya-baca detail inovasi kategori 5. Menerima $data (Inovasi). --}}
@include('partials.detail-styles')

@php
    $user = $data != null ? $data->user : Auth::user();
@endphp

<div class="detail-body">
    <div class="detail-row">
        <div class="detail-label">Nama Pemda</div>
        <div class="detail-value">
            @if ($user->province_id != null)
                PROVINSI {{ $user->provinsi->name }}
            @elseif ($user->regency_id != null)
                {{ $user->kota->name }}
            @elseif ($user->opd_id != null)
                @if ($user->opd->provinsi_id != null)
                    PROVINSI {{ $user->opd->provinsi->name }}
                @elseif ($user->opd->kabkota_id != null)
                    {{ $user->opd->kota->name }}
                @elseif ($user->opd->kecamatan_id != null)
                    KECAMATAN {{ $user->opd->kecamatan->name }}
                @elseif ($user->opd->kelurahan_id != null)
                    KELURAHAN {{ $user->opd->kelurahan->name }}
                @endif
            @endif
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Dibuat Oleh</div>
        <div class="detail-value">{{ $user->name . ' - ' . $user->username }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Nama Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->nama : old('nama') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Kategori Inovasi</div>
        <div class="detail-value">{{ $data != null && $data->kategori ? $data->kategori->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Nama Perangkat Daerah</div>
        <div class="detail-value">
            {{ $data != null && $data->perangkat_daerah ? $data->perangkat_daerah : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Inisiator Inovasi</div>
        <div class="detail-value">{{ $data != null && $data->inisiator ? $data->inisiator->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Nama Inisiator</div>
        <div class="detail-value">{{ $data != null ? $data->nama_inisiator : old('nama_inisiator') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Jenis Inovasi</div>
        <div class="detail-value">{{ $data != null && $data->jenis ? $data->jenis->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Waktu Ujicoba Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->waktu_uji_coba : old('waktu_uji_coba') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Waktu Penerapan Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->waktu_penerapan : old('waktu_penerapan') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Waktu Pengembangan Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->waktu_pengembangan ?? '-' : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Rancang bangun dan pokok perubahan yang dilakukan</div>
        <div class="detail-value">{{ $data != null ? $data->rancang_bangun : old('rancang_bangun') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Profil Bisnis (.ppt) (Jika ada)</div>
        <div class="detail-value">
            @if ($data != null && $data->profil_bisnis)
                <a href="{{ $data->profil_bisnis }}" target="_blank">Download File Profil Bisnis</a>
            @else
                Tidak Ada Data
            @endif
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Penghargaan</div>
        <div class="detail-value">
            @if ($data != null && $data->file_penghargaan)
                <a href="{{ $data->file_penghargaan }}" target="_blank">Download File Penghargaan</a>
            @else
                Tidak Ada Data
            @endif
        </div>
    </div>
</div>
