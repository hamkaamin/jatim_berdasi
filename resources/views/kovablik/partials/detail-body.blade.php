{{-- Isi hanya-baca detail proposal Kovablik. Menerima $data (ProposalKovablik). Dipakai oleh
     resources/views/kovablik/detail-kovablik.blade.php dan panel kiri form penilaian juri Kovablik. --}}
@include('partials.detail-styles')

<div class="detail-body">
    <div class="detail-row">
        <div class="detail-label">Dibuat Oleh</div>
        <div class="detail-value">{{ $data->user->name . ' - ' . $data->user->username }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Judul Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->judul : old('judul') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Kategori</div>
        <div class="detail-value">{{ $data != null && $data->kategori ? $data->kategori->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Kelompok Inovasi</div>
        <div class="detail-value">{{ $data != null && $data->kelompok ? $data->kelompok->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Jenis Inovasi</div>
        <div class="detail-value">{{ $data != null && $data->jenis_inovasi ? $data->jenis_inovasi : 'Tidak Ada Data' }}
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Waktu Mulai Implementasi</div>
        <div class="detail-value">{{ $data != null ? $data->tanggal_mulai : old('tanggal_mulai') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Surat Pernyataan Implementasi</div>
        <div class="detail-value">
            @if ($data != null && $data->dokumen_surat_pernyataan_implementasi)
                <a href="{{ url($data->dokumen_surat_pernyataan_implementasi) }}" target="_blank">Download Surat
                    Pernyataan Implementasi</a>
            @else
                Tidak Ada Data
            @endif
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Penanggung Jawab/Inovator</div>
        <div class="detail-value">{{ $data != null ? $data->nama_inovator : old('nama_inovator') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Dokumen Pernyataan Inovator</div>
        <div class="detail-value">
            @if ($data != null && $data->dokumen_pernyataan_implementasi)
                <a href="{{ url($data->dokumen_pernyataan_implementasi) }}" target="_blank">Download Dokumen Pernyataan
                    Inovator</a>
            @else
                Tidak Ada Data
            @endif
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Dokumen Kesediaan Umum</div>
        <div class="detail-value">
            @if ($data != null && $data->file_kesediaan_replikasi)
                <a href="{{ url($data->file_kesediaan_replikasi) }}" target="_blank">Download Dokumen Kesediaan Umum</a>
            @else
                Tidak Ada Data
            @endif
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">No Registrasi IGA</div>
        <div class="detail-value">{{ $data != null ? $data->nip_inovator : old('nip_inovator') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link Video</div>
        <div class="detail-value">{{ $data != null ? $data->link_video : old('link_video') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Keterangan Video</div>
        <div class="detail-value">{{ $data != null ? $data->keterangan_video : old('keterangan_video') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Sektor Pemerintah</div>
        <div class="detail-value">
            {{ $data != null && $data->sektorPemerintah ? $data->sektorPemerintah->nama : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Asta Cita</div>
        <div class="detail-value">{{ $data != null && $data->astaCita ? $data->astaCita->name : 'Tidak Ada Data' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Koordinat</div>
        <div class="detail-value">{{ $data != null ? $data->koordinat : old('koordinat') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Latar Belakang</div>
        <div class="detail-value">{!! $data != null ? $data->latar_belakang : old('latar_belakang') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Latar Belakang</div>
        <div class="detail-value">{{ $data != null ? $data->file_latar_belakang : old('file_latar_belakang') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Tujuan, Outcome dan Output yang Diharapkan</div>
        <div class="detail-value">{!! $data != null ? $data->tujuan_outcome : old('tujuan_outcome') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Tujuan, Outcome dan Output yang Diharapkan</div>
        <div class="detail-value">{{ $data != null ? $data->file_tujuan_outcome : old('file_tujuan_outcome') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Cara Kerja Inovasi</div>
        <div class="detail-value">{!! $data != null ? $data->cara_kerja : old('cara_kerja') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Cara Kerja Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->file_cara_kerja : old('file_cara_kerja') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Cara Keunggulan Ide / Gagasan</div>
        <div class="detail-value">{!! $data != null ? $data->kebaharuan : old('kebaharuan') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Cara Keunggulan Ide / Gagasan</div>
        <div class="detail-value">{{ $data != null ? $data->file_kebaharuan : old('file_kebaharuan') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Mekanisme Evaluasi Pelaksanaan Inovasi &amp; Tindak Lanjut</div>
        <div class="detail-value">{!! $data != null ? $data->mekanisme_monitoring : old('mekanisme_monitoring') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Mekanisme Evaluasi Pelaksanaan Inovasi &amp; Tindak Lanjut</div>
        <div class="detail-value">{{ $data != null ? $data->file_mekanisme_monitoring : old('file_mekanisme_monitoring') }}
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Bentuk Dampak Inovasi</div>
        <div class="detail-value">{!! $data != null ? $data->bentuk_dampak : old('bentuk_dampak') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Bentuk Dampak Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->file_bentuk_dampak : old('file_bentuk_dampak') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Difusi dan Replikasi Inovasi</div>
        <div class="detail-value">{!! $data != null ? $data->potensi_replikasi : old('potensi_replikasi') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Difusi dan Replikasi Inovasi</div>
        <div class="detail-value">{{ $data != null ? $data->file_potensi_replikasi : old('file_potensi_replikasi') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Sumber Daya</div>
        <div class="detail-value">{!! $data != null ? $data->sumber_daya : old('sumber_daya') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Sumber Daya</div>
        <div class="detail-value">{{ $data != null ? $data->file_sumber_daya : old('file_sumber_daya') }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Strategi Keberlanjutan</div>
        <div class="detail-value">{!! $data != null ? $data->strategi_keberlanjutan : old('strategi_keberlanjutan') !!}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Link File Strategi Keberlanjutan</div>
        <div class="detail-value">{{ $data != null ? $data->file_strategi_keberlanjutan : old('file_strategi_keberlanjutan') }}
        </div>
    </div>
</div>
