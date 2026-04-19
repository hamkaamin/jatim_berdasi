<div class="row">
    @if (Auth::user()->role != 2)
        <div class="col-12">
            <div class="row g-4 mb-4">
                @foreach ($kategori as $item)
                    <div class="col-3">
                        <div class="card rainbow-card-afu widget-content h-100">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">{{ $item->nama }}</div>
                                    <div class="widget-subheading">Inovasi Kategori <b>{{ $item->nama }}</b></div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white">
                                        <span>{{ $item->is_kovablik ? $kovablikCount : $item->has_many_inovasi_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if ($inovasi->count() > 0 || $kovablik->count() == 0)
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <x-tab-inovasi :kategori="null" :key="0" :active="1" />
            @foreach ($kategori as $key => $item)
                <x-tab-inovasi :kategori="$item" :key="$key + 1" :active="0" />
            @endforeach
        </ul>

        <div class="tab-content" id="myTabContent">
            <x-tab-content-inovasi :kategori="null" :active="1" :inovasi="$inovasi" :label="$label"
                :fase="$fase" :area="$area" />
            @foreach ($kategori as $item)
                <x-tab-content-inovasi :kategori="$item" :active="0" :inovasi="[]" :label="$label"
                    :fase="$fase" :area="$area" />
            @endforeach
        </div>
    </div>
    @endif

    @if ($kovablik->count() > 0)
    <div class="col-12 mt-4">
        <h5 class="font-weight-bold">Proposal Kovablik</h5>
        <ul class="nav nav-tabs" id="myTabKovablik" role="tablist">
            <x-tab-kovablik :kelompok="null" :key="0" :active="1" prefix="kov-tab" />
            @foreach ($kelompok as $key => $item)
                <x-tab-kovablik :kelompok="$item" :key="$key + 1" :active="0" prefix="kov-tab" />
            @endforeach
        </ul>
        <div class="tab-content" id="myTabKovablikContent">
            <x-tab-content-kovablik :kelompok="null" :active="1" :proposal="$kovablik" :label="$label"
                :fase="$fase" prefix="kov-tab" />
            @foreach ($kelompok as $item)
                <x-tab-content-kovablik :kelompok="$item" :active="0" :proposal="[]" :label="$label"
                    :fase="$fase" prefix="kov-tab" />
            @endforeach
        </div>
    </div>
    @endif
</div>
