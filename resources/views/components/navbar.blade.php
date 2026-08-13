<!-- Header / Navbar (Detailed Original Style) -->
    <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent">
        
        <!-- Absolute Logo Pill - Touching the exact top viewport edge ('menyatu dengan browser') -->
        <div class="absolute top-0 left-4 sm:left-8 lg:left-20 xl:left-32 z-30">
            <!-- Pure white background naturally makes the logo's white artifact disappear flawlessly -->
            <div class="bg-white pt-2 lg:pt-3 pb-4 lg:pb-5 px-1.5 rounded-b-[30px] md:rounded-b-[40px] shadow-[0_10px_20px_rgba(0,0,0,0.3)] flex items-center justify-center w-20 md:w-24 lg:w-28 border-b-4 border-[#044E37]">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Furqoniyah" class="w-14 h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 object-contain hover:scale-105 transition-transform duration-300">
            </div>
        </div>

        <div class="relative z-10 w-full px-4 sm:px-8 lg:px-20 xl:px-32 pt-4 lg:pt-6">
            
            <!-- Content Area - Pushed right to clear the new narrower logo pill -->
            <div class="pl-24 md:pl-32 lg:pl-36">
                
                <!-- Top Header info & Mobile Toggle -->
                <div class="flex flex-row justify-end sm:justify-between items-center pb-4 border-b border-white/20 gap-4">
                    
                    <!-- Contact Info (Hidden on very small mobile screens, visible from sm up) -->
                    <div class="hidden sm:flex flex-row gap-6 lg:gap-8">
                        <!-- Call Us -->
                        <div class="flex items-center gap-3">
                            <div class="text-[#cc0000]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 lg:w-6 lg:h-6">
                                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white text-sm drop-shadow-md">Call Us</p>
                                <p class="text-white/90 text-[11px] lg:text-xs drop-shadow-md tracking-wide">0266 6249758 | +62 899-3334-343</p>
                            </div>
                        </div>
                        
                        <!-- Our Location -->
                        <div class="flex items-center gap-3">
                            <div class="text-[#cc0000]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 lg:w-6 lg:h-6">
                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white text-sm drop-shadow-md">our location</p>
                                <p class="text-white/90 text-[11px] lg:text-xs drop-shadow-md tracking-wide">Kp. Citugu, Ds. Tugujaya, Kec.Cigombong, Kabupaten Bogor, Jawa</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Hamburger Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-white hover:text-yellow-400 focus:outline-none p-1 transition-colors z-50 relative drop-shadow-md">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                </div>

                <!-- Navigation Links & Search Bar -->
                <div class="hidden md:flex items-center justify-between mt-4 pb-2">
                    
                    <!-- Links -->
                    <div class="flex items-center gap-6 lg:gap-10 text-white font-medium text-sm drop-shadow-md">
                        <a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors relative group">
                            Beranda
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <!-- Premium Dropdown Tentang -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 hover:text-yellow-400 transition-all duration-300 py-4 font-bold tracking-wide">
                                TENTANG
                                <svg class="w-4 h-4 transition-transform duration-500 group-hover:rotate-180 text-yellow-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Mega-Lite Dropdown Menu -->
                            <div class="absolute top-full left-0 w-64 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-4 transition-all duration-500 z-50">
                                <div class="bg-[#044E37]/95 backdrop-blur-xl border border-white/20 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden p-2">
                                    
                                    <!-- Profil Pesantren Item -->
                                    <a href="{{ route('profile') }}" class="group/item flex items-start gap-4 p-4 rounded-2xl hover:bg-white/10 transition-all duration-300">
                                        <div>
                                            <h4 class="text-white font-bold text-sm mb-0.5 group-hover/item:text-yellow-400">Profil Pesantren</h4>
                                            <p class="text-white/50 text-[10px] leading-relaxed">Sejarah, Visi, Misi dan filosofi kami.</p>
                                        </div>
                                    </a>

                                    <!-- Ekstrakurikuler Item -->
                                    <a href="{{ route('ekstrakurikuler') }}" class="group/item flex items-start gap-4 p-4 rounded-2xl hover:bg-white/10 transition-all duration-300">
                                        <div>
                                            <h4 class="text-white font-bold text-sm mb-0.5 group-hover/item:text-yellow-400">Ekstrakurikuler</h4>
                                            <p class="text-white/50 text-[10px] leading-relaxed">Wadah minat, bakat, dan kreativitas santri.</p>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <a href="#" class="flex items-center gap-1 hover:text-yellow-400 transition-colors group">AKADEMIK <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg></a>
                        <a href="#" class="flex items-center gap-1 hover:text-yellow-400 transition-colors group">INFORMASI <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg></a>
                        <a href="{{ route('contact') }}" class="hover:text-yellow-400 transition-colors font-bold">KONTAK</a>
                    </div>
                    
                    <!-- Search Input Field -->
                    <div class="relative ml-8 flex items-center">
                        <div class="absolute left-3 flex items-center pointer-events-none z-10">
                            <!-- Made the icon fully white, larger, and thicker for extreme clarity -->
                            <svg class="w-5 h-5 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari info..." 
                            class="w-36 lg:w-48 xl:w-56 py-1.5 pl-10 pr-4 bg-white/20 hover:bg-white/30 focus:bg-white/30 border-2 border-white/50 rounded-full text-sm text-white placeholder-white font-medium focus:outline-none focus:ring-2 focus:ring-yellow-400 backdrop-blur-md transition-all duration-300 shadow-inner relative z-0">
                    </div>
                    
                </div>

            </div>
            
        </div>
    </nav>

    <!-- Mobile Menu Overlay (Hidden strictly on >=md screens, slided out initially) -->
    <div id="mobile-menu" class="fixed inset-0 bg-[#044E37] z-[100] transform translate-x-full transition-transform duration-300 md:hidden flex flex-col pt-8 px-6 overflow-y-auto">
        <!-- Header of Mobile Menu -->
        <div class="flex justify-between items-center mb-10 border-b border-white/20 pb-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain mix-blend-screen">
                <div class="font-extrabold text-xl tracking-wide uppercase font-serif text-white">Al-Furqoniyah</div>
            </div>
            <button id="close-menu-btn" class="text-white hover:text-yellow-400 p-2 focus:outline-none transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="relative w-full mb-8">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center pointer-events-none text-white/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Cari informasi..." class="w-full py-3.5 pl-12 pr-4 bg-white/10 border border-white/30 rounded-xl text-white placeholder-white/80 focus:outline-none focus:border-yellow-400 focus:bg-white/20 transition-all font-medium">
        </div>

        <!-- Mobile Navigation Links -->
        <div class="flex flex-col gap-0 text-lg font-semibold text-white/90">
            <a href="{{ route('home') }}" class="border-b border-white/10 py-4 hover:text-yellow-400 hover:pl-2 transition-all">Beranda</a>
            
            <!-- Mobile Dropdown Tentang (Vanilla JS Controlled) -->
            <div class="border-b border-white/10">
                <button id="mobile-tentang-btn" class="w-full py-4 flex justify-between items-center hover:text-yellow-400 hover:pl-2 transition-all focus:outline-none">
                    Tentang 
                    <svg id="mobile-tentang-arrow" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div id="mobile-tentang-menu" class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out bg-white/5 pl-4">
                    <a href="{{ route('profile') }}" class="block py-4 border-b border-white/5 hover:text-yellow-400">Profil Pesantren</a>
                    <a href="{{ route('ekstrakurikuler') }}" class="block py-4 hover:text-yellow-400">Ekstrakurikuler</a>
                </div>
            </div>
            <a href="#" class="border-b border-white/10 py-4 flex justify-between items-center hover:text-yellow-400 hover:pl-2 transition-all">Akademik <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
            <a href="#" class="border-b border-white/10 py-4 flex justify-between items-center hover:text-yellow-400 hover:pl-2 transition-all">Informasi <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
            <a href="{{ route('contact') }}" class="py-4 hover:text-yellow-400 hover:pl-2 transition-all">Kontak</a>
        </div>
        
        <!-- Mobile Contact Info -->
        <div class="mt-auto pb-8 pt-8 flex flex-col gap-6">
            <!-- Call Us (Mobile View) -->
            <div class="flex items-center gap-4">
                <div class="bg-white/10 p-3 rounded-full text-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white text-[15px]">Call Us</h4>
                    <p class="text-white/80 text-sm mt-0.5">0266 6249758 | +62 899-3334-343</p>
                </div>
            </div>
            
            <!-- Location (Mobile View) -->
            <div class="flex items-center gap-4">
                <div class="bg-white/10 p-3 rounded-full text-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white text-[15px]">our location</h4>
                    <p class="text-white/80 text-[13px] leading-snug mt-0.5">Citugu Tugujaya<br>Kabupaten Bogor, Jawa Barat</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.remove('translate-x-full');
                });
            }

            if (closeMenuBtn && mobileMenu) {
                closeMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.add('translate-x-full');
                });
            }

            // Close menu when clicking on actual navigation links (but not dropdown toggle buttons)
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    // Prevent closing if the link points to '#' to avoid instant close on mock links
                    if (link.getAttribute('href') !== '#') {
                        mobileMenu.classList.add('translate-x-full');
                    }
                });
            });

            // Mobile Dropdown Toggle for "Tentang"
            const mobileTentangBtn = document.getElementById('mobile-tentang-btn');
            const mobileTentangMenu = document.getElementById('mobile-tentang-menu');
            const mobileTentangArrow = document.getElementById('mobile-tentang-arrow');

            if (mobileTentangBtn && mobileTentangMenu) {
                // Ensure initial inline style is set to prevent sudden jumps
                mobileTentangMenu.style.maxHeight = '0px';
                mobileTentangMenu.style.opacity = '0';
                mobileTentangMenu.style.transition = 'max-height 0.35s ease-in-out, opacity 0.25s ease-in-out';

                mobileTentangBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isOpen = mobileTentangMenu.style.maxHeight !== '0px';
                    if (isOpen) {
                        mobileTentangMenu.style.maxHeight = '0px';
                        mobileTentangMenu.style.opacity = '0';
                        if (mobileTentangArrow) mobileTentangArrow.classList.remove('rotate-90');
                    } else {
                        mobileTentangMenu.style.maxHeight = mobileTentangMenu.scrollHeight + 'px';
                        mobileTentangMenu.style.opacity = '1';
                        if (mobileTentangArrow) mobileTentangArrow.classList.add('rotate-90');
                    }
                });
            }
        });
    </script>
