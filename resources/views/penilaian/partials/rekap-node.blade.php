{{-- Render rekursif pohon rubrik untuk rekap/cetak penilaian (show + print).
     Butuh: $nodes (collection node + relasi children), $depth (int), $prefix (string).
     Menghasilkan <tr> dengan kolom: No. | Bagian | Indikator | Catatan & Saran | Nilai --}}
@foreach ($nodes as $node)
    @php
        $children = $node->children ?? collect();
        $isLeaf = $children->isEmpty();
        $num = $prefix . $loop->iteration;
    @endphp
    <tr @unless ($isLeaf) style="background-color:#f1f3f5;font-weight:600;" @endunless>
        <td>{{ $num }}</td>
        <td style="padding-left: {{ $depth * 20 + 8 }}px;">{{ $node->bagian }}</td>
        <td>@if (!is_null($node->indikator)){!! $node->indikator !!}@endif</td>
        <td>{{ optional($node->pivot)->catatan_saran ?: '-' }}</td>
        <td class="text-center">{{ round(optional($node->pivot)->nilai ?? 0, 2) }}</td>
    </tr>
    @unless ($isLeaf)
        @include('penilaian.partials.rekap-node', [
            'nodes' => $children,
            'depth' => $depth + 1,
            'prefix' => $num . '.',
        ])
    @endunless
@endforeach
