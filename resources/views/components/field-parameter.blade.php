<div class="row my-2 align-items-center" @if ($param != null) id="parameter_{{ $param->id }}" @endif>
    <div class="col">
        <input type="hidden" name="parameter_id[]" value="{{ $param != null ? $param->id : 0 }}">
        <input type="text" name="nama[]" class="form-control" required placeholder="Nama Parameter"
            value="{{ $param != null ? $param->nama : '' }}">
    </div>
    <div class="col-3">
        <input type="number" name="bobot[]" step="any" class="form-control" required placeholder="Bobot"
            value="{{ $param != null ? $param->bobot : '' }}">
    </div>
    <div class="col-3">
        <select name="definisi_operasional[]" id="definisi_operasional[]" class="form-control"
            onchange="
                                    $('#div_definisi_{{ $param != null ? $param->id : $append_data }}').val(this.value);
                                    $('#div_definisi_{{ $param != null ? $param->id : $append_data }}').hide(500);
                                    if(this.value == 'buat_baru'){
                                        $('#div_definisi_{{ $param != null ? $param->id : $append_data }}').val('');
                                        $('#div_definisi_{{ $param != null ? $param->id : $append_data }}').show(500);
                                    }">
            @foreach ($param2 as $item)
                {{-- <option value="{{ $item->definisi_operasional }}">{{ $item->definisi_operasional }}
                </option> --}}
                @php $selected = ''; @endphp
                @if ($param != null)
                    @if ($item->definisi_operasional == $param->definisi_operasional)
                        @php $selected = 'selected'; @endphp
                    @endif
                @endif
                <option {{ $selected }} value="{{ $item->definisi_operasional }}">
                    {{ $item->definisi_operasional }}
                </option>
            @endforeach
            <option value="buat_baru">Buat Baru</option>
        </select>
        <input style="display: none" type="text" id="div_definisi_{{ $param != null ? $param->id : $append_data }}"
            name="div_definisi[]" value="{{ @$param->definisi_operasional }}" class="form-control"
            placeholder="Isi Satuan Jumlah">

    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-outline-danger"
            onclick="@if ($param != null) hapusParameter({{ $param->id }}); @else $(this).closest('.row').remove(); @endif"><i
                class="fa fa-times"></i></button>
    </div>
</div>
