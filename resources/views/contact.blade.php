<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Al-Furqoniyah</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite + Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        #cursor-dot {
            width: 32px;
            height: 32px;
            background-color: rgba(196, 208, 29, 0.15);
            border: 2px solid rgba(196, 208, 29, 0.8);
            border-radius: 50%;
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: width 0.2s, height 0.2s, background-color 0.2s;
        }
        
        @media (max-width: 768px) {
            #cursor-dot { display: none; }
        }

        /* Arch Image */
        .arch-image-container {
            border-top-left-radius: 1000px;
            border-top-right-radius: 1000px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="bg-white antialiased overflow-x-hidden">
    <x-loader />
    <div id="cursor-dot"></div>

    <x-navbar />

    <!-- CONNECTED HEADER SECTION -->
    <div class="relative">
        <div class="relative pt-32 pb-16 md:pt-48 md:pb-24" style="background:linear-gradient(160deg,#044E37 0%,#033d2b 50%,#044E37 100%);">
            
            <!-- Pattern -->
            <div class="absolute inset-0 pointer-events-none z-0 opacity-[0.06]" aria-hidden="true">
                <svg width="100%" height="100%"><defs><pattern id="geo-contact" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M40 0L80 40L40 80L0 40Z" fill="none" stroke="#C4D01D" stroke-width="0.8"/>
                    <circle cx="40" cy="40" r="5" fill="none" stroke="#C4D01D" stroke-width="0.6"/>
                </pattern></defs><rect width="100%" height="100%" fill="url(#geo-contact)"/></svg>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-12">
                <div class="lg:w-1/2 text-center md:text-left">
                    <h1 class="text-4xl md:text-7xl font-black text-white mb-4 tracking-tighter leading-none">Contact Us</h1>
                    <div class="h-1 w-16 bg-[#C4D01D] mb-6 mx-auto md:mx-0"></div>
                    <p class="text-white/60 text-sm md:text-lg max-w-md mx-auto md:mx-0 leading-relaxed">
                        Kami selalu terbuka untuk berdiskusi. Kirimkan pesan atau kunjungi kami langsung di pesantren.
                    </p>
                </div>
            </div>

            <!-- Wave Divider -->
            <div class="absolute bottom-0 left-0 w-full leading-[0] z-10">
                <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-[40px] md:h-[100px] block">
                    <path d="M0,64 C480,128 960,0 1440,64 L1440,120 L0,120 Z" fill="white"/>
                </svg>
            </div>
        </div>

        <!-- Arched Image (Desktop Only) -->
        <div class="absolute top-44 right-20 xl:right-32 hidden lg:block z-30">
            <div class="arch-image-container w-[350px] h-[520px] border-[12px] border-white">
                <img src="{{ asset('images/slider 2.png') }}" alt="Contact Detail" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- CONTENT SECTION -->
    <section class="relative bg-white pb-20 z-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start mb-16 md:mb-24">
                
                <!-- LEFT COLUMN -->
                <div class="flex flex-col">
                    <!-- FORM -->
                    <div class="bg-[#1a2e25] rounded-[2.5rem] md:rounded-[3rem] p-8 md:p-14 shadow-2xl mt-[-40px] md:mt-[-60px] relative z-40 border-4 md:border-8 border-white mb-12">
                        <h2 class="text-2xl md:text-3xl font-black text-white mb-3">Hubungi Kami !</h2>
                        <p class="text-white/50 mb-8 text-xs md:text-sm">Silakan isi formulir di bawah untuk bantuan lebih lanjut.</p>
                        
                        <form action="#" class="space-y-4 md:space-y-6">
                            <input type="email" placeholder="Email" class="w-full bg-white/5 border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:px-6 md:py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#C4D01D]/50 placeholder:text-white/20 transition-all text-sm md:text-base">
                            <input type="text" placeholder="Name" class="w-full bg-white/5 border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:px-6 md:py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#C4D01D]/50 placeholder:text-white/20 transition-all text-sm md:text-base">
                            <textarea rows="4" placeholder="Message" class="w-full bg-white/5 border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:px-6 md:py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#C4D01D]/50 placeholder:text-white/20 transition-all text-sm md:text-base"></textarea>
                            <button type="submit" class="w-full md:w-auto bg-[#C4D01D] text-[#044E37] px-8 py-3 md:px-10 md:py-4 rounded-xl md:rounded-2xl font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg text-sm md:text-base">Submit</button>
                        </form>
                    </div>

                    <!-- OUR LOCATION TEXT -->
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl md:text-4xl font-black text-[#044E37] mb-3">lokasi kami</h2>
                        <p class="text-gray-500 text-sm md:text-lg leading-relaxed">Peta rute menuju Pondok Pesantren Al-Furqoniyah Cigombong.</p>
                        
                        <!-- Socials on Mobile -->
                        <div class="mt-6 flex justify-center md:justify-start gap-3">
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gray-100 flex items-center justify-center text-[#044E37] hover:bg-[#044E37] hover:text-white transition-all"><svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/></svg></a>
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gray-100 flex items-center justify-center text-[#044E37] hover:bg-[#044E37] hover:text-white transition-all"><svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg></a>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="flex flex-col pt-0 lg:pt-[420px]">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4 md:gap-6">
                        <!-- Phone -->
                        <div class="flex items-center gap-4 md:gap-6 p-5 md:p-6 bg-gray-50 rounded-[1.5rem] md:rounded-[2rem] group hover:bg-[#044E37] transition-all duration-300 shadow-sm border border-gray-100">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-xl md:rounded-2xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#C4D01D] transition-colors">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-[#044E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Phone</p>
                                <h4 class="text-sm md:text-lg font-black text-[#044E37] group-hover:text-white transition-colors leading-tight">(+62) 266 6249758</h4>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center gap-4 md:gap-6 p-5 md:p-6 bg-gray-50 rounded-[1.5rem] md:rounded-[2rem] group hover:bg-[#044E37] transition-all duration-300 shadow-sm border border-gray-100">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-xl md:rounded-2xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#C4D01D] transition-colors">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-[#044E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</p>
                                <h4 class="text-sm md:text-lg font-black text-[#044E37] group-hover:text-white transition-colors leading-tight">info@ktchn.com</h4>
                            </div>
                        </div>

                        <!-- Office -->
                        <div class="flex items-center gap-4 md:gap-6 p-5 md:p-6 bg-gray-50 rounded-[1.5rem] md:rounded-[2rem] group hover:bg-[#044E37] transition-all duration-300 shadow-sm border border-gray-100 md:col-span-2 lg:col-span-1">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-xl md:rounded-2xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#C4D01D] transition-colors">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-[#044E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Office</p>
                                <h4 class="text-sm md:text-lg font-black text-[#044E37] group-hover:text-white transition-colors leading-tight">Cigombong, Bogor</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAP SECTION -->
            <div class="w-full relative">
                <div class="w-full h-[350px] md:h-[500px] rounded-[2rem] md:rounded-[4rem] overflow-hidden shadow-xl border-[8px] md:border-[16px] border-gray-50 group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.668581635338!2d106.8118073!3d-6.7346808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ca30f8c3222d%3A0xc3191122a0139b5a!2sPondok%20Pesantren%20Al-Furqoniyah!5e0!3m2!1sid!2sid!4v1715610000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" class="grayscale hover:grayscale-0 transition-all duration-1000"></iframe>
                </div>
                
                <!-- Badge -->
                <div class="absolute top-6 right-6 md:top-10 md:right-10 bg-white/90 backdrop-blur-md p-4 md:p-6 rounded-2xl md:rounded-3xl shadow-xl border border-white hidden sm:block">
                    <p class="text-[#044E37] font-bold text-[10px] md:text-sm mb-1">Koordinat Pesantren</p>
                    <p class="text-gray-500 text-[8px] md:text-xs">Akses mudah via Tol Bocimi</p>
                </div>
            </div>

        </div>
    </section>


    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('main-nav');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            // Scroll effect for navbar
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    nav?.classList.remove('bg-transparent');
                    nav?.classList.add('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    nav?.classList.add('bg-transparent');
                    nav?.classList.remove('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                }
            });

            // Mobile menu logic
            if (mobileMenuBtn && mobileMenu && closeMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.remove('translate-x-full');
                });

                closeMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.add('translate-x-full');
                });
            }

            // Cursor follower
            const cursorDot = document.getElementById('cursor-dot');
            let mouseX = 0, mouseY = 0, dotX = 0, dotY = 0;
            window.addEventListener('mousemove', (e) => { mouseX = e.clientX; mouseY = e.clientY; });
            function animateDot() {
                dotX += (mouseX - dotX) * 0.15; dotY += (mouseY - dotY) * 0.15;
                if(cursorDot) { cursorDot.style.left = dotX + 'px'; cursorDot.style.top = dotY + 'px'; }
                requestAnimationFrame(animateDot);
            }
            animateDot();
        });
    </script>
</body>
</html>
