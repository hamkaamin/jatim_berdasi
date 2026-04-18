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

            if (isKovablik) {
                $('#stepper-2 .stepper-label').html('Klasifikasi &amp;<br>Administrasi');
                $('#stepper-3 .stepper-label').html('Data Pendukung<br>&amp; Narasi');
            } else {
                $('#stepper-2 .stepper-label').html('Klasifikasi<br>Inovasi');
                $('#stepper-3 .stepper-label').html('Deskripsi &amp;<br>Dokumen');
            }

            div_kategori_inovasi('{{ csrf_token() }}', '#div_kategori_inovasi', '#form-edit-inovasi', {{ $data ? $data->id : 'null' }}, function() {
                goToStep(2);
            });
            return;
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
                if (!ckEditorsInited) {
                    ckEditorsInited = true;
                    var editors = document.querySelectorAll('.ck-editor');
                    for (var i = 0; i < editors.length; i++) {
                        ClassicEditor.create(editors[i]).catch(function(error) {
                            console.error(error);
                        });
                    }
                }
            }
        }

        $('html, body').animate({ scrollTop: $('#form-edit-inovasi').offset().top - 80 }, 300);
    }
</script>
