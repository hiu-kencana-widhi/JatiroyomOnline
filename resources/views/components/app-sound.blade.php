@if(session()->has('success') || session()->has('play_sound'))
    <!-- Success Audio Feedback -->
    <audio id="globalAppSound" src="{{ asset('sound/sound.mp3') }}" preload="auto" autoplay style="display: none;"></audio>
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
