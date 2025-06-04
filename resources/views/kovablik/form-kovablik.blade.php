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
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Dokumen Standart Pelayanan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="dokumen_standart_pelayanan">
                            @if ($data != null)
                                <br><a href="{{ $data->link_standart }}" target="_blank">Download
                                    File
                                    Dokumen Standart Pelayanan</a>
                            @endif
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Dokumen Maklumat Pelayanan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="dokumen_maklumat_pelayanan">
                            @if ($data != null)
                                <br><a href="{{ $data->link_maklumat }}" target="_blank">Download
                                    File
                                    Dokumen Maklumat Pelayanan</a>
                            @endif
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Dokumen SK Pengelolaan Pengaduan</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="file" accept=".jpg,.jpeg,.png,.pdf" name="dokumen_sk_pengelolaan_pengaduan">
                            @if ($data != null)
                                <br><a href="{{ $data->link_sk_pengaduan }}" target="_blank">Download
                                    File
                                    Dokumen Maklumat Pelayanan</a>
                            @endif
                        </div>
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

                    @foreach($kategoriNilai as $kategori)
                        @if($kategori->tahapan_id == 1)
                            <div class="row my-2">
                                <label><b>{{ $kategori->bagian }}</b><span class="text-danger">*</span>
                                    {!! $kategori->indikator !!}
                                </label>

                                @if($kategori->bagian == 'Latar Belakang dan Tujuan')
                                    <p>Maksimal 300 kata</p>
                                    <textarea name="latar_belakang_dan_tujuan" class="ck-editor" required id="editor2" rows="10">
                                        @if ($data != null)
                                        {!! $data->latar_belakang !!}
                                        @else
                                        {!! old('latar_belakang_dan_tujuan') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount2">0</span>/300</p>
                                @elseif($kategori->bagian == 'Kebaruan/Nilai Tambah')
                                    <p>Maksimal 600 kata</p>
                                    <textarea name="kebaruan_atau_nilai_tambah" class="ck-editor" required id="editor3" rows="10">
                                        @if ($data != null)
                                        {!! $data->nilai_tambah !!}
                                        @else
                                        {!! old('kebaruan_atau_nilai_tambah') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount3">0</span>/600</p>
                                @elseif($kategori->bagian == 'Implementasi Inovasi')
                                    <p>Maksimal 200 kata</p>
                                    <textarea name="implementasi_inovasi" class="ck-editor" required id="editor4" rows="10">
                                        @if ($data != null)
                                        {!! $data->implementasi !!}
                                        @else
                                        {!! old('implementasi_inovasi') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount4">0</span>/200</p>
                                @elseif($kategori->bagian == 'Signifikansi')
                                    <p>Maksimal 600 kata</p>
                                    <textarea name="signifikansi" class="ck-editor" required id="editor5" rows="10">
                                        @if ($data != null)
                                        {!! $data->signifikansi !!}
                                        @else
                                        {!! old('signifikansi') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount5">0</span>/600</p>
                                @elseif($kategori->bagian == 'Adaptabilitas')
                                    <p>Maksimal 300 kata</p>
                                    <textarea name="adaptabilitas" class="ck-editor" required id="editor6" rows="10">
                                        @if ($data != null)
                                        {!! $data->adaptabilitas !!}
                                        @else
                                        {!! old('adaptabilitas') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount6">0</span>/300</p>
                                @elseif($kategori->bagian == 'Sumber Daya')
                                    <p>Maksimal 200 kata</p>
                                    <textarea name="sumber_daya" class="ck-editor" required id="editor7" rows="10">
                                        @if ($data != null)
                                        {!! $data->sumber_daya !!}
                                        @else
                                        {!! old('sumber_daya') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount7">0</span>/200</p>
                                @elseif($kategori->bagian == 'Strategi Keberlanjutan')
                                    <p>Maksimal 500 kata</p>
                                    <textarea name="strategi_keberlanjutan" class="ck-editor" required id="editor8" rows="10">
                                        @if ($data != null)
                                        {!! $data->strategi_keberlanjutan !!}
                                        @else
                                        {!! old('strategi_keberlanjutan') !!}
                                        @endif
                                    </textarea>
                                    <p class="mb-0 text-end">Jumlah Kata: <span id="wordCount8">0</span>/500</p>
                                @endif
                            </div>
                        @endif
                    @endforeach

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
    $(document).ready(function() {
         $('.js-example-basic-multiple').select2();
     });
</script>
@section('script')
    @include('script.ck-editor-count')
@endsection