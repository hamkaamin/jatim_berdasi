<script>
    document.querySelectorAll('.ck-editor').forEach((editorElement, index) => {
        ClassicEditor
            .create(editorElement)
            .then(editor => {
                let wordCountSpan = document.getElementById(`wordCount${index + 1}`);

                editor.model.document.on('change:data', () => {
                    let text = editor.getData().replace(/<[^>]*>/g, '');
                    let words = text.trim().split(/\s+/).filter(word => word.length > 0);
                    wordCountSpan.innerText = words.length;
                });
            })
            .catch(error => console.error(error));
    });
    document.addEventListener("DOMContentLoaded", function() {
        const editorDivs = document.querySelectorAll(".ck.ck-reset.ck-editor");
        editorDivs.forEach(editor => {
            editor.classList.add("w-100");
        });
    });
</script>