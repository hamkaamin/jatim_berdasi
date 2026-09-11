<div class="modal fade" id="modalPopup" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modalContent">

        </div>
    </div>
</div>

<script>
    function modal(id, type, parent_id) {
        $('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
        $.ajax({
            type: 'POST',
            url: '{{ route('modal') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'type': type,
                'parent_id': parent_id || 0,
            },
            success: function(data) {
                $('#modalContent').html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

    function showModal(id, type) {

        $('#modalContent').html("<div class=\"text-center my-3\"><h2>Loading...</h2></div>");
        $.ajax({
            type: 'POST',
            url: '{{ route('modal') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'type': type,
            },
            success: function(data) {
                $('#modalContent').html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>
