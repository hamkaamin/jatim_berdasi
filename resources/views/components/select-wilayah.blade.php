<div class="row my-2">
    <div class="col-sm-4 d-flex align-items-center"><label>{{ $label }} <span class="text-danger">*</span></label></div>
    <div class="col-sm-8">
        <select @if($labelNext != null) onchange="ubahWilayah('{{ $labelNext }}', this.value);" @endif class="form-control" name="{{ strtolower($label).'_id' }}" id="{{ strtolower($label).'_id' }}" required>
            <option selected disabled>-- Pilih Salah Satu --</option>
            @foreach ($wilayah as $item)
                <option value="{{ $item->id }}">@if(in_array(strtolower($label), ['provinsi', 'kota', 'kelurahan', 'kecamatan'])) {{ $item->name }} @else {{ $item->nama }} @endif</option>
            @endforeach
        </select>
    </div>
</div>
<script>
	$(document).ready(function() {
		$("#{{ strtolower($label).'_id' }}").select2();
	});
</script>