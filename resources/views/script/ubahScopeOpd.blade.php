<script>
    function ubahScopeOpd(type, align) {
        $('#'+align+'_scope_container').html("<div class=\"text-center my-1\"><h4><b>Loading...</b></h4></div>");
        $.ajax({
            type: 'POST',
            url: '{{route("opd.change-scope")}}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'type': type,
                'align': align,
            },
            success: function(data) {
                $('#'+align+'_scope_container').html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>