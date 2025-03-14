@php
$status_label = 0; @endphp
@if ($label == 'Awards')
    @php $status_label = '1'; @endphp
@endif
<div class="row">
    @if (Auth::user()->role != 2)
        <div class="col-12">
            <div class="row g-4 mb-4">
                @foreach ($kelompok as $item)
                    <div class="col-3">
                        <div class="card rainbow-card-afu widget-content h-100">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">{{ $item->nama }}</div>
                                    <div class="widget-subheading">Kelompok Kovablik<b> {{ $item->nama }}</b></div>
                                </div>
                                <div class="widget-content-right ms-3">
                                    <div class="widget-numbers text-white">
                                        <span>
                                            @php
                                                $propos = $item->hasManyKovablik();
                                                if (
                                                    Auth::user()->role == 3 ||
                                                    Helper::checkUserUmum('provinsi', Auth::user())
                                                ) {
                                                    $propos = $propos->where('provinsi_id', Auth::user()->province_id);
                                                } elseif (
                                                    Auth::user()->role == 4 ||
                                                    Helper::checkUserUmum('kota', Auth::user())
                                                ) {
                                                    $propos = $propos
                                                        ->where('user_id', Auth::user()->id)
                                                        ->where('label', $status_label)
                                                        ->where('tahun', Auth::user()->tahun)
                                                        ->get();
                                                } elseif (Auth::user()->role == 5) {
                                                    $propos = $propos
                                                        ->where('kota_id', Auth::user()->opd->kabkota_id)
                                                        ->where('user_id', Auth::user()->id)
                                                        ->where('label', $status_label)
                                                        ->where('tahun', Auth::user()->tahun);
                                                } elseif (
                                                    Helper::checkOpd('kecamatan', Auth::user()) ||
                                                    Helper::checkUserUmum('opd-kecamatan', Auth::user())
                                                ) {
                                                    $propos = $propos->where(
                                                        'kecamatan_id',
                                                        Auth::user()->opd->kecamatan_id,
                                                    );
                                                } elseif (
                                                    Helper::checkOpd('kelurahan', Auth::user()) ||
                                                    Helper::checkUserUmum('opd-kelurahan', Auth::user())
                                                ) {
                                                    $propos = $propos->where(
                                                        'kelurahan_id',
                                                        Auth::user()->opd->kelurahan_id,
                                                    );
                                                }
                                            @endphp
                                            {{ $propos->count() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <x-tab-kovablik :kategori="null" :key="0" :active="1" />
            @foreach ($kategori as $key => $item)
                <x-tab-kovablik :kategori="$item" :key="$key + 1" :active="0" />
            @endforeach
        </ul>

        <div class="tab-content" id="myTabContent">
            <x-tab-content-kovablik :kategori="null" :active="1" :proposal="$proposal" :label="$label"
                :fase="$fase" />
            @foreach ($kategori as $item)
                <x-tab-content-kovablik :kategori="$item" :active="0" :proposal="[]" :label="$label"
                    :fase="$fase" />
            @endforeach
        </div>
    </div>
</div>
