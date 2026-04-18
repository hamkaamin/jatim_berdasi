<script>
    const editorInstances = [];
    document.querySelectorAll('.ck-editor').forEach((editorElement, index) => {
        ClassicEditor
            .create(editorElement)
            .then(editor => {
                editorInstances.push({
                    editor: editor,
                    textarea: editorElement
                });
                let wordCountSpan = document.getElementById(`wordCount${index + 1}`);
                if (wordCountSpan) {
                    const updateWordCount = () => {
                        let text = editor.getData().replace(/<[^>]*>/g, '');
                        let words = text.trim().split(/\s+/).filter(word => word.length > 0);
                        wordCountSpan.innerText = words.length;
                    };
                    updateWordCount();
                    editor.model.document.on('change:data', updateWordCount);
                }
            })
            .catch(error => console.error(error));
    });

    // Hapus listener lama sebelum pasang yang baru (mencegah duplikasi saat AJAX reload)
    if (window._ckSubmitHandler) {
        document.getElementById('form-edit-inovasi').removeEventListener('submit', window._ckSubmitHandler);
    }

    window._ckSubmitHandler = function(e) {
        let isValid = true;
        let missingFields = [];

        editorInstances.forEach(({ editor, textarea }, idx) => {
            // Sync konten ke textarea terlepas dari visibility
            textarea.value = editor.getData();

            // Hanya validasi jika berada di panel yang aktif (visible)
            var panel = textarea.closest('.step-panel');
            if (panel && !panel.classList.contains('step-panel-active')) {
                return;
            }

            const plainText = editor.getData().replace(/<[^>]*>/g, '').trim();
            if (!plainText) {
                const fieldName = textarea.getAttribute('data-label') || `Kolom narasi ${idx + 1}`;
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