<script>
    var editorInstances = [];

    // Dipanggil dari stepper saat step-panel-3 sudah visible
    window.initCkEditorCount = function() {
        // Destroy instance lama agar tidak double-init
        editorInstances.forEach(function(item) {
            try { item.editor.destroy(); } catch(e) {}
        });
        editorInstances = [];

        document.querySelectorAll('.ck-editor').forEach(function(editorElement, index) {
            ClassicEditor
                .create(editorElement)
                .then(function(editor) {
                    editorInstances.push({ editor: editor, textarea: editorElement });
                    var wordCountSpan = document.getElementById('wordCount' + (index + 1));
                    if (wordCountSpan) {
                        var updateWordCount = function() {
                            var text = editor.getData().replace(/<[^>]*>/g, '');
                            var words = text.trim().split(/\s+/).filter(function(w) { return w.length > 0; });
                            wordCountSpan.innerText = words.length;
                        };
                        updateWordCount();
                        editor.model.document.on('change:data', updateWordCount);
                    }
                })
                .catch(function(error) { console.error(error); });
        });
    };

    // Hapus listener lama agar tidak duplikasi saat AJAX reload
    if (window._ckSubmitHandler) {
        document.getElementById('form-edit-inovasi').removeEventListener('submit', window._ckSubmitHandler);
    }

    window._ckSubmitHandler = function(e) {
        var isValid = true;
        var missingFields = [];

        editorInstances.forEach(function(item, idx) {
            // Sync semua editor ke textarea
            item.textarea.value = item.editor.getData();

            // Hanya validasi panel yang aktif
            var panel = item.textarea.closest('.step-panel');
            if (panel && !panel.classList.contains('step-panel-active')) {
                return;
            }

            var plainText = item.editor.getData().replace(/<[^>]*>/g, '').trim();
            if (!plainText) {
                var fieldName = item.textarea.getAttribute('data-label') || ('Kolom narasi ' + (idx + 1));
                missingFields.push(fieldName);
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert("Kolom dibawah masih kosong dan wajib diisi:\n\n" + missingFields.join('\n'));
        }
    };

    document.getElementById('form-edit-inovasi').addEventListener('submit', window._ckSubmitHandler);
</script>