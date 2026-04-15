@if ($type == 'row')
    <div class="row my-2">
        <div class="col-sm-4 d-flex align-items-center"><label>{{ $label }} <span
                    class="text-danger">*</span></label></div>
        <div class="col-sm-8">
        @else
            <div class="col">
                <label>{{ $label }}</label>
@endif
<select @if ($labelNext != null) onchange="ubahWilayah('{{ $labelNext }}', this.value);" @endif
    class="form-control" name="{{ strtolower($label) . '_id' }}" id="{{ strtolower($label) . '_id' }}" required>
    <option selected disabled>-- Pilih Salah Satu --</option>
    @foreach ($wilayah as $item)
        <option value="{{ $item->id }}">
            @if (in_array(strtolower($label), ['provinsi', 'kota', 'kelurahan', 'kecamatan']))
                {{ $item->name }}
            @else
                {{ $item->nama }}
            @endif
        </option>
    @endforeach
</select>
@if ($label == 'OPD')
    <small><b>Jika OPD tidak ada kemungkinan usernya sudah ditambahkan. Kalau Usernya tidak ada, bisa ditambahkan OPD
            terlebih dahulu.</b></small>
@endif
@if ($type == 'row')
    </div>
    </div>
@else
    </div>
@endif
<script>
    $(document).ready(function() {
        $("#{{ strtolower($label) . '_id' }}").select2({
            dropdownParent: $('#modalContent'),
            width: 'resolve',
        });
    });
</script>
