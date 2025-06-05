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

                const updateWordCount = () => {
                    let text = editor.getData().replace(/<[^>]*>/g, '');
                    let words = text.trim().split(/\s+/).filter(word => word.length > 0);
                    wordCountSpan.innerText = words.length;
                };
                updateWordCount();
                editor.model.document.on('change:data', updateWordCount);
            })
            .catch(error => console.error(error));
    });
    document.addEventListener("DOMContentLoaded", function() {
        const editorDivs = document.querySelectorAll(".ck.ck-reset.ck-editor");
        editorDivs.forEach(editor => {
            editor.classList.add("w-100");
        });
    });
    document.getElementById('form-edit-inovasi').addEventListener('submit', function(e) {
        let isValid = true;
        let missingFields = [];

        editorInstances.forEach(({
            editor,
            textarea
        }, idx) => {
            const plainText = editor.getData().replace(/<[^>]*>/g, '').trim();

            if (!plainText) {
                // Try to get field name, or use fallback
                const fieldName = textarea.getAttribute('data-label');
                missingFields.push(fieldName);
                isValid = false;
            }

            // Sync HTML back to textarea
            textarea.value = editor.getData();
        });

        if (!isValid) {
            e.preventDefault();
            alert("Kolom dibawah masih kosong dan wajib diisi:\n\n" + missingFields.join('\n'));
        }
    });
</script>