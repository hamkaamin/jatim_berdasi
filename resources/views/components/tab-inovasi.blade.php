<li class="nav-item tab-animate-afu overflow-hidden" role="presentation">
    <a style="background-color:white;" class="nav-link position-relative {{ $active == 1 ? 'active' : '' }}"
        id="{{ $kategori == null ? 0 : $kategori->id }}-tab" data-toggle="tab"
        href="#tab-{{ $kategori == null ? 0 : $kategori->id }}" role="tab"
        aria-controls="tab-{{ $kategori == null ? 0 : $kategori->id }}" {{ $active == 1 ? "aria-selected='true'" : '' }}>
        <div class="z-10 animate position-absolute d-flex justify-content-center align-items-center">
            <div class="kotak" style="background-color: {{ $bgColor }};"></div>
        </div>
        <span class="z-20 position-relative">
            {{ $kategori == null ? 'Semua' : ucwords($kategori->nama) }}
        </span>
    </a>
</li>
