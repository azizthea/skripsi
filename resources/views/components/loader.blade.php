<!-- Premium Page Loader -->
<script>
    // Deteksi Instan SEBELUM Render (Mencegah Flash)
    (function() {
        const isFirstVisit = !sessionStorage.getItem('loaderShown');
        const isRefresh = (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType("navigation")[0]?.type === 'reload');
        
        if (!isFirstVisit && !isRefresh) {
            // Jika bukan kunjungan pertama & bukan refresh, suntikkan CSS untuk menyembunyikan loader secara instan
            document.write('<style id="loader-hide-style">#page-loader { display: none !important; }</style>');
        } else {
            // Lock body scroll to prevent page shifting/scrolling on mobile safely without viewport break
            document.write('<style id="loader-scroll-lock">html, body { overflow: hidden !important; height: 100% !important; height: 100vh !important; height: 100dvh !important; }</style>');
        }
    })();
</script>

<div id="page-loader" class="fixed inset-0 w-full h-full min-h-screen h-[100dvh] w-screen z-[9999] flex flex-col items-center justify-center bg-[#044E37] transition-opacity duration-700 ease-in-out">
    
    <!-- Ornamen Pola Islam Samar di Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
        <svg width="100%" height="100%"><defs><pattern id="loader-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
            <path d="M50 0L100 50L50 100L0 50Z" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
            <rect width="100%" height="100%" fill="url(#loader-pattern)"/></svg>
    </div>

    <!-- Logo Container with Pulse Effect -->
    <div class="relative flex flex-col items-center justify-center">
        <!-- Glow Effect behind Logo -->
        <div class="absolute w-40 h-40 bg-[#C4D01D]/20 rounded-full blur-3xl animate-pulse"></div>
        
        <div class="relative bg-white p-5 rounded-full shadow-[0_0_50px_rgba(196,208,29,0.3)] animate-[pulseLogo_2s_ease-in-out_infinite] flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14 md:w-20 md:h-20 object-contain">
        </div>
    </div>

    <!-- Loading Text -->
    <div class="mt-8 flex flex-col items-center px-4 w-full max-w-[280px] md:max-w-xs">
        <span class="text-white font-bold tracking-[0.3em] uppercase text-xs md:text-sm mb-3">Al-Furqoniyah</span>
        <div class="w-full h-[3px] bg-white/10 rounded-full overflow-hidden">
            <div id="loader-progress" class="h-full bg-[#C4D01D] w-0 transition-all duration-300"></div>
        </div>
    </div>

    <style>
        @keyframes pulseLogo {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        
        .loader-hide {
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('page-loader');
            const progress = document.getElementById('loader-progress');
            
            // Logika Deteksi: Sesi Pertama atau Refresh
            const isFirstVisit = !sessionStorage.getItem('loaderShown');
            const isRefresh = (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType("navigation")[0]?.type === 'reload');

            if (isFirstVisit || isRefresh) {
                // Tampilkan Animasi Loader
                sessionStorage.setItem('loaderShown', 'true');
                
                let width = 0;
                const interval = setInterval(() => {
                    if (width >= 90) {
                        clearInterval(interval);
                    } else {
                        width += Math.random() * 15;
                        if(progress) progress.style.width = width + '%';
                    }
                }, 100);

                window.addEventListener('load', () => {
                    if(progress) progress.style.width = '100%';
                    setTimeout(() => {
                        if(loader) {
                            loader.classList.add('loader-hide');
                            setTimeout(() => {
                                loader.style.display = 'none';
                            }, 700); // Tunggu sampai transisi opacity selesai
                        }
                        
                        // Kembalikan scroll body dengan menghapus tag style lock
                        const scrollLockStyle = document.getElementById('loader-scroll-lock');
                        if (scrollLockStyle) {
                            scrollLockStyle.remove();
                        }
                    }, 400);
                });
            } else {
                // Jika hanya navigasi biasa, langsung hilangkan loader tanpa animasi
                if(loader) loader.style.display = 'none';
                const scrollLockStyle = document.getElementById('loader-scroll-lock');
                if (scrollLockStyle) {
                    scrollLockStyle.remove();
                }
            }
        });
    </script>
</div>
