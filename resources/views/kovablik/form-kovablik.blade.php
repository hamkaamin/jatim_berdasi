@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Proposal Kovablik
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Proposal Kovablik dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                <form action="{{ route('kovablik.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
                    enctype="multipart/form-data" id="form-edit-inovasi">
                    <input type="hidden" name="label" value="{{ $label }}">
                    @csrf
                    @php
                        $user = $data != null ? $data->user : Auth::user();
                    @endphp
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Judul Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="judul" class="form-control"
                                value="{{ $data != null ? $data->judul : old('judul') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Kelompok Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <select name="kelompok_id" id="kelompok_id" class="form-control" required
                                        onchange="div_kategori_inovasi('{{ csrf_token() }}','#div_kategori_inovasi','#form-edit-inovasi',{{ $data ? $data->id : 'null' }})">
                                        <option value="">-- Pilih Kelompok --</option>
                                        @foreach ($kelompok as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('kelompok_id') == $item->id || ($data && $data->kelompok_id == $item->id)) selected @endif>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Link Google Drive Standart Pelayanan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="link_standart" class="form-control"
                                value="{{ $data != null ? $data->link_standart : old('link_standart') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Link Google Drive Maklumat Pelayanan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="link_maklumat" class="form-control"
                                value="{{ $data != null ? $data->link_maklumat : old('link_maklumat') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Link Google Drive SK Pengelolaan Pengaduan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="link_sk_pengaduan" class="form-control"
                                value="{{ $data != null ? $data->link_sk_pengaduan : old('link_sk_pengaduan') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Instansi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="instansi" class="form-control"
                                value="{{ $data != null ? $data->instansi : old('instansi') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Tanggal Inovasi Dimulai</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="date" required name="tanggal_mulai" class="form-control"
                                value="{{ $data != null ? $data->tanggal_mulai : old('tanggal_mulai') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Penanggung Jawab/Inovator</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="nama_inovator" class="form-control"
                                value="{{ $data != null ? $data->nama_inovator : old('nama_inovator') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>No Tlpn.</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="no_telpon_inovator" class="form-control"
                                value="{{ $data != null ? $data->no_telpon_inovator : old('no_telpon_inovator') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Email</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="email" required name="email_inovator" class="form-control"
                                value="{{ $data != null ? $data->email_inovator : old('email_inovator') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <select name="kategori_id" id="kategori_id" class="form-control" required
                                        onchange="div_kategori_inovasi('{{ csrf_token() }}','#div_kategori_inovasi','#form-edit-inovasi',{{ $data ? $data->id : 'null' }})">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('kategori_id') == $item->id || ($data && $data->kategori_id == $item->id)) selected @endif>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <label><b>Ringkasan</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Jelaskan secara ringkas mengenai inovasi yang diusulkan, setidaknya meliputi : implementasi, dampak, dan relevansi inovasi dengan kategori yang dipilih.</li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>maksimal 200 kata</li>
                            </ul>
                        </label>
                        <textarea name="ringkasan" class="ck-editor" required id="editor1" rows="10">
                            @if ($data != null)
                            {!! $data->ringkasan !!}
                            @else
                            {!! old('ringkasan') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount1">0</span>/200</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Latar Belakang dan Tujuan</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Uraikan latar belakang dan tujuan yang memuat:
                                    <ul>
                                        <li>Rumusan masalah yang menggambarkan kondisi awal sebelum implementasi</li>
                                        <li>Kelompok sasaran masyarakat yang terdampak permasalahan</li>
                                        <li>Tujuan inovasi dilengkapi dengan target yang terukur</li>
                                    </ul>
                                </li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 300 kata</li>
                            </ul>
                        </label>
                        <textarea name="latar_belakang" class="ck-editor" required id="editor2" rows="10">
                            @if ($data != null)
                            {!! $data->latar_belakang !!}
                            @else
                            {!! old('latar_belakang') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount2">0</span>/300</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Kebaruan/Nilai Tambah</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Jelaskan ide/gagasan dan keunggulan (keunikan/nilai tambah/kebaruan) dari inovasi ini.</li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 600 kata</li>
                            </ul>
                        </label>
                        <textarea name="nilai_tambah" class="ck-editor" required id="editor3" rows="10">
                            @if ($data != null)
                            {!! $data->nilai_tambah !!}
                            @else
                            {!! old('nilai_tambah') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount3">0</span>/600</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Implementasi Inovasi</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Uraikan imlementasi inovasi dalam mengatasi permasalahan yang dihadapi.</li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 200 kata</li>
                            </ul>
                        </label>
                        <textarea name="implementasi" class="ck-editor" required id="editor4" rows="10">
                            @if ($data != null)
                            {!! $data->implementasi !!}
                            @else
                            {!! old('implementasi') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount4">0</span>/200</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Signifikansi</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Uraikan dampak inovasi (bandingkan kondisi sebelum dan sesudah inovasi diimplementasikan).</li>
                                <li>Jelaskan metode yang digunakan untuk mengukur dampak inovasi.</li>
                                <li>Lengkapi uraian tersebut dengan melampirkan data dukung berupa laporan hasil evaluasi inovasi baik dari eksternal maupun internal yang memuat data sebelum dan sesudah implementasi inovasi (kualitatif dan kuantitatif).</li>
                                <li>Maksimal 600 kata</li>
                            </ul>
                        </label>
                        <textarea name="signifikansi" class="ck-editor" required id="editor5" rows="10">
                            @if ($data != null)
                            {!! $data->signifikansi !!}
                            @else
                            {!! old('signifikansi') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount5">0</span>/600</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Adaptabilitas</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Apakah inovasi ini sudah direplikasi?</li>
                                <li>Jika sudah, sebutkan UPP dan/atau instansi yang mereplikasi inovasi.</li>
                                <li>Jelaskan potensi inovasi untuk direplikasi dengan menggambarkan luasan populasi dan kesamaan karakter masalah yang dialami atau ada pada daerah lain.</li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 300 kata</li>
                            </ul>
                        </label>
                        <textarea name="adaptabilitas" class="ck-editor" required id="editor6" rows="10">
                            @if ($data != null)
                            {!! $data->adaptabilitas !!}
                            @else
                            {!! old('adaptabilitas') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount6">0</span>/300</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Sumber Daya</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Jelaskan penguatan sumber daya yang digunakan setelah ditetapkan sebagai top inovasi terpuji, yang terdiri dari:
                                    <ul>
                                        <li>Sumber daya keuangan;</li>
                                        <li>Sumber daya manusia;</li>
                                        <li>Metode;</li>
                                        <li>Peralatan atau material;</li>
                                    </ul>
                                </li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 200 kata</li>
                            </ul>
                        </label>
                        <textarea name="sumber_daya" class="ck-editor" required id="editor7" rows="10">
                            @if ($data != null)
                            {!! $data->sumber_daya !!}
                            @else
                            {!! old('sumber_daya') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount7">0</span>/200</p>
                    </div>

                    <div class="row my-2">
                        <label><b>Strategi Keberlanjutan</b><span class="text-danger">*</span>
                            <ul class="mb-1">
                                <li>Jelaskan strategi penguatan keberlanjutan inovasi, yang terdiri dari:
                                    <ul>
                                        <li>Strategi institusional berupa penguatan regulasi atau dasar hukum implementasi dan/atau pemberlakuan inovasi;</li>
                                        <li>Strategi manajerial berupa penguatan peningkatan kapasitas SDM, kinerja organisasi, penjaminan kualitas dan/atau pemberlakuan SOP;</li>
                                        <li>Strategi sosial berupa penguatan partisipasi/kolaborasi pemangku kepentingan yang terlibat dan peran masing-masing pihak;</li>
                                    </ul>
                                </li>
                                <li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li>
                                <li>Maksimal 500 kata</li>
                            </ul>
                        </label>
                        <textarea name="strategi_keberlanjutan" class="ck-editor" required id="editor8" rows="10">
                            @if ($data != null)
                            {!! $data->strategi_keberlanjutan !!}
                            @else
                            {!! old('strategi_keberlanjutan') !!}
                            @endif
                        </textarea>
                        <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount8">0</span>/500</p>
                    </div>

                    <br><br><br>
                    <div class="row mt-4">
                        <div class="col text-left">
                            <a @if ($label == 1) href="{{ route('kovablik.index', ['area' => 'pemda']) }}" @else href="{{ route('kovablik.index', ['area' => 'masyarakat']) }}" @endif
                                class="btn btn-light btn-lg">Batal</a>
                        </div>
                        <div class="col text-right">

                            @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                                <button class="btn btn-success btn-lg" type="submit" name="status"
                                    value="0">Simpan</button>
                            @else
                                <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                                    class="btn btn-danger">Simpan</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        </div>
    @else
        <h3>
            Inotek Sudah Ditutup
        </h3>
    @endif
    <br><br><br><br><br>
@endsection

<script>
    // Panggil fungsi saat halaman dimuat, jika dalam mode edit
    document.addEventListener('DOMContentLoaded', (event) => {

        if ('{{ $data ? true : false }}') {
            div_tahapan('{{ csrf_token() }}', '#div_tahapan', '#form-edit-inovasi');
        }
        const pengembangan1 = document.getElementById('pengembangan_1');
        const pengembangan0 = document.getElementById('pengembangan_0');
        const waktuPenerapanRow = document.getElementById('waktu_penerapan_row');

        const toggleWaktuPenerapanRow = () => {
            if (pengembangan1.checked) {
                waktuPenerapanRow.style.display = 'flex';
            } else {
                waktuPenerapanRow.style.display = 'none';
            }
        };

        // Initial check on page load
        toggleWaktuPenerapanRow();

        // Add event listeners
        pengembangan1.addEventListener('change', toggleWaktuPenerapanRow);
        pengembangan0.addEventListener('change', toggleWaktuPenerapanRow);
    });
    document.addEventListener("DOMContentLoaded", function() {
        // Check if we're in edit mode and if tematik_id is set
        var inovasiId = "{{ $data ? $data->id : '' }}";
        var token = "{{ csrf_token() }}";

        var maxSize = 2 * 1024 * 1024;

        var file_anggaran = $('#form-edit-inovasi').find('input[name="file_anggaran"]');
        file_anggaran.on('change', function() {
            var file = this.files[0];

            if (file.size > maxSize) {
                alert('File Size Maximal 2MB');
                $(this).val('');
            }
        });

        var profil_bisnis = $('#form-edit-inovasi').find('input[name="profil_bisnis"]');
        profil_bisnis.on('change', function() {
            var file = this.files[0];

            if (file.size > maxSize) {
                alert('File Size Maximal 2MB');
                $(this).val('');
            }
        });

        var file_dokumen_haki = $('#form-edit-inovasi').find('input[name="file_dokumen_haki"]');
        file_dokumen_haki.on('change', function() {
            var file = this.files[0];

            if (file.size > maxSize) {
                alert('File Size Maximal 2MB');
                $(this).val('');
            }
        });

        var file_penghargaan = $('#form-edit-inovasi').find('input[name="file_penghargaan"]');
        file_penghargaan.on('change', function() {
            var file = this.files[0];

            if (file.size > maxSize) {
                alert('File Size Maximal 2MB');
                $(this).val('');
            }
        });


    });
</script>
@section('script')
    @include('script.ck-editor-count')
@endsection