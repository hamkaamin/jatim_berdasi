<div class="step-panel" id="step-panel-2-kov">
    <p class="step-panel-title">Langkah 2 &mdash; Klasifikasi &amp; Dokumen Administrasi</p>
    <p class="step-panel-subtitle">Kategori, kelompok, identitas inovator, dan dokumen pendukung</p>
    <hr class="step-divider">

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
            <select name="kategori_kovablik_id" id="kategori_kovablik_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}"
                        @if (old('kategori_kovablik_id') == $item->id || ($data && $data->kategori_id == $item->id)) selected @endif>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Kelompok Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
            <select name="kelompok_id" id="kelompok_id" class="form-control" required
                onchange="toggleInstansiAsal(this)">
                <option value="">-- Pilih Kelompok --</option>
                @foreach ($kelompok as $item)
                    <option value="{{ $item->id }}"
                        data-replikasi="{{ Str::contains(strtolower($item->nama), 'replikasi') ? '1' : '0' }}"
                        @if (old('kelompok_id') == $item->id || ($data && $data->kelompok_id == $item->id)) selected @endif>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row my-2" id="instansi_asal_row" style="display:none;">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Instansi Asal Inovasi yang
                    Direplikasi</b> <span class="text-danger">*</span></label></div>
        <div class="col-sm-8"><input type="text" name="kov_instansi_asal" class="form-control"
                value="{{ $data != null ? $data->kov_instansi_asal : old('kov_instansi_asal') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
            <select name="kov_jenis_inovasi" class="form-control" required>
                <option value="">-- Pilih Jenis Inovasi --</option>
                <option value="Digital"
                    @if (old('kov_jenis_inovasi') == 'Digital' || ($data && $data->kov_jenis_inovasi == 'Digital')) selected @endif>
                    Digital</option>
                <option value="Non Digital"
                    @if (old('kov_jenis_inovasi') == 'Non Digital' || ($data && $data->kov_jenis_inovasi == 'Non Digital')) selected @endif>
                    Non Digital</option>
            </select>
        </div>
    </div>

    <div class="row mb-4 mt-3">
        <div class="col-12">
            <h5 class="font-weight-bold">Waktu Mulai Implementasi</h5>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <label class="mb-0 w-100"><b>Waktu Mulai Implementasi</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-3">
            <input type="date" name="tanggal_mulai" class="form-control" required
                value="{{ $data != null ? $data->tanggal_mulai : old('tanggal_mulai') }}">
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <label class="mb-0 w-100"><b>Surat Pernyataan Implementasi</b> <span
                    class="text-danger">*</span></label>
        </div>
        <div class="col-md-3">
            <input type="file" class="form-control" name="kov_dokumen_pernyataan_implementasi"
                accept=".jpg,.jpeg,.png,.pdf" {{ !$data ? 'required' : '' }}>
            @if ($data != null && $data->kov_dokumen_pernyataan_implementasi)
                <br><a href="{{ $data->kov_dokumen_pernyataan_implementasi }}" target="_blank">Download Surat
                    Pernyataan Implementasi</a>
            @endif
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h5 class="font-weight-bold">Identitas Inovator</h5>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <label class="mb-0 w-100"><b>Nama</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-3">
            <input type="text" name="nama_inovator" class="form-control" required
                value="{{ $data != null ? $data->nama_inovator : old('nama_inovator') }}">
        </div>
        <div class="col-md-1 d-flex align-items-center">
            <label class="mb-0 w-100"><b>NIP</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <input type="text" name="kov_nip_inovator" class="form-control" required
                value="{{ $data != null ? $data->kov_nip_inovator : old('kov_nip_inovator') }}">
        </div>
        <div class="col-md-3 d-flex align-items-center mt-3">
            <label class="mb-0 w-100"><b>Surat Pernyataan Inovator</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8 mt-3">
            <input type="file" class="form-control" name="kov_dokumen_pernyataan_inovator"
                accept=".jpg,.jpeg,.png,.pdf" {{ !$data ? 'required' : '' }}>
            @if ($data != null && $data->kov_dokumen_pernyataan_inovator)
                <br><a href="{{ $data->kov_dokumen_pernyataan_inovator }}" target="_blank">Download Surat
                    Pernyataan Inovator</a>
            @endif
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 d-flex align-items-center mt-3">
            <label class="mb-0 w-100"><b>Kesediaan Umum</b></label>
        </div>
        <div class="col-md-8 mt-3">
            <input type="file" class="form-control" name="kov_file_kesediaan_replikasi" accept=".pdf">
            @if ($data != null && $data->kov_file_kesediaan_replikasi)
                <br><a href="{{ $data->kov_file_kesediaan_replikasi }}" target="_blank">Download Kesediaan
                    Replikasi</a>
            @endif
        </div>
    </div>

    <div class="stepper-nav">
        <span class="step-badge">Langkah 2 dari 3</span>
        <div>
            <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
                class="btn btn-light btn-lg mr-2">Batal</a>
            <button type="button" class="btn btn-light btn-lg mr-2" onclick="stepperPrev(2)">
                <i class="uil-arrow-left"></i> Sebelumnya
            </button>
            <button type="button" class="btn btn-primary btn-lg" onclick="stepperNext(2)">
                Selanjutnya <i class="uil-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<div class="step-panel" id="step-panel-3-kov">
    <p class="step-panel-title">Langkah 3 &mdash; Data Pendukung &amp; Narasi</p>
    <p class="step-panel-subtitle">Video, sektor, dan isian narasi inovasi</p>
    <hr class="step-divider">

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Nomor Registrasi IGA</b></label></div>
        <div class="col-sm-8"><input type="text" name="kov_nomor_iga" class="form-control"
                value="{{ $data != null ? $data->kov_nomor_iga : old('kov_nomor_iga') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Link Video</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8"><input type="text" name="kov_link_video" class="form-control" required
                value="{{ $data != null ? $data->kov_link_video : old('kov_link_video') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Keterangan Video</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8"><input type="text" name="kov_keterangan_video" class="form-control" required
                value="{{ $data != null ? $data->kov_keterangan_video : old('kov_keterangan_video') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Sektor Pemerintahan</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
            <select name="kov_sektor_pemerintahan_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Salah Satu --</option>
                <option value="1" @if (old('kov_sektor_pemerintahan_id') == 1 || ($data && $data->kov_sektor_pemerintahan_id == 1)) selected @endif>Pendidikan</option>
                <option value="2" @if (old('kov_sektor_pemerintahan_id') == 2 || ($data && $data->kov_sektor_pemerintahan_id == 2)) selected @endif>Kesehatan</option>
                <option value="3" @if (old('kov_sektor_pemerintahan_id') == 3 || ($data && $data->kov_sektor_pemerintahan_id == 3)) selected @endif>Pekerjaan Umum &amp; Tata Ruang</option>
                <option value="4" @if (old('kov_sektor_pemerintahan_id') == 4 || ($data && $data->kov_sektor_pemerintahan_id == 4)) selected @endif>Perumahan Rakyat &amp; Kawasan Permukiman</option>
                <option value="5" @if (old('kov_sektor_pemerintahan_id') == 5 || ($data && $data->kov_sektor_pemerintahan_id == 5)) selected @endif>Ketenagakerjaan</option>
                <option value="6" @if (old('kov_sektor_pemerintahan_id') == 6 || ($data && $data->kov_sektor_pemerintahan_id == 6)) selected @endif>Sosial</option>
                <option value="7" @if (old('kov_sektor_pemerintahan_id') == 7 || ($data && $data->kov_sektor_pemerintahan_id == 7)) selected @endif>Lingkungan Hidup</option>
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Asta Cita</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
            <select name="kov_asta_cita_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Salah Satu --</option>
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Koordinat</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8"><input type="text" name="kov_koordinat" class="form-control" required
                value="{{ $data != null ? $data->kov_koordinat : old('kov_koordinat') }}"
                placeholder="Contoh: -7.250445, 112.768845"></div>
    </div>

    <hr class="step-divider mt-4">
    <h5 class="font-weight-bold mb-3">Narasi Inovasi</h5>

    <div class="row my-2">
        <label><b>Latar Belakang</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_latar_belakang" class="ck-editor" data-label="Latar Belakang"
                id="editor_latar_belakang" rows="4">
