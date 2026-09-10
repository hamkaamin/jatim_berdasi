@once
    @push('styles')
        <style>
            .detail-row {
                display: grid;
                grid-template-columns: minmax(150px, 230px) 1fr;
                gap: .2rem 1rem;
                align-items: start;
                padding: .5rem 0;
                border-bottom: 1px solid #f1f1f1;
                overflow-wrap: anywhere;
            }

            .detail-row>.detail-label {
                font-weight: 600;
            }

            .detail-row ul {
                margin: 0;
                padding-left: 1.1rem;
            }

            .detail-row img {
                max-width: 100%;
                height: auto;
            }

            .detail-body.is-narrow .detail-row,
            .split-pane.is-narrow .detail-row {
                grid-template-columns: 1fr;
            }

            @container (max-width: 520px) {
                .detail-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush
@endonce
