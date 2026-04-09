<script>
	var count = document.querySelectorAll('.ck-editor').length;
	for (let i = 1; i <= count; i++) {
		ClassicEditor
			.create( document.querySelector( '#editor'+i ) )
			.catch( error => {
				console.error( error );
			} );
	}
</script>