<li class="nav-item" role="presentation">
    <a style="background-color: {{ $bgColor }};" class="nav-link {{ $active == 1 ? 'active' : '' }}"
        id="{{ $kategori == null ? 0 : $kategori->id }}-tab" data-toggle="tab"
        href="#tab-{{ $kategori == null ? 0 : $kategori->id }}" role="tab"
        aria-controls="tab-{{ $kategori == null ? 0 : $kategori->id }}"
        {{ $active == 1 ? "aria-selected='true'" : '' }}>{{ $kategori == null ? 'Semua' : ucwords($kategori->nama) }}
    </a>
</li>
