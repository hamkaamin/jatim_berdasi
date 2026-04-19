@extends('layouts.main')

@push('styles')
    @include('inovasi.partials.stepper-style')
@endpush

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
                    enctype="multipart/form-data" id="form-edit-inovasi"
                    data-action-inovasi="{{ route('inovasi.save', ['id' => $data != null ? $data->id : 0]) }}"
                    data-action-kovablik="{{ route('kovablik.save', ['id' => $data != null ? $data->id : 0]) }}">
                    <input type="hidden" name="label" value="{{ $label }}">
                    @csrf
                    @php
                        $user = $data != null ? $data->user : Auth::user();
                    @endphp
                    <!-- ===== STEPPER HEADER ===== -->
                    <div class="stepper-header" id="stepperHeader">
                        <div class="stepper-item step-active" id="stepper-1">
                            <div class="stepper-circle">1</div>
                            <div class="stepper-label">Informasi<br>Dasar</div>
                        </div>
                        <div class="stepper-item" id="stepper-2">
                            <div class="stepper-circle">2</div>
                            <div class="stepper-label">Klasifikasi<br>Inovasi</div>
                        </div>
                        <div class="stepper-item" id="stepper-3">
                            <div class="stepper-circle">3</div>
                            <div class="stepper-label">Deskripsi &amp;<br>Dokumen</div>
                        </div>
                    </div>

                    <!-- ===== PROGRESS BAR ===== -->
                    <div class="stepper-progress">
                        <div class="stepper-progress-bar" id="stepperProgress" style="width: 16%"></div>
                    </div>

                    <div class="step-panel step-panel-active" id="step-panel-1">
                        <p class="step-panel-title">Langkah 1 &mdash; Informasi Dasar</p>
                        <p class="step-panel-subtitle">Identitas umum inovasi yang akan didaftarkan</p>
                        <hr class="step-divider">

                        <div class="row my-2">
                            <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Pemda</b></label></div>
                            <div class="col-sm-9">
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
                            <div class="col-sm-9">
                                {{ $user->name . ' - ' . $user->username }}
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-sm-3 d-flex align-items-center"><label><b>Nama Inovasi</b> <span
                                        class="text-danger">*</span></label></div>
                            <div class="col-sm-9"><input type="text" required name="nama" class="form-control"
                                    value="{{ $data != null ? ($data->nama ?? $data->judul) : old('nama') }}"></div>
                        </div>

                        <div class="row my-2">
                            <div class="col-sm-3 d-flex align-items-center"><label><b>Kategori Inovasi</b> <span
                                        class="text-danger">*</span></label></div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center">
                                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}"
                                                    data-is-kovablik="{{ $item->is_kovablik ? '1' : '0' }}"
                                                    @if (
                                                        old('kategori_id') == $item->id ||
                                                        ($data && !($data instanceof \App\Models\ProposalKovablik) && $data->kategori_id == $item->id) ||
                                                        ($data instanceof \App\Models\ProposalKovablik && $item->is_kovablik)
                                                    ) selected @endif>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="stepper-nav">
                            <span class="step-badge">Langkah 1 dari 3</span>
                            <div>
                                <a @if ($label == 1) href="{{ route('inovasi.index', ['area' => 'masyarakat']) }}" @else href="{{ route('inovasi.index', ['area' => 'provinsi']) }}" @endif
                                    class="btn btn-light btn-lg mr-2">Batal</a>
                                <button type="button" class="btn btn-primary btn-lg" onclick="stepperNext(1)">
                                    Selanjutnya <i class="uil-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="div_kategori_inovasi">

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
    {{-- <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
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
    </div> --}}
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

        if (pengembangan1 && pengembangan0 && waktuPenerapanRow) {
            const toggleWaktuPenerapanRow = () => {
                if (pengembangan1.checked) {
                    waktuPenerapanRow.style.display = 'flex';
                } else {
                    waktuPenerapanRow.style.display = 'none';
                }
            };
            toggleWaktuPenerapanRow();
            pengembangan1.addEventListener('change', toggleWaktuPenerapanRow);
            pengembangan0.addEventListener('change', toggleWaktuPenerapanRow);
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        var inovasiId = "{{ $data ? $data->id : '' }}";
        var token = "{{ csrf_token() }}";

        div_kategori_inovasi(token, '#div_kategori_inovasi', '#form-edit-inovasi', inovasiId)

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

    function div_kategori_inovasi(token, target, form_id, inovasi_id, callback) {
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
                    ckEditorsInited = false;
                    div_tahapan(token, '#div_tahapan', form_id);
                    if (typeof callback === 'function') callback();
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
    @include('inovasi.partials.stepper-script')
@endsection
