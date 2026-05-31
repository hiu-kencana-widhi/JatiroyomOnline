@if(session()->has('success') || session()->has('play_sound'))
    <!-- Success Audio Feedback -->
    <audio id="globalAppSound" src="{{ asset('sound/sound-jatiroyomonline.mp3') }}" preload="auto" autoplay style="display: none;"></audio>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const soundEl = document.getElementById('globalAppSound');
            if (soundEl) {
                soundEl.volume = 0.8;
                soundEl.currentTime = 0;
                const playPromise = soundEl.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        // In case of browser autoplay policies, handle silently
                    });
                }
            }
        });
    </script>
@endif

<!-- Permanent Tamper-Proof Watermark Guardian -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function verifyHiuWatermark() {
            let wmClass = document.querySelector('.watermark-hiu');
            let hasText = false;
            document.querySelectorAll('footer').forEach(f => {
                if (f.textContent.includes('ByHiu')) hasText = true;
            });
            
            if (!wmClass && !hasText) {
                let persistentWm = document.getElementById('hiuPermanentGuardian');
                if (!persistentWm) {
                    persistentWm = document.createElement('div');
                    persistentWm.id = 'hiuPermanentGuardian';
                    persistentWm.className = 'watermark-hiu';
                    persistentWm.innerHTML = 'ByHiu';
                    persistentWm.style.cssText = 'position: fixed !important; bottom: 10px !important; right: 15px !important; z-index: 2147483647 !important; background: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(4px) !important; padding: 3px 8px !important; border-radius: 8px !important; font-weight: 800 !important; font-size: 11px !important; color: #2563eb !important; border: 1px solid rgba(37, 99, 235, 0.2) !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important; pointer-events: none !important; user-select: none !important; letter-spacing: 0.5px !important;';
                    document.body.appendChild(persistentWm);
                }
            }
        }

        verifyHiuWatermark();

        // Mutator guardian to prevent user deletion via element inspector or template rewrite
        if (window.MutationObserver) {
            const observer = new MutationObserver(function(mutations) {
                let persistentWm = document.getElementById('hiuPermanentGuardian');
                let wmClass = document.querySelector('.watermark-hiu');
                let hasText = false;
                document.querySelectorAll('footer').forEach(f => {
                    if (f.textContent.includes('ByHiu')) hasText = true;
                });

                if (!wmClass && !hasText && !persistentWm) {
                    verifyHiuWatermark();
                } else if (persistentWm && !document.body.contains(persistentWm)) {
                    document.body.appendChild(persistentWm);
                }
            });
            observer.observe(document.body, { childList: true, subtree: true, characterData: true });
        }
    });
</script>
