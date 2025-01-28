@extends('layouts.main')

@section('title')
    {{ $data != null ? 'Edit' : 'Tambah' }} Inovasi
@endsection

@section('title-desc')
    Form untuk {{ $data != null ? 'Mengedit' : 'Menambah' }} Data Inovasi dalam Sistem
@endsection

@section('buttons')
@endsection

@section('content')
    @if (env('APP_CLOSE_APP') == 0)
        <div class="row">
            <div class="col">
                <form action="{{ route('inovasi.save', ['id' => $data != null ? $data->id : 0]) }}" method="post"
                    enctype="multipart/form-data" id="form-edit-inovasi">
                    <input type="hidden" name="label" value="{{ $label }}">
                    @csrf
                    @php
                        $user = $data != null ? $data->user : Auth::user();
                    @endphp
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Pemda</b></label></div>
                        <div class="col-sm-8">
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
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Dibuat Oleh</b></label></div>
                        <div class="col-sm-8">
                            {{ $user->name . ' - ' . $user->username }}
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8"><input type="text" required name="nama" class="form-control"
                                value="{{ $data != null ? $data->nama : old('nama') }}"></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori Inovasi</b> <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-sm-8">
                            <div class="row">
                                @if (Auth::user()->role == 4 || Auth::user()->role == 5)
                                    {{-- @foreach ($kategori as $item) --}}
                                    <div class="col-12 d-flex align-items-center">
                                        {{-- <select name="kategori_id" id="kategori_id" class="form-control" required
                                            onchange="div_tahapan('{{ csrf_token() }}','#div_tahapan','#form-edit-inovasi')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->kategori->id }}"
                                                    @if (old('kategori_id') == $item->kategori->id || ($data && $data->kategori_id == $item->kategori->id)) selected @endif>
                                                    {{ $item->kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <select name="kategori_id" id="kategori_id" class="form-control" required
                                            onchange="div_kategori_inovasi('{{ csrf_token() }}','#div_kategori_inovasi','#form-edit-inovasi',{{ $data ? $data->id : 'null' }})">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->kategori->id }}"
                                                    @if (old('kategori_id') == $item->kategori->id || ($data && $data->kategori_id == $item->kategori->id)) selected @endif>
                                                    {{ $item->kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- @endforeach --}}
                                @else
                                    @foreach ($kategori as $item)
                                        <div class="col-6 d-flex align-items-center">
                                            <input type="radio" id="kategori_{{ $item->id }}"
                                                value="{{ $item->id }}" name="kategori_id"
                                                @if (old('kategori_id') == $item->id ||
                                                        ($data == null && $loop->iteration == 1) ||
                                                        ($data != null && $data->kategori_id == $item->id))  @endif><label class="pb-0 mb-0 ml-2"
                                                onclick="div_tahapan('{{ csrf_token() }}','#div_tahapan','#form-edit-inovasi')">{{ $item->kategori->nama }}
                                                for="kategori_{{ $item->id }}">{{ $item->nama }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="div_kategori_inovasi">

                    </div>


                    <div class="row mt-4">
                        <div class="col text-right">
                            <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'pemda']) }}" @else href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @endif
                                class="btn btn-light btn-lg">Batal</a>

                            @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                                <button class="btn btn-success btn-lg" type="submit" name="status"
                                    value="0">Simpan</button>
                            @else
                                <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                                    class="btn btn-danger">Simpan</a>
                            @endif
                            @if ($data != null && $data->status == 0)
                                @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                                    @if (env('APP_NAME') == 'INOVASI DAERAH')
                                        <button style="display: none" type="submit" class="btn btn-primary" name="status"
                                            value="1"
                                            onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Kirim
                                            Inovasi</button>
                                    @else
                                        <button type="submit" class="btn btn-primary" name="status" value="1"
                                            onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Kirim
                                            Inovasi</button>
                                    @endif
                                @else
                                    <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                                        class="btn btn-danger">Kirim
                                        inovasi</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        </div>
    @else
        <h3>
            Inotek Sudah Ditutup Per 5 Mei 2023, 22.00
        </h3>
    @endif
    <br><br><br><br><br>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @else href="{{ route('inovasi.index', ['area' => 'kota']) }}" @endif
                class="btn btn-light">
                Kembali</a>
            @if ($data != null && $data->status == 0)
                <form style="all: unset" action="{{ route('inovasi.save', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="label" value="{{ $data->label }}">
                    @if ($fase && $fase->active == 1 && strtotime($fase->tgl_berakhir) >= strtotime(date('Y-m-d H:i:s')))
                        <button type="submit" class="btn btn-primary" name="status" value="1"
                            onclick="if(!confirm('Apakah Anda yakin akan submit data Inovasi ini? (Pastikan seluruh isian wajib telah terisi dan telah melengkapi data-data INDIKATOR yang dibutuhkan)')){return false;}">Kirim
                            Inovasi</button>
                    @else
                        <a onclick="alertKu('warning', 'Fase Usulan sedang tutup');" href="#"
                            class="btn btn-danger">Kirim
                            inovasi</a>
                    @endif
                </form>
            @endif

            @if (Auth::user()->role == 2)
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalPopup"
                    onclick="modal({{ request()->id }}, 'inovasi_status')">Update Status Inovasi</button>
            @endif
        </div>
    </div>
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
        var tematikId = "{{ $data ? $data->tematik_id : '' }}";
        var inovasiId = "{{ $data ? $data->id : '' }}";

        if (tematikId) {
            get_detail_tematik(tematikId, inovasiId);
        }

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

    function countWords() {
        var inputElement = document.getElementById("inputText");
        var wordCountElement = document.getElementById("wordCount");
        var wordCountLessElement = document.getElementById("wordCountLess");
        var warningMessage = document.getElementById("warningMessage");

        var text = inputElement.value.trim();
        var words = text.split(/\s+/);

        if (words.length < 300) {
            warningMessage.style.display = "block";
        } else {
            warningMessage.style.display = "none";
        }

        wordCountElement.textContent = words.length;
        wordCountLessElement.textContent = 300 - words.length;
    }

    function div_tahapan(token, target, form_id) {
        var kategori_id = $(form_id).find('select[name="kategori_id"] option:selected').val();
        var tahapan_id = '{{ $data ? $data->tahapan_id : '' }}';
        var act = '{{ route('inovasi.show_tahapan') }}';

        $(form_id).find('#div_tahapan').html('<option value="">Waiting Data ...</option>');
        $.post(act, {
                _token: token,
                kategori_id: kategori_id
            },
            function(data) {
                $('#tahapan_id').prop("disabled", false);
                $(form_id).find('#tahapan_id').html(data);

                // Jika sedang mengedit, pilih tahapan yang sesuai
                if (tahapan_id) {
                    $(form_id).find('#tahapan_id').val(tahapan_id).trigger('change');
                }
            });
    }

    function div_kategori_inovasi(token, target, form_id, inovasi_id) {
        var kategori_id = $(form_id).find('select[name="kategori_id"] option:selected').val();

        $.ajax({
            url: '{{ route('inovasi.ajax_kategori_inovasi') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                inovasi_id: inovasi_id,
                kategori_id: kategori_id
            },
            success: function(response) {
                if (response != 'failed') {
                    $(target).html(response);
                    div_tahapan(token, '#div_tahapan', form_id);
                } else {
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    function get_detail_tematik(tematik_id, inovasi_id) {
        $.ajax({
            url: '{{ route('inovasi.ajax_detail_tematik') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tematik_id: tematik_id,
                inovasi_id: inovasi_id
            },
            success: function(response) {
                if (response != 'failed') {
                    $('.detail_tematik').html(response);
                } else {
                    alert('Data Tematik Tidak Ditemukan');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@section('script')
    {{-- @include('script.select2-multiple') --}}
    @include('script.modal')
@endsection
