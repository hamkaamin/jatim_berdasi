<script>
    var currentStep = 1;
    var totalSteps = 3;
    var progressStops = [16, 50, 100];
    var ckEditorsInited = false;
    var isKovablik = false;

    function getKategori() {
        return $('#form-edit-inovasi').find('select[name="kategori_id"]').val();
    }

    function stepperNext(fromStep) {
        if (fromStep === 1) {
            var nama = $('#form-edit-inovasi').find('input[name="nama"]').val().trim();
            var kategori = getKategori();
            if (!nama) {
                alertKu('warning', 'Nama Inovasi wajib diisi sebelum melanjutkan.');
                return;
            }
            if (!kategori) {
                alertKu('warning', 'Kategori Inovasi wajib dipilih sebelum melanjutkan.');
                return;
            }

            var selectedOption = $('#form-edit-inovasi').find('select[name="kategori_id"] option:selected');
            var kovablik = selectedOption.data('is-kovablik');
            isKovablik = kovablik == 1;

            var form = document.getElementById('form-edit-inovasi');
            if (isKovablik) {
                form.action = form.dataset.actionKovablik;
                $('#stepper-2 .stepper-label').html('Klasifikasi &amp;<br>Administrasi');
                $('#stepper-3 .stepper-label').html('Data Pendukung<br>&amp; Narasi');
            } else {
                form.action = form.dataset.actionInovasi;
                $('#stepper-2 .stepper-label').html('Klasifikasi<br>Inovasi');
                $('#stepper-3 .stepper-label').html('Deskripsi &amp;<br>Dokumen');
            }

            div_kategori_inovasi('{{ csrf_token() }}', '#div_kategori_inovasi', '#form-edit-inovasi', {{ $data ? $data->id : 'null' }}, function() {
                goToStep(2);
            });
            return;
        }
        if (fromStep === 2) {
            var errors = [];
            if (isKovablik) {
                var kategoriKov = $('#form-edit-inovasi').find('[name="kategori_kovablik_id"]').val();
                var kelompok    = $('#form-edit-inovasi').find('[name="kelompok_id"]').val();
                var jenisIno    = $('#form-edit-inovasi').find('[name="kov_jenis_inovasi"]').val();
                var tglMulai    = $('#form-edit-inovasi').find('[name="tanggal_mulai"]').val();
                var namaInov    = $.trim($('#form-edit-inovasi').find('[name="nama_inovator"]').val());
                var nipInov     = $.trim($('#form-edit-inovasi').find('[name="kov_nip_inovator"]').val());
                if (!kategoriKov) errors.push('Kategori wajib dipilih');
                if (!kelompok)    errors.push('Kelompok Inovasi wajib dipilih');
                if (!jenisIno)    errors.push('Jenis Inovasi wajib dipilih');
                if (!tglMulai)    errors.push('Waktu Mulai Implementasi wajib diisi');
                if (!namaInov)    errors.push('Nama Inovator wajib diisi');
                if (!nipInov)     errors.push('NIP Inovator wajib diisi');
            } else {
                var namaInisiator = $.trim($('#form-edit-inovasi').find('[name="nama_inisiator"]').val());
                var jenisChecked  = $('[name="jenis_id"]:checked').val();
                var urusan        = $('[name="urusan_id[]"]').val();
                var waktuUji      = $('#form-edit-inovasi').find('[name="waktu_uji_coba"]').val();
                var waktuPenerapan = $('#form-edit-inovasi').find('[name="waktu_penerapan"]').val();
                if (!namaInisiator)                    errors.push('Nama Inisiator wajib diisi');
                if (!jenisChecked)                     errors.push('Jenis Inovasi wajib dipilih');
                if (!urusan || !urusan.length)         errors.push('Urusan Inovasi wajib dipilih');
                if (!waktuUji)                         errors.push('Waktu Ujicoba Inovasi wajib diisi');
                if (!waktuPenerapan)                   errors.push('Waktu Penerapan Inovasi wajib diisi');
            }
            if (errors.length > 0) {
                Swal.fire({
                    title: 'Lengkapi Data',
                    html: '<ul class="text-left mb-0">' + errors.map(function(e){ return '<li>' + e + '</li>'; }).join('') + '</ul>',
                    icon: 'warning',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Tutup'
                });
                return;
            }
        }
        goToStep(fromStep + 1);
    }

    function stepperPrev(fromStep) {
        goToStep(fromStep - 1);
    }

    function goToStep(targetStep) {
        if (targetStep < 1 || targetStep > totalSteps) return;

        var allPanels = ['step-panel-1', 'step-panel-2', 'step-panel-2-kov', 'step-panel-3', 'step-panel-3-kov'];
        allPanels.forEach(function(id) {
            $('#' + id).removeClass('step-panel-active');
        });

        $('#stepper-' + currentStep).removeClass('step-active');
        if (targetStep > currentStep) {
            $('#stepper-' + currentStep).addClass('step-done');
        } else {
            for (var i = targetStep; i <= totalSteps; i++) {
                $('#stepper-' + i).removeClass('step-done');
            }
        }

        currentStep = targetStep;
        $('#stepper-' + currentStep).addClass('step-active').removeClass('step-done');
        $('#stepperProgress').css('width', progressStops[currentStep - 1] + '%');

        if (currentStep === 1) {
            $('#step-panel-1').addClass('step-panel-active');
        } else if (currentStep === 2) {
            if (isKovablik) {
                $('#step-panel-2-kov').addClass('step-panel-active');
            } else {
                $('#step-panel-2').addClass('step-panel-active');
            }
        } else if (currentStep === 3) {
            if (isKovablik) {
                $('#step-panel-3-kov').addClass('step-panel-active');
            } else {
                $('#step-panel-3').addClass('step-panel-active');
            }
            if (!ckEditorsInited) {
                ckEditorsInited = true;
                if (typeof window.initCkEditorCount === 'function') {
                    window.initCkEditorCount();
                }
            }
        }

        $('html, body').animate({ scrollTop: $('#form-edit-inovasi').offset().top - 80 }, 300);
    }
</script>
