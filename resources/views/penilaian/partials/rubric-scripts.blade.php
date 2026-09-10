{{-- Skrip form penilaian juri: tanda tangan wajib, rollup nilai induk live, expand/collapse.
     Dipakai di dalam @section('script') view edit Inovasi & Kovablik.
     Butuh library SignaturePad (UMD) sudah dimuat sebelum blok ini. --}}
<script>
    (function() {
        // ---------- Tanda tangan ----------
        var canvas = document.getElementById('signature-pad');
        var pad = (canvas && window.SignaturePad) ? new SignaturePad(canvas) : null;
        var img = document.getElementById('signature-image');
        var sigInput = document.getElementById('signature_data');
        var form = document.getElementById('form-penilaian');

        var clearBtn = document.getElementById('clear-signature');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (img && img.style.display !== 'none') {
                    img.style.display = 'none';
                    if (canvas) canvas.style.display = 'block';
                }
                if (pad) pad.clear();
                if (sigInput) sigInput.value = '';
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                // Wajib tanda tangan baru setiap simpan.
                if (pad && !pad.isEmpty()) {
                    sigInput.value = pad.toDataURL('image/png');
                    return;
                }
                e.preventDefault();
                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanda tangan wajib',
                        html: 'Silakan bubuhkan tanda tangan terlebih dahulu sebelum menyimpan penilaian.'
                    });
                } else {
                    alert('Tanda tangan wajib diisi sebelum menyimpan penilaian.');
                }
            });
        }

        // ---------- Rollup nilai induk (live) ----------
        function num(v) {
            v = parseFloat(v);
            return isNaN(v) ? 0 : v;
        }

        function round2(v) {
            return Math.round(v * 100) / 100;
        }

        function recompute() {
            var stored = {};

            document.querySelectorAll('.rubric-node[data-leaf="1"]').forEach(function(el) {
                var b = num(el.dataset.bobot);
                var input = el.querySelector('.rubric-input');
                stored[el.dataset.nodeId] = b ? num(input ? input.value : 0) * b / 100 : 0;
            });

            var branches = Array.prototype.slice.call(
                document.querySelectorAll('.rubric-node[data-leaf="0"]')
            ).sort(function(a, b) {
                return num(b.dataset.depth) - num(a.dataset.depth); // terdalam dulu
            });

            branches.forEach(function(el) {
                var b = num(el.dataset.bobot);
                var sum = 0;
                el.querySelectorAll(':scope > .rubric-children > .rubric-node').forEach(function(ch) {
                    sum += stored[ch.dataset.nodeId] || 0;
                });
                stored[el.dataset.nodeId] = b ? sum * b / 100 : 0;
                var out = el.querySelector(':scope > .rubric-row .rubric-rollup');
                if (out) out.textContent = round2(stored[el.dataset.nodeId]);
            });

            var grand = 0;
            document.querySelectorAll('.rubric-node').forEach(function(el) {
                if (!el.dataset.parentId) grand += stored[el.dataset.nodeId] || 0;
            });
            var gt = document.getElementById('grand-total');
            if (gt) gt.textContent = round2(grand);
        }

        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList && e.target.classList.contains('rubric-input')) {
                recompute();
            }
        });
        recompute();

        // ---------- Expand / collapse ----------
        document.querySelectorAll('.rubric-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var node = btn.closest('.rubric-node');
                var kids = node ? node.querySelector(':scope > .rubric-children') : null;
                if (!kids) return;
                kids.classList.toggle('collapsed');
                btn.textContent = kids.classList.contains('collapsed') ? '[+]' : '[−]';
            });
        });
    })();
</script>
