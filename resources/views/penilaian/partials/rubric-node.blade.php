{{-- Render rekursif satu tingkat pohon rubrik pada form penilaian juri.
     Dipakai oleh Inovasi (penilaian/edit) maupun Kovablik (penilaian-kovablik/edit).
     Butuh: $nodes (collection node + relasi children), $depth (int), $prefix (string). --}}
@foreach ($nodes as $node)
    @php
        $children = $node->children ?? collect();
        $isLeaf = $children->isEmpty();
        $num = $prefix . $loop->iteration;
        $bobot = (int) $node->bobot_nilai;
        $raw = $bobot ? round((optional($node->pivot)->nilai ?? 0) / ($bobot / 100), 2) : 0;
        $rollup = round(optional($node->pivot)->nilai ?? 0, 2);
    @endphp
    <div class="rubric-node {{ $isLeaf ? 'rubric-leaf' : 'rubric-branch' }}" data-node-id="{{ $node->id }}"
        data-parent-id="{{ $node->parent_id ?? '' }}" data-bobot="{{ $bobot }}" data-leaf="{{ $isLeaf ? 1 : 0 }}"
        data-depth="{{ $depth }}">
        <div class="rubric-row">
            <div class="rubric-label">
                @unless ($isLeaf)
                    <button type="button" class="btn btn-sm btn-link p-0 me-1 rubric-toggle">[&minus;]</button>
                @endunless
                <b>{{ $num }}</b> {{ $node->bagian }}
                <small class="text-muted">({{ $bobot }}%)</small>
                @if (!is_null($node->indikator))
                    <div class="small text-muted">{!! $node->indikator !!}</div>
                @endif
            </div>

            @if ($isLeaf)
                <div>
                    <input type="number" step="any" class="form-control form-control-sm rubric-input"
                        min="{{ $node->nilai_min }}" max="{{ $node->nilai_max }}" name="nilai_{{ $node->id }}"
                        data-node-id="{{ $node->id }}" value="{{ $raw }}">
                    <input type="hidden" name="bobot_nilai_{{ $node->id }}" value="{{ $bobot }}">
                    <small class="text-muted">{{ $node->nilai_min }}&ndash;{{ $node->nilai_max }}</small>
                </div>
                <input type="text" class="form-control form-control-sm rubric-note" name="keterangan_{{ $node->id }}"
                    value="{{ optional($node->pivot)->catatan_saran }}" placeholder="Catatan / saran (opsional)">
            @else
                <div class="text-end fw-bold rubric-rollup" data-rollup-for="{{ $node->id }}">{{ $rollup }}</div>
                <div></div>
            @endif
        </div>

        @unless ($isLeaf)
            <div class="rubric-children">
                @include('penilaian.partials.rubric-node', [
                    'nodes' => $children,
                    'depth' => $depth + 1,
                    'prefix' => $num . '.',
                ])
            </div>
        @endunless
    </div>
@endforeach
