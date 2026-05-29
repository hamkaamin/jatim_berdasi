<div class="row gy-3">
    @php $kovablikKategori = $kategori->firstWhere('is_kovablik', true); @endphp

    @if ($inovasi->count() > 0 || $kovablik->count() == 0)
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <x-tab-inovasi :kategori="null" :key="0" :active="1" />
                @foreach ($kategori as $key => $item)
                    <x-tab-inovasi :kategori="$item" :key="$key + 1" :active="0" :count="$item->is_kovablik ? $kovablikCount : $inovasi->where('kategori_id', $item->id)->count()" />
                @endforeach
            </ul>
        </div>
    @endif

    @if ($inovasi->count() > 0 || $kovablik->count() == 0)
        <div class="col-12" id="inovasi-tab-content-area">
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

    @if ($kovablik->count() > 0 && $kovablikKategori)
        @if (Auth::user()->role != 2)
            <div class="col-12" id="kovablik-cards" style="display:none;">
                <div class="row g-4 mb-4">
                    @foreach ($kelompok as $item)
                        <div class="col-3">
                            <div class="card rainbow-card-afu widget-content h-100">
                                <div class="widget-content-wrapper text-white">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">{{ $item->nama }}</div>
                                        <div class="widget-subheading">Kelompok Kovablik<b> {{ $item->nama }}</b>
                                        </div>
                                    </div>
                                    <div class="widget-content-right ms-3">
                                        <div class="widget-numbers text-white">
                                            <span>{{ $kovablik->where('kelompok_id', $item->id)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="col-12 mt-4" id="kovablik-section">
            <h5 class="font-weight-bold">Proposal Kovablik</h5>
            <ul class="nav nav-tabs mb-3" id="myTabKovablik" role="tablist">
                <x-tab-kovablik :kelompok="null" :key="0" :active="1" prefix="kov-tab" />
                @foreach ($kelompok as $key => $item)
                    <x-tab-kovablik :kelompok="$item" :key="$key + 1" :active="0" prefix="kov-tab" />
                @endforeach
            </ul>
            <div class="tab-content" id="myTabKovablikContent">
                <x-tab-content-kovablik :kelompok="null" :active="1" :proposal="$kovablik" :label="$label"
                    :fase="$fase" prefix="kov-tab" />
                @foreach ($kelompok as $item)
                    <x-tab-content-kovablik :kelompok="$item" :active="0" :proposal="$kovablik" :label="$label"
                        :fase="$fase" prefix="kov-tab" />
                @endforeach
            </div>
        </div>
    @endif

    @if ($kovablikKategori)
        <script>
            document.body.addEventListener('click', function(e) {

                const tab = e.target.closest('#myTab a[data-toggle="tab"]');

                if (tab) {
                    let tabId = tab.getAttribute('id');

                    let idKovablik = "{{ $kovablikKategori->id }}-tab";
                    let isKovablik = (tabId === idKovablik);
                    let isAll = (tabId === '0-tab');

                    const kovablikCards = document.getElementById('kovablik-cards');

                    if (isKovablik) {
                        if (kovablikCards) kovablikCards.style.display = 'block';
                        document.getElementById('inovasi-tab-content-area').style.display = 'none';
                        document.getElementById('kovablik-section').style.display = 'block';
                    } else if (isAll) {
                        if (kovablikCards) kovablikCards.style.display = 'none';
                        document.getElementById('inovasi-tab-content-area').style.display = 'block';
                        document.getElementById('kovablik-section').style.display = 'block';
                    } else {
                        if (kovablikCards) kovablikCards.style.display = 'none';
                        document.getElementById('inovasi-tab-content-area').style.display = 'block';
                        document.getElementById('kovablik-section').style.display = 'none';
                    }
                }
            });
        </script>
    @endif
</div>
