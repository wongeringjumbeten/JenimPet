/**
 * HUJAN HAMSTER 🐹🌧️
 * Kode ini akan jalan otomatis saat halaman dimuat
 */

(function() {
    // Koleksi hamster yang lucu
    const hamsters = ['🐹', '🐭', '🐹', '🐹', '🐭', '🐹✨', '⭐🐹', '🐹💨', '🐹🌟', '🐹⚡'];

    const container = document.getElementById('hamster-rain-container');

    if (!container) {
        console.warn('Container #hamster-rain-container tidak ditemukan');
        return;
    }

    function createHamster() {
        const hamster = document.createElement('div');
        hamster.className = 'hamster-rain-item';

        // Random hamster emoji
        hamster.innerHTML = hamsters[Math.floor(Math.random() * hamsters.length)];

        // Random position & size & speed
        const left = Math.random() * 100;
        const size = 20 + Math.random() * 25;
        const duration = 3 + Math.random() * 6;
        const delay = Math.random() * 8;

        hamster.style.left = left + '%';
        hamster.style.fontSize = size + 'px';
        hamster.style.animationDuration = duration + 's';
        hamster.style.animationDelay = delay + 's';

        container.appendChild(hamster);

        // Hapus setelah animasi selesai
        setTimeout(() => {
            if (hamster && hamster.remove) {
                hamster.remove();
            }
        }, (duration + delay) * 1000);
    }

    // Buat hamster setiap 0.8 detik
    let interval = setInterval(() => {
        createHamster();
    }, 800);

    // Initial burst: 15 hamster langsung saat halaman load
    for(let i = 0; i < 15; i++) {
        setTimeout(() => createHamster(), i * 150);
    }

    // Cleanup interval jika halaman di-unload (opsional, untuk SPA)
    if (typeof window !== 'undefined') {
        window.addEventListener('beforeunload', () => {
            if (interval) clearInterval(interval);
        });
    }
})();

// Tambahan: efek console.log keren untuk dev
console.log('%c🐹 HUJAN HAMSTER AKTIF! 🐹', 'color: #D4A574; font-size: 16px; font-weight: bold;');
console.log('%cSelamat datang di Jenim Hamster Farm!', 'color: #6B5847; font-size: 14px;');