@if ($data != null)
{!! $data->kov_latar_belakang !!}
@else
{!! old('kov_latar_belakang') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Tujuan, Outcome dan Output yang Diharapkan</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_tujuan" class="ck-editor" data-label="Tujuan, Outcome dan Output"
                id="editor_tujuan" rows="4">
@if ($data != null)
{!! $data->kov_tujuan !!}
@else
{!! old('kov_tujuan') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 150 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Cara Kerja Inovasi</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_cara_kerja" class="ck-editor" data-label="Cara Kerja Inovasi"
                id="editor_cara_kerja" rows="4">
@if ($data != null)
{!! $data->kov_cara_kerja !!}
@else
{!! old('kov_cara_kerja') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Keunggulan Ide / Gagasan</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_keunggulan" class="ck-editor" data-label="Keunggulan Ide / Gagasan"
                id="editor_keunggulan" rows="4">
@if ($data != null)
{!! $data->kov_keunggulan !!}
@else
{!! old('kov_keunggulan') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Mekanisme Evaluasi Pelaksanaan Inovasi &amp; Tindak Lanjut</b> <span
                class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_mekanisme" class="ck-editor" data-label="Mekanisme Evaluasi"
                id="editor_mekanisme" rows="4">
@if ($data != null)
{!! $data->kov_mekanisme !!}
@else
{!! old('kov_mekanisme') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Bentuk Dampak Inovasi</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_dampak" class="ck-editor" data-label="Bentuk Dampak Inovasi"
                id="editor_dampak" rows="4">
@if ($data != null)
{!! $data->kov_dampak !!}
@else
{!! old('kov_dampak') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Difusi dan Replikasi Inovasi</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_difusi" class="ck-editor" data-label="Difusi dan Replikasi Inovasi"
                id="editor_difusi" rows="4">
@if ($data != null)
{!! $data->kov_difusi !!}
@else
{!! old('kov_difusi') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Sumber Daya</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_sumber_daya" class="ck-editor" data-label="Sumber Daya"
                id="editor_sumber_daya" rows="4">
@if ($data != null)
{!! $data->kov_sumber_daya !!}
@else
{!! old('kov_sumber_daya') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 150 kata</small>
        </div>
    </div>

    <div class="row my-2">
        <label><b>Strategi Keberlanjutan</b> <span class="text-danger">*</span></label>
        <div class="col-12">
            <textarea name="kov_strategi" class="ck-editor" data-label="Strategi Keberlanjutan"
                id="editor_strategi" rows="4">
@if ($data != null)
{!! $data->kov_strategi !!}
@else
{!! old('kov_strategi') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
        </div>
    </div>

    <div class="stepper-nav">
        <span class="step-badge">Langkah 3 dari 3</span>
        <div>
            <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
                class="btn btn-light btn-lg mr-2">Batal</a>
            <button type="button" class="btn btn-light btn-lg mr-2" onclick="stepperPrev(3)">
                <i class="uil-arrow-left"></i> Sebelumnya
            </button>
            @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                <button class="btn btn-success btn-lg" type="submit" name="status" value="0">Simpan</button>
            @else
                <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                    class="btn btn-danger">Simpan</a>
            @endif
        </div>
    </div>
</div>

@include('script.ck-editor-count')
<script>
    function toggleInstansiAsal(sel) {
        var isReplikasi = $(sel).find('option:selected').data('replikasi') == '1';
        $('#instansi_asal_row').css('display', isReplikasi ? 'flex' : 'none');
    }

    (function () {
        var kelompok = document.getElementById('kelompok_id');
        if (kelompok) toggleInstansiAsal(kelompok);
    })();
</script>
