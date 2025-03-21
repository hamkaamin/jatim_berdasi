<li class="nav-item tab-animate-afu overflow-hidden" role="presentation">
    <a style="background-color:white;" class="nav-link position-relative {{ $active == 1 ? 'active' : '' }}"
        id="{{ $kelompok == null ? 0 : $kelompok->id }}-tab" data-toggle="tab"
        href="#tab-{{ $kelompok == null ? 0 : $kelompok->id }}" role="tab"
        aria-controls="tab-{{ $kelompok == null ? 0 : $kelompok->id }}" {{ $active == 1 ? "aria-selected='true'" : '' }}>
        <div class="z-10 animate position-absolute d-flex justify-content-center align-items-center">
            <div class="kotak" style="background-color: {{ $bgColor }};"></div>
        </div>
        <span class="z-20 position-relative">
            {{ $kelompok == null ? 'Semua' : ucwords($kelompok->nama) }}
        </span>
    </a>
</li>