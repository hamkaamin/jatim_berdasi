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
        // Hanya sync semua editor ke textarea; validasi ditangani oleh interceptor utama
        editorInstances.forEach(function(item) {
            item.textarea.value = item.editor.getData();
        });
    };

    document.getElementById('form-edit-inovasi').addEventListener('submit', window._ckSubmitHandler);
</script>