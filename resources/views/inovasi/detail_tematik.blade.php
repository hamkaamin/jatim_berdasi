<div class="row my-3" id="detail_tematik_ajax">
    <div class="col-sm-3 d-flex align-items-center"><label><b>Detail Tematik</b> <span
                class="text-danger">*</span></label></div>
    <div class="col-sm-8">
        <select name="detail_tematik_id" id="detail_tematik_id" class="form-control">
            <option value="" selected disabled>-- Pilih Salah Satu --</option>
            @foreach ($detail_tematik as $item)
                <option value="{{ $item->id }}" @if (($data != null && $data->detail_tematik_id == $item->id) || old('detail_tematik_id') == $item->id) selected @endif>
                    {{ $item->nama }}</option>
            @endforeach
        </select>
    </div>
</div>
