<input type="hidden" name="form_type" value="new">
<div class="step-panel" id="step-panel-2-kov">
    <p class="step-panel-title">Langkah 2 &mdash; Klasifikasi &amp; Dokumen Administrasi</p>
    <p class="step-panel-subtitle">Kategori, kelompok, identitas inovator, dan dokumen pendukung</p>
    <hr class="step-divider">

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-sm-9">
            <select name="kategori_kovablik_id" id="kategori_kovablik_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" @if (old('kategori_kovablik_id') == $item->id || ($data && $data->kategori_id == $item->id)) selected @endif>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Kelompok Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
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
        <div class="col-sm-9"><input type="text" name="kov_instansi_asal" class="form-control"
                value="{{ $data != null ? $data->instansi : old('kov_instansi_asal') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Jenis Inovasi</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <select name="kov_jenis_inovasi" class="form-control" required>
                <option value="">-- Pilih Jenis Inovasi --</option>
                <option value="Digital" @if (old('kov_jenis_inovasi') == 'Digital' || ($data && $data->jenis_inovasi == 'Digital')) selected @endif>
                    Digital</option>
                <option value="Non Digital" @if (old('kov_jenis_inovasi') == 'Non Digital' || ($data && $data->jenis_inovasi == 'Non Digital')) selected @endif>
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
            <label class="mb-0 w-100"><b>Surat Pernyataan Implementasi</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-3">
            <input type="file" class="form-control" name="kov_dokumen_pernyataan_implementasi"
                accept=".jpg,.jpeg,.png,.pdf" {{ !$data ? 'required' : '' }}>
            @if ($data != null && $data->dokumen_surat_pernyataan_implementasi)
                <br><a href="{{ $data->dokumen_surat_pernyataan_implementasi }}" target="_blank">Download Surat
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
                value="{{ $data != null ? $data->nip_inovator : old('kov_nip_inovator') }}">
        </div>
        <div class="col-md-3 d-flex align-items-center mt-3">
            <label class="mb-0 w-100"><b>Surat Pernyataan Inovator</b> <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8 mt-3">
            <input type="file" class="form-control" name="kov_dokumen_pernyataan_inovator"
                accept=".jpg,.jpeg,.png,.pdf" {{ !$data ? 'required' : '' }}>
            @if ($data != null && $data->dokumen_pernyataan_inovator)
                <br><a href="{{ $data->dokumen_pernyataan_inovator }}" target="_blank">Download Surat
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
            @if ($data != null && $data->file_kesediaan_replikasi)
                <br><a href="{{ $data->file_kesediaan_replikasi }}" target="_blank">Download Kesediaan
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
        <div class="col-sm-9"><input type="text" name="kov_nomor_iga" class="form-control"
                value="{{ $data != null ? $data->nomor_iga : old('kov_nomor_iga') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Link Video</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="text" name="kov_link_video" class="form-control" required
                value="{{ $data != null ? $data->link_video : old('kov_link_video') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Keterangan Video</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="text" name="kov_keterangan_video" class="form-control" required
                value="{{ $data != null ? $data->keterangan_video : old('kov_keterangan_video') }}"></div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Sektor Pemerintahan</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <select name="kov_sektor_pemerintahan_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Salah Satu --</option>
                <option value="1" @if (old('kov_sektor_pemerintahan_id') == 1 || ($data && $data->sektor_pemerintahan_id == 1)) selected @endif>Pendidikan</option>
                <option value="2" @if (old('kov_sektor_pemerintahan_id') == 2 || ($data && $data->sektor_pemerintahan_id == 2)) selected @endif>Kesehatan</option>
                <option value="3" @if (old('kov_sektor_pemerintahan_id') == 3 || ($data && $data->sektor_pemerintahan_id == 3)) selected @endif>Pekerjaan Umum &amp; Tata
                    Ruang</option>
                <option value="4" @if (old('kov_sektor_pemerintahan_id') == 4 || ($data && $data->sektor_pemerintahan_id == 4)) selected @endif>Perumahan Rakyat &amp;
                    Kawasan Permukiman</option>
                <option value="5" @if (old('kov_sektor_pemerintahan_id') == 5 || ($data && $data->sektor_pemerintahan_id == 5)) selected @endif>Ketenagakerjaan</option>
                <option value="6" @if (old('kov_sektor_pemerintahan_id') == 6 || ($data && $data->sektor_pemerintahan_id == 6)) selected @endif>Sosial</option>
                <option value="7" @if (old('kov_sektor_pemerintahan_id') == 7 || ($data && $data->sektor_pemerintahan_id == 7)) selected @endif>Lingkungan Hidup</option>
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Asta Cita</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9">
            <select name="kov_asta_cita_id" id="kov_asta_cita_id" class="form-control">
                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                @foreach ($astaCita as $item)
                    <option value="{{ $item->id }}" @if (($data != null && $data->asta_cita_id == $item->id) || old('kov_asta_cita_id') == $item->id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-sm-3 d-flex align-items-center"><label><b>Koordinat</b> <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-9"><input type="text" name="kov_koordinat" class="form-control" required
                value="{{ $data != null ? $data->koordinat : old('kov_koordinat') }}"
                placeholder="Contoh: -7.250445, 112.768845"></div>
    </div>

    <hr class="step-divider mt-4">
    <h5 class="font-weight-bold mb-3">Narasi Inovasi</h5>

    <div class="row my-2">
        <label>
            <b>Latar Belakang</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li id="latar_belakang_umum">Jelaskan masalah/kondisi yang melatar belakangi lahirnya inovasi disertai
                    data pendukung</li>
                <li>maksimal 200 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_latar_belakang" class="ck-editor" data-label="Latar Belakang" id="editor_latar_belakang"
                rows="4">
@if ($data != null)
{!! $data->latar_belakang !!}
@else
{!! old('kov_latar_belakang') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" name="file_latar_belakang"
                    accept=".jpg,.jpeg,.png,.pdf" value="{{ $data != null ? $data->file_latar_belakang : old('file_latar_belakang') }}">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Tujuan, Outcome dan Output yang Diharapkan</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan tujuan, outcome dan output
                    yang diharapkan tercapai melalui
                    inovasi. Penjelasan disertai dengan
                    target terukur .
                </li>
                <li>maksimal 150 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_tujuan" class="ck-editor" data-label="Tujuan, Outcome dan Output" id="editor_tujuan"
                rows="4">
@if ($data != null)
{!! $data->tujuan_outcome !!}
@else
{!! old('kov_tujuan') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 150 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" value="{{ $data != null ? $data->file_tujuan_outcome : old('file_tujuan_outcome') }}" name="file_tujuan_outcome" accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Cara Kerja Inovasi</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan cara kerja inovasi dan tahapan
                    implementasi inovasi sehingga bisa
                    mencapai tujuan yang diharapkan.
                </li>
                <li>maksimal 200 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_cara_kerja" class="ck-editor" data-label="Cara Kerja Inovasi" id="editor_cara_kerja"
                rows="4">
@if ($data != null)
{!! $data->cara_kerja !!}
@else
{!! old('kov_cara_kerja') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" value="{{ $data != null ? $data->file_cara_kerja : old('file_cara_kerja') }}" name="file_cara_kerja" accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Keunggulan Ide / Gagasan</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan kebaruan dari gagasan yang
                    diimplementasikan
                </li>
                <li>maksimal 200 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_keunggulan" class="ck-editor" data-label="Keunggulan Ide / Gagasan" id="editor_keunggulan"
                rows="4">
@if ($data != null)
{!! $data->kebaharuan !!}
@else
{!! old('kov_keunggulan') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
            <diV>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" value="{{ $data != null ? $data->file_kebaharuan : old('file_kebaharuan') }}" name="file_kebaharuan" accept=".jpg,.jpeg,.png,.pdf">
            </diV>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Mekanisme Evaluasi Pelaksanaan Inovasi &amp; Tindak Lanjut</b><span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan instrumen monitoring dan
                    evaluasi yang digunakan untuk
                    mengukur dampak mencakup
                    komponen cara, periode, dan siapa yang melakukan;
                </li>
                <li>Jelaskan indikator dan relevansinya
                    untuk mengukur dampak inovasi</li>
                <li>maksimal 200 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_mekanisme" class="ck-editor" data-label="Mekanisme Evaluasi" id="editor_mekanisme"
                rows="4">
@if ($data != null)
{!! $data->mekanisme_monitoring !!}
@else
{!! old('kov_mekanisme') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 200 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" name="file_mekanisme_monitoring" value="{{ $data != null ? $data->file_mekanisme_monitoring : old('file_mekanisme_monitoring') }}"
                    accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Bentuk Dampak Inovasi</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Sebutkan bentuk dampak inovasi
                </li>
                <li>Jelaskan capaian output dan outcome inovasi sesuai yang disebutkan dalam tujuan (point
                    2) serta dilengkapi dengan kondisi / tabel sebelum dan sesudah
                </li>
                <li>
                    Jelaskan Dampak Dalam Mencapai Target Asta Cita /program prioritas Presiden
                    sesuai yang dipilih
                </li>
                <li>maksimal 300 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_dampak" class="ck-editor" data-label="Bentuk Dampak Inovasi" id="editor_dampak" rows="4">
@if ($data != null)
{!! $data->bentuk_dampak !!}
@else
{!! old('kov_dampak') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" value="{{ $data != null ? $data->file_bentuk_dampak : old('file_bentuk_dampak') }}" name="file_bentuk_dampak"
                    accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Difusi dan Replikasi Inovasi</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan potensi replikasi
                    mencakup komponem
                    gagasan/informasi, teknis dan
                    manajerial inovasi dan kesesuaian
                    gagasan dalam konteks gagasan
                    dalam kontek wilayah/Instansi
                </li>
                <li>
                    Jelaskan upaya difusi inovasi
                    yang telah dilakukan agar
                    terjadi transfer pengetahuan
                    dan penyebearluasan dampak baik di lingkup internal ataupun eksternal instansi, mencakup
                    :
                    1. Publikasi
                    2. Transfer pengetahuan dan
                    pembelajaran; dan
                    3. Replikasi inovasi pada unit
                    kerja/instansi lain
                </li>
                <li>
                    Sebutkan jumlah unit kerja
                    dan/ atau instansi yang
                    telah mereplikasi inovasi
                </li>
                <li>maksimal 150 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_difusi" class="ck-editor" data-label="Difusi dan Replikasi Inovasi" id="editor_difusi"
                rows="4">
@if ($data != null)
{!! $data->potensi_replikasi !!}
@else
{!! old('kov_difusi') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" value="{{ $data != null ? $data->file_potensi_replikasi : old('file_potensi_replikasi') }}" name="file_potensi_replikasi" accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Sumber Daya</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>
                    Sarana dan Prasarana
                </li>
                <li>
                    Sumber daya informasi
                    (data yang diperlukan
                    untuk menjalankan
                    inovasi);
                </li>
                <li>
                    Sumber daya manusia
                    (jumlah dan
                    kompetensi)
                </li>
                <li>
                    Sumber daya anggaran
                    (nominal dan sumber
                    anggaran)
                </li>
                <li>maksimal 150 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_sumber_daya" class="ck-editor" data-label="Sumber Daya" id="editor_sumber_daya" rows="4">
@if ($data != null)
{!! $data->sumber_daya !!}
@else
{!! old('kov_sumber_daya') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 150 kata</small>
            <div class="row">
                <label>Link File</label>
                <input type="text" value="{{ $data != null ? $data->file_sumber_daya : old('file_sumber_daya') }}"
                    placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" name="file_sumber_daya" accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="row my-2">
        <label>
            <b>Strategi Keberlanjutan</b> <span class="text-danger">*</span>
            <ul class="mb-1">
                <li>Jelaskan Upaya yang dilakukan untuk menjaga keberlanjutan strategi suatu Inovasi
                </li>
                <li>
                    Strategi insQtusional,
                    beruparegulasi/kebijakan
                    yang mendasari
                    implementasi inovasi dan/
                    atau dukungan implementasi inovasi dalam
                    dokumen perencanaan
                    organisasi (unit kerja
                    ataupun instansi);
                </li>
                <li>
                    Strategi manajerial, paling
                    sedikit berupa peningkatan
                    kapasitas SDM pelaksana
                    inovasi, transfer knowledge
                    inovasi, SOP inovasi,
                    maintenance terhadap
                    sumber daya fisik, dan
                    keberlanjutan dukungan
                    anggaran;
                </li>
                <li>Strategi Sosial berupa kolaborasi
                    bersama pemangku kepenQngan
                    dan perannya.</li>
                <li>maksimal 300 kata</li>
            </ul>
        </label>
        <div class="col-12">
            <textarea name="kov_strategi" class="ck-editor" data-label="Strategi Keberlanjutan" id="editor_strategi"
                rows="4">
@if ($data != null)
{!! $data->strategi_keberlanjutan !!}
@else
{!! old('kov_strategi') !!}
@endif
</textarea>
            <small class="text-muted">Minimal 300 kata</small>
            <div>
                <label>Link File</label>
                <input type="text" placeholder="Contoh : https://drive.google.com/drive/1231823912109ajskdjh1i2"
                    class="form-control mt-2" name="file_upaya" value="{{ $data != null ? $data->file_upaya : old('file_upaya') }}" accept=".jpg,.jpeg,.png,.pdf">
            </div>
        </div>
    </div>

    <div class="stepper-nav">
        <span class="step-badge">Langkah 3 dari 3</span>
        <div>
            <a href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" class="btn btn-light btn-lg mr-2">Batal</a>
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

    (function() {
        var kelompok = document.getElementById('kelompok_id');
        if (kelompok) toggleInstansiAsal(kelompok);
    })();

    (function() {
        var KEY = 'step2_{{ $kategori_id }}';

        function save() {
            var out = {};
            document.querySelectorAll(
                '.step-panel input:not([type="file"]):not([type="hidden"]), .step-panel select, .step-panel textarea'
                ).forEach(function(el) {
                if (!el.name) return;
                if (el.type === 'radio' || el.type === 'checkbox') {
                    if (el.checked) out[el.name] = el.value;
                } else {
                    out[el.name] = el.value;
                }
            });
            if (window.CKEDITOR) {
                Object.keys(CKEDITOR.instances).forEach(function(id) {
                    out['__ck__' + id] = CKEDITOR.instances[id].getData();
                });
            }
            localStorage.setItem(KEY, JSON.stringify(out));
        }

        function restore() {
            var raw = localStorage.getItem(KEY);
            if (!raw) return;
            var data;
            try {
                data = JSON.parse(raw);
            } catch (e) {
                return;
            }

            Object.keys(data).forEach(function(name) {
                if (name.indexOf('__ck__') === 0) return;
                var val = data[name];
                document.querySelectorAll('[name="' + name + '"]').forEach(function(el) {
                    // PERBAIKAN: Hanya timpa jika value elemen masih kosong
                    if (el.type !== 'file' && (!el.value || el.value === "")) {
                        if (el.type === 'radio' || el.type === 'checkbox') {
                            el.checked = (el.value === val);
                        } else {
                            el.value = val;
                        }
                    }
                });
            });

            var ckData = {};
            Object.keys(data).forEach(function(n) {
                if (n.indexOf('__ck__') === 0) ckData[n.slice(6)] = data[n];
            });
            if (Object.keys(ckData).length) {
                var tries = 0,
                    iv = setInterval(function() {
                        tries++;
                        Object.keys(ckData).forEach(function(id) {
                            if (window.CKEDITOR && CKEDITOR.instances[id] && CKEDITOR.instances[id]
                                .status === 'ready') {
                                CKEDITOR.instances[id].setData(ckData[id]);
                                delete ckData[id];
                            }
                        });
                        if (!Object.keys(ckData).length || tries > 30) clearInterval(iv);
                    }, 200);
            }

            var kelompok = document.getElementById('kelompok_id');
            if (kelompok && window.toggleInstansiAsal) toggleInstansiAsal(kelompok);
        }

        document.querySelectorAll('[onclick*="stepperNext"]').forEach(function(btn) {
            btn.addEventListener('click', save);
        });

        restore();
        window.clearStep2Storage = function() {
            localStorage.removeItem(KEY);
        };
    }());
</script>
