@if ($type == 'row')
    <div class="row my-2" id="pengguna-kategori">
        <div class="col-sm-4 d-flex align-items-center">
            <label>{{ $label }}</label>
        </div>
        <div class="col-sm-8">
        @else
            <div class="col" id="pengguna-kategori">
                <label>{{ $label }}</label>
@endif
<ul class="list-unstyled mb-0">
    @foreach ($kategori as $item)
        <li>
            <input type="checkbox" name="{{ 'is_kategori_' . $item->id }}" id="{{ 'is_kategori_' . $item->id }}"
                {{ isset($data) && ($data->{'is_kategori_' . $item->id} ?? false) ? 'checked' : '' }}>
            <label for="{{ 'is_kategori_' . $item->id }}">{{ $item->nama }}</label>
        </li>
    @endforeach
</ul>
@if ($type == 'row')
    </div>
    </div>
@else
    </div>
@endif
