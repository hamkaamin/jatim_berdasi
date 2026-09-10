{{-- CSS + JS untuk layout dua panel yang bisa digeser pada form penilaian juri.
     Di-@include sekali oleh view edit Inovasi maupun Kovablik. --}}
@include('partials.detail-styles')

@once
    @push('styles')
        <style>
            .split-container {
                display: flex;
                align-items: stretch;
                width: 100%;
                height: calc(100vh - 280px);
                min-height: 520px;
                border: 1px solid #dee2e6;
                border-radius: .375rem;
                overflow: hidden;
            }

            .split-pane {
                height: 100%;
                overflow: auto;
                overscroll-behavior-y: contain;
                container-type: inline-size;
                padding: .85rem 1rem;
                min-width: 0;
                scrollbar-width: thin;
            }

            .split-pane::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            .split-pane::-webkit-scrollbar-track {
                background: #f8f9fa;
            }

            .split-pane::-webkit-scrollbar-thumb {
                background: #ced4da;
                border-radius: 4px;
            }

            .split-pane::-webkit-scrollbar-thumb:hover {
                background: #adb5bd;
            }

            .split-left {
                flex: 0 0 50%;
            }

            .split-right {
                flex: 1 1 auto;
                border-left: 1px solid #dee2e6;
            }

            .split-gutter {
                flex: 0 0 8px;
                cursor: col-resize;
                background: #e9ecef;
                border-inline: 1px solid #dee2e6;
            }

            .split-gutter:hover {
                background: #ced4da;
            }

            .rubric-row {
                display: grid;
                grid-template-columns: 1fr minmax(90px, 150px) minmax(140px, 1fr);
                gap: .4rem;
                align-items: start;
                padding: .4rem .25rem;
            }

            .rubric-branch>.rubric-row {
                background: #f8f9fa;
                font-weight: 600;
                border-radius: .25rem;
            }

            .rubric-children {
                margin-left: 18px;
                border-left: 2px solid #e9ecef;
                padding-left: 10px;
            }

            .rubric-children.collapsed {
                display: none;
            }

            .rubric-toggle {
                min-width: 1.6rem;
            }

            .rubric-rollup {
                font-variant-numeric: tabular-nums;
            }

            .split-pane.is-narrow .rubric-row {
                grid-template-columns: 1fr;
            }

            @container (max-width: 520px) {
                .rubric-row {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 991.98px) {
                .split-container {
                    flex-direction: column;
                    height: auto;
                    min-height: 0;
                }

                .split-left,
                .split-right {
                    flex: 1 1 auto;
                    width: 100%;
                    max-height: 55vh;
                    overflow-y: auto;
                    overscroll-behavior-y: contain;
                }

                .split-right {
                    border-left: 0;
                    border-top: 1px solid #dee2e6;
                }

                .split-gutter {
                    display: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.querySelectorAll('.split-container').forEach(function(c) {
                var left = c.querySelector('.split-left'),
                    gutter = c.querySelector('.split-gutter'),
                    panes = c.querySelectorAll('.split-pane'),
                    key = 'splitpane:' + (c.dataset.storageKey || 'default');

                try {
                    var saved = localStorage.getItem(key);
                    if (saved) left.style.flexBasis = saved;
                } catch (e) {}

                function markNarrow() {
                    panes.forEach(function(p) {
                        p.classList.toggle('is-narrow', p.clientWidth < 520);
                    });
                }
                markNarrow();
                window.addEventListener('resize', markNarrow);

                if (!gutter) return;
                var drag = false;
                gutter.addEventListener('mousedown', function(e) {
                    drag = true;
                    e.preventDefault();
                    document.body.style.userSelect = 'none';
                });
                window.addEventListener('mousemove', function(e) {
                    if (!drag) return;
                    var r = c.getBoundingClientRect(),
                        min = r.width / 4,
                        max = r.width * 3 / 4,
                        px = Math.min(max, Math.max(min, e.clientX - r.left));
                    left.style.flexBasis = px + 'px';
                    markNarrow();
                });
                window.addEventListener('mouseup', function() {
                    if (!drag) return;
                    drag = false;
                    document.body.style.userSelect = '';
                    try {
                        localStorage.setItem(key, left.style.flexBasis);
                    } catch (e) {}
                });
            });
        </script>
    @endpush
@endonce
