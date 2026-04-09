@php
$status_label = 0; @endphp
@if ($label == 'Awards')
    @php $status_label = '1'; @endphp
@endif
<div class="row">
    @if (Auth::user()->role != 2)
        <div class="col-12">
            <div class="row">
                @foreach ($kategori as $item)
                    <div class="col-3 mb-3">
                        <div class="card widget-content"
                            style="height:100%; background-color:{{ Arr::random(['#5b73e8', '#34c38f', '#50a5f1', '#f1b44c', '#f46a6a']) }};">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">{{ $item->nama }}</div>
                                    <div class="widget-subheading">Inovasi Kategori <b>{{ $item->nama }}</b></div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white">
                                        <span>
                                            @php
                                                $inov = $item->hasManyInovasi();
                                                if (
                                                    Auth::user()->role == 3 ||
                                                    Helper::checkUserUmum('provinsi', Auth::user())
                                                ) {
                                                    $inov = $inov->where('provinsi_id', Auth::user()->province_id);
                                                } elseif (
                                                    Auth::user()->role == 4 ||
                                                    Helper::checkUserUmum('kota', Auth::user())
                                                ) {
                                                    $inov = $inov
                                                        ->where('user_id', Auth::user()->id)
                                                        ->where('label', $status_label)
                                                        ->where('tahun', Auth::user()->tahun)
                                                        ->get();
                                                } elseif (Auth::user()->role == 5) {
                                                    $inov = $inov
                                                        ->where('kota_id', Auth::user()->opd->kabkota_id)
                                                        ->where('user_id', Auth::user()->id)
                                                        ->where('tahun', Auth::user()->tahun)
                                                        ->where('label', $status_label);
                                                } elseif (
                                                    Helper::checkOpd('kecamatan', Auth::user()) ||
                                                    Helper::checkUserUmum('opd-kecamatan', Auth::user())
                                                ) {
                                                    $inov = $inov
                                                        ->where('kecamatan_id', Auth::user()->opd->kecamatan_id)
                                                        ->where('tahun', Auth::user()->tahun);
                                                } elseif (
                                                    Helper::checkOpd('kelurahan', Auth::user()) ||
                                                    Helper::checkUserUmum('opd-kelurahan', Auth::user())
                                                ) {
                                                    $inov = $inov->where(
                                                        'kelurahan_id',
                                                        Auth::user()->opd->kelurahan_id,
                                                    );
                                                }
                                            @endphp
                                            {{ $inov->count() }}
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
            <x-tab-inovasi :kategori="null" :active="1" />
            @foreach ($kategori as $item)
                <x-tab-inovasi :kategori="$item" :active="0" />
            @endforeach
        </ul>

        <div class="tab-content" id="myTabContent">
            <x-tab-content-inovasi :kategori="null" :active="1" :inovasi="$inovasi" :label="$label"
                :fase="$fase" />
            @foreach ($kategori as $item)
                <x-tab-content-inovasi :kategori="$item" :active="0" :inovasi="[]" :label="$label"
                    :fase="$fase" />
            @endforeach
        </div>
    </div>
</div>
