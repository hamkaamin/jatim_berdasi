<script>
	function ubahWilayah(scopeNext, selfId) {
		var defaultOption = "<option disabled selected>-- Pilih Salah Satu --</option>";
		var kota = document.getElementById('kota_id');
		var kecamatan = document.getElementById('kecamatan_id');
		var kelurahan = document.getElementById('kelurahan_id');
		if (scopeNext == 'kota') {
			kota.innerHTML = "";
			if (kecamatan) { kecamatan.innerHTML = defaultOption; }
			if (kelurahan) { kelurahan.innerHTML = defaultOption; }
		} else if (scopeNext == 'kecamatan') {
			kecamatan.innerHTML = "";
			if (kelurahan) { kelurahan.innerHTML = defaultOption; }
		} else if (scopeNext == 'kelurahan') {
			kelurahan.innerHTML = "";
		} else {
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '{{route("change-area")}}',
			data: {
				'_token': '<?php echo csrf_token() ?>',
				'scopeNext': scopeNext,
				'selfId': selfId,
			},
			success: function(data) {
				$('#'+scopeNext+'_id').html(data.msg);
			},
			error: function(xhr) {
				console.log(xhr);
			}
		});
	}
</script>