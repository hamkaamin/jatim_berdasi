@foreach ($data as $item)
    <div class="col-6 d-flex align-items-center">
        <input type="radio" id="tahapan_{{ $item->id }}" value="{{ $item->id }}" name="tahapan_id"
            @if (old('tahapan_id') == $item->id ||
                    ($data == null && $loop->iteration == 1) ||
                    ($data != null && $data->tahapan_id == $item->id)) checked @endif><label class="pb-0 mb-0 ml-2"
            for="tahapan_{{ $item->id }}">{{ $item->nama }}</label>
    </div>
@endforeach
