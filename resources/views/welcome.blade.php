<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerbang Keunggulan Ilmu</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jaini+Purva&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite + Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        /* Custom Minimalis Dot Follower */
        #cursor-dot {
            width: 32px;
            height: 32px;
            background-color: rgba(196, 208, 29, 0.15); /* Transparan kuning-hijau tema */
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
        
        /* Hilangkan dot di layar sentuh (mobile) */
        @media (max-width: 768px) {
            #cursor-dot { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 antialiased overflow-x-hidden">

    <x-loader />

    <!-- Custom Dot Follower Element -->
    <div id="cursor-dot"></div>

    <x-navbar />

    <!-- Hero Section with Background Slider -->
    <div class="relative w-full h-screen min-h-[600px] flex items-center overflow-hidden">
        
        <!-- Background Slider Container -->
        <div class="absolute inset-0 z-0 bg-blue-900">
            <div id="slider-track" class="flex w-full h-full transition-transform duration-[1500ms] ease-[cubic-bezier(0.25,1,0.5,1)]" style="transform: translateX(0%);">
                
                <!-- Slide 1 -->
                <div class="w-full h-full flex-shrink-0 relative slide-item">
                    <img src="{{ asset('images/slider 1.png') }}" alt="Kegiatan Apel Santri"
                         class="w-full h-full object-cover">
                    {{-- overlay + blur --}}
                    <div class="absolute inset-0 bg-[#064e3b]/60 backdrop-blur-[2px]"></div>
                </div>
                
                <!-- Slide 2 -->
                <div class="w-full h-full flex-shrink-0 relative slide-item">
                    <img src="{{ asset('images/slider 2.png') }}" alt="School Background"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#064e3b]/60 backdrop-blur-[2px]"></div>
                </div>
                
                <!-- Slide 3 -->
                <div class="w-full h-full flex-shrink-0 relative slide-item">
                    <img src="{{ asset('images/slider 3.png') }}" alt="Education Background"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#064e3b]/60 backdrop-blur-[2px]"></div>
                </div>

            </div>
        </div>

        <!-- Foto Kyai: absolut, rata kiri sejajar dengan logo -->
        <div class="absolute bottom-0 left-0 z-10 flex items-end pointer-events-none">
            <img src="{{ asset('images/kyai.png') }}"
                 alt="Foto Kyai Al-Furqoniyah"
                 class="w-auto object-contain object-bottom drop-shadow-2xl"
                 style="height: 90vh; max-height: 750px;">
        </div>

        <!-- Teks Hero — tanpa kartu/background -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                    flex items-center h-full pt-28">
            <!-- Digeser ke kiri dengan margin right (mr) pada layar besar -->
            <div class="w-full max-w-2xl ml-auto lg:mr-16 xl:mr-32">

                <!-- Headline (Diperbesar) -->
                <h1 class="leading-tight mb-6" style="font-family: 'Jaini Purva', serif;">
                    <span class="block text-2xl md:text-4xl lg:text-5xl text-white/90 mb-2 drop-shadow-lg">
                        PONDOK PESANTREN
                    </span>
                    <span class="block text-5xl md:text-7xl lg:text-[5.5rem] text-white drop-shadow-2xl"
                          style="text-shadow: 0 4px 25px rgba(0,0,0,0.5);">
                        AL-FURQONIYAH
                    </span>
                    <span class="block text-5xl md:text-5xl lg:text-[3.3rem] text-white drop-shadow-2xl"
                          style="text-shadow: 0 4px 25px rgba(0,0,0,0.5);">
                        Islamic Community College
                    </span>
                </h1>

                <!-- Subheadline (Diperbesar) -->
                <p class="text-base md:text-xl text-white/95 font-medium mb-10 drop-shadow-md">
                    Membentuk Muslim Personality Membangun Muslim Community.
                </p>

                <!-- Buttons -->
                <div class="flex flex-wrap gap-4 items-center">
                    <a href="#" class="px-8 py-4 rounded-xl border-2 border-white text-white font-bold text-[15px] hover:bg-white/20 transition-colors duration-300 backdrop-blur-sm">
                        Lihat Profile
                    </a>
                    <a href="#" class="px-8 py-4 rounded-xl bg-[#044E37] text-white font-bold text-[15px] shadow-xl hover:bg-[#033a29] transition-all duration-300 transform hover:-translate-y-0.5">
                        Daftar sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-yellow-500 text-white font-bold text-[15px] shadow-xl hover:bg-yellow-600 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        Portal Kepengasuhan &rarr;
                    </a>
                </div>

            </div>
        </div>

    </div>


    <!-- MAIN CONTENT -->
    <main class="w-full bg-[#f8fafc] relative z-20 pb-20">
        
        <!-- 1. Quick Stats & Highlight Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 relative z-30">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- KIRI: 4 Kartu Statistik — Borderless Infographic -->
                <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-0 relative">
                    
                    <!-- Cell 1: Pengalaman -->
                    <div class="p-8 lg:p-10 border-b sm:border-r border-gray-200/80 flex flex-col justify-between group">
                        <div class="mb-6">
                            <!-- Minimal Islamic 8-Pointed Star Accent -->
                            <svg class="w-6 h-6 text-[#c9a44a] mb-2 transform group-hover:rotate-45 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M12 2L15 7L20 8L17 12L20 16L15 17L12 22L9 17L4 16L7 12L4 8L9 7Z" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="2.5" fill="rgba(201,164,74,0.1)"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-5xl lg:text-6xl font-black text-[#044E37] tracking-tight mb-2" style="font-family:'Playfair Display','Georgia',serif;">
                                <span class="stat-number" data-target="50">0</span>+
                            </h3>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500/80">Pengalaman bertahun-tahun</p>
                        </div>
                    </div>
                    
                    <!-- Cell 2: Santri Siswa -->
                    <div class="p-8 lg:p-10 border-b border-gray-200/80 flex flex-col justify-between group">
                        <div class="mb-6">
                            <svg class="w-6 h-6 text-[#c9a44a] mb-2 transform group-hover:rotate-45 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M12 2L15 7L20 8L17 12L20 16L15 17L12 22L9 17L4 16L7 12L4 8L9 7Z" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="2" fill="rgba(201,164,74,0.1)"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-5xl lg:text-6xl font-black text-[#044E37] tracking-tight mb-2" style="font-family:'Playfair Display','Georgia',serif;">
                                <span class="stat-number" data-target="2000">0</span>+
                            </h3>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500/80">Santri Aktif &amp; Terbina</p>
                        </div>
                    </div>
                    
                    <!-- Cell 3: Alumni -->
                    <div class="p-8 lg:p-10 border-b sm:border-b-0 sm:border-r border-gray-200/80 flex flex-col justify-between group">
                        <div class="mb-6">
                            <svg class="w-6 h-6 text-[#c9a44a] mb-2 transform group-hover:rotate-45 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M12 2L15 7L20 8L17 12L20 16L15 17L12 22L9 17L4 16L7 12L4 8L9 7Z" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="2" fill="rgba(201,164,74,0.1)"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-5xl lg:text-6xl font-black text-[#044E37] tracking-tight mb-2" style="font-family:'Playfair Display','Georgia',serif;">
                                <span class="stat-number" data-target="10">0</span>k+
                            </h3>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500/80">Alumni di Seluruh Nusantara</p>
                        </div>
                    </div>
                    
                    <!-- Cell 4: Kepercayaan -->
                    <div class="p-8 lg:p-10 flex flex-col justify-between group">
                        <div class="mb-6">
                            <svg class="w-6 h-6 text-[#c9a44a] mb-2 transform group-hover:rotate-45 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M12 2L15 7L20 8L17 12L20 16L15 17L12 22L9 17L4 16L7 12L4 8L9 7Z" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="2" fill="rgba(201,164,74,0.1)"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-5xl lg:text-6xl font-black text-[#044E37] tracking-tight mb-2" style="font-family:'Playfair Display','Georgia',serif;">
                                <span class="stat-number" data-target="100">0</span>%
                            </h3>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500/80">Pondok Pesantren Terpercaya</p>
                        </div>
                    </div>

                </div>

                <!-- KANAN: Foto Browser & Badge -->
                <div class="lg:col-span-6 relative mt-12 lg:mt-0 lg:pl-8">
                    <!-- Main Image Container -->
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-[6px] border-white bg-white group">
                        <img src="{{ asset('images/browser 1.png') }}" alt="Dashboard Pesantren" 
                             class="w-full h-auto object-cover transform group-hover:scale-[1.02] transition-transform duration-500">
                        <!-- Soft overlay untuk menambah depth -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent pointer-events-none"></div>
                    </div>
                    
                    <!-- Badge "Since 1970" -->
                    <div class="absolute -top-6 -right-2 md:-top-8 md:-right-6 bg-yellow-400 text-[#044E37] flex flex-col items-center justify-center w-28 h-28 md:w-36 md:h-36 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.15)] transform rotate-12 border-[6px] border-white z-10 hover:rotate-0 transition-transform duration-300 hover:scale-105">
                        <span class="text-xs md:text-sm font-bold uppercase tracking-widest mb-[-2px] md:mb-[-4px]">Sejak</span>
                        <span class="text-3xl md:text-4xl font-black">1970</span>
                    </div>
                    
                    <!-- Dekorasi background blur (opsional, memberi efek premium) -->
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-[#C4D01D]/40 rounded-full blur-3xl -z-10"></div>
                </div>
                
            </div>
        </div>


        <!-- 2. About Us Section — Editorial Redesign -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative overflow-hidden">
            <!-- Background Decorative Blur -->
            <div class="absolute -top-10 -right-10 w-96 h-96 bg-[#c9a44a]/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-96 h-96 bg-[#044E37]/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- LEFT: Framed Photos Collage (5 columns) -->
                <div class="lg:col-span-5 relative flex flex-col items-center mb-10 lg:mb-0">
                    
                    <!-- Main Frame (Student 1) -->
                    <div class="relative w-[85%] sm:w-[70%] lg:w-[90%] aspect-[4/5] z-10">
                        <!-- Asymmetric Back Card -->
                        <div class="absolute -inset-4 bg-[#fbf9f4] border border-[#c9a44a]/30 rounded-t-[120px] rounded-b-3xl -z-10 shadow-sm transform -rotate-1"></div>
                        
                        <!-- Arch Image Container -->
                        <div class="w-full h-full rounded-t-[120px] rounded-b-2xl overflow-hidden border-2 border-white shadow-[0_15px_30px_rgba(26,92,56,0.08)] bg-white">
                            <img src="{{ asset('images/santri2.png') }}" 
                                 alt="Santri Pertama Al-Furqoniyah" 
                                 class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>

                    <!-- Secondary Overlapping Frame (Student 2) -->
                    <div class="absolute -bottom-10 -right-4 lg:-right-6 w-[55%] sm:w-[45%] lg:w-[58%] aspect-[4/5] z-20">
                        <!-- Back Card offset -->
                        <div class="absolute -inset-3 bg-white border border-[#c9a44a]/20 rounded-t-[80px] rounded-b-2xl -z-10 shadow-md transform rotate-2"></div>
                        
                        <!-- Arch Container -->
                        <div class="w-full h-full rounded-t-[80px] rounded-b-xl overflow-hidden border-2 border-white shadow-[0_12px_24px_rgba(0,0,0,0.1)] bg-white">
                            <img src="{{ asset('images/santri1.png') }}" 
                                 alt="Santri Kedua Al-Furqoniyah" 
                                 class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>
                    
                </div>

                <!-- RIGHT: Premium Content (7 columns) -->
                <div class="lg:col-span-7 space-y-8 lg:pl-6">
                    <div>
                        {{-- Uppercase Gold Sub-Badge --}}
                        <span class="text-xs font-bold tracking-[0.25em] uppercase text-[#c9a44a] flex items-center gap-2 mb-3">
                            <span class="w-6 h-[1.5px] bg-[#c9a44a] inline-block"></span>
                            Tentang Kami
                        </span>
                        
                        {{-- Premium Serif Heading --}}
                        <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold text-[#11223a] leading-tight tracking-tight" style="font-family:'Playfair Display','Georgia',serif;">
                            Pondok Pesantren <br>
                            <span class="text-[#044E37] relative inline-block">
                                Al-Furqoniyah
                                <svg class="absolute w-full h-2 -bottom-2 left-0 text-[#C4D01D]/40" viewBox="0 0 100 10" preserveAspectRatio="none">
                                    <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none"/>
                                </svg>
                            </span>
                        </h2>
                    </div>

                    {{-- High Legibility Introduction --}}
                    <div class="text-[#2b3a4a] text-[15px] md:text-base leading-relaxed text-justify space-y-4">
                        <p class="font-medium text-gray-700">
                            Pondok Pesantren Al-Furqoniyah merupakan lembaga pendidikan Islam terpercaya yang berlokasi di Kecamatan Cigombong, Kabupaten Bogor, Jawa Barat. Berdiri sejak tahun 1970, kami berkomitmen untuk melahirkan generasi muslim yang unggul, berakhlak mulia, mandiri, dan berwawasan luas.
                        </p>
                    </div>

                    {{-- Stylized Quote Section (Core Values) --}}
                    <div class="relative border-l-4 border-[#044E37] pl-5 py-2 my-6 bg-gradient-to-r from-[#044E37]/5 to-transparent rounded-r-lg">
                        <span class="absolute right-4 top-2 text-[#044E37]/10 text-6xl font-serif select-none pointer-events-none">“</span>
                        <p class="text-[15px] font-semibold text-[#044E37] italic leading-relaxed">
                            "Membina kepribadian muslim yang kokoh melalui integrasi akademik unggul, kedisiplinan yang konsisten, serta keteladanan nilai-nilai Islami."
                        </p>
                    </div>

                    {{-- Horizontal Mini-Stats Section (Breaking the Wall of Text) --}}
                    <div class="grid grid-cols-3 gap-4 border-t border-b border-gray-150 py-5 my-6">
                        <div class="text-center lg:text-left">
                            <span class="block text-2xl lg:text-3xl font-black text-[#044E37]" style="font-family:'Playfair Display',serif;">1970</span>
                            <span class="block text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-1">Berdiri Sejak</span>
                        </div>
                        <div class="text-center lg:text-left border-l border-gray-150 pl-4">
                            <span class="block text-2xl lg:text-3xl font-black text-[#c9a44a]" style="font-family:'Playfair Display',serif;">Modern</span>
                            <span class="block text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-1">Metode Belajar</span>
                        </div>
                        <div class="text-center lg:text-left border-l border-gray-150 pl-4">
                            <span class="block text-2xl lg:text-3xl font-black text-[#044E37]" style="font-family:'Playfair Display',serif;">Salafiyah</span>
                            <span class="block text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-1">Nilai Klasik</span>
                        </div>
                    </div>

                    {{-- Secondary Description --}}
                    <p class="text-gray-500 text-[14px] leading-relaxed text-justify">
                        Dengan memadukan kurikulum pendidikan formal nasional dan pendidikan pesantren klasik, kami menyediakan lingkungan belajar yang aman, kondusif, dan penuh berkah demi menyiapkan santri menghadapi tantangan zaman tanpa kehilangan jati diri sebagai muslim sejati.
                    </p>
                </div>

            </div>
        </section>
        
        <!-- 3. Video Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 border-t border-gray-200/60">
            {{-- Asymmetrical Header Row --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12 lg:mb-16">
                {{-- Left Column (Title & Category) --}}
                <div class="max-w-2xl">
                    <span class="text-xs font-bold tracking-[0.25em] uppercase text-[#c9a44a] flex items-center gap-2 mb-3">
                        <span class="w-6 h-[1.5px] bg-[#c9a44a] inline-block"></span>
                        Video Profil
                    </span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold text-[#044E37] tracking-tight leading-tight" style="font-family:'Playfair Display','Georgia',serif;">
                        Jelajahi Kehidupan<br class="hidden sm:block"> Pesantren Kami
                    </h2>
                </div>
                
                {{-- Right Column (Description - 40% width) --}}
                <div class="md:max-w-md lg:max-w-lg">
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed text-left md:text-right border-l-2 md:border-l-0 md:border-r-2 border-[#c9a44a]/40 pl-4 md:pl-0 md:pr-4 py-1">
                        Saksikan cuplikan kegiatan harian, fasilitas unggulan, dan atmosfir pembelajaran yang mendukung tumbuh kembang karakter santri di Pondok Pesantren Al-Furqoniyah.
                    </p>
                </div>
            </div>
            
            <div class="relative max-w-5xl mx-auto rounded-[2rem] overflow-hidden shadow-[0_20px_50px_rgba(4,78,55,0.15)] bg-white border-[10px] border-white group">
                <!-- Decorative Glow Background -->
                <div class="absolute -inset-1 bg-gradient-to-r from-[#044E37] via-[#C4D01D] to-[#044E37] opacity-20 group-hover:opacity-40 blur-lg transition duration-700"></div>
                
                <!-- Iframe Wrapper -->
                <div class="relative aspect-video w-full rounded-2xl overflow-hidden bg-gray-900 z-10 shadow-inner">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/F1xemUDW6II?si=sG6LDOChbplFNRm-&rel=0" 
                        title="Jelajahi Kehidupan Pesantren Al-Furqoniyah" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            
            <!-- Bawah Video: Official YouTube (Kiri) & Creator Credit (Kanan) -->
            <div class="mt-4 max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 px-2 md:px-0">
                
                <!-- Kiri: Official Pesantren YouTube -->
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow w-full md:w-auto">
                    <div class="flex-shrink-0">
                        <a href="https://www.youtube.com/@pesantrenalfurqoniyah47" target="_blank" rel="noopener noreferrer" class="group relative flex items-center justify-center w-12 h-12 bg-red-50 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span class="absolute inset-0 rounded-full border border-red-600 animate-ping opacity-20"></span>
                        </a>
                    </div>
                    <div class="text-left pr-2 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Official Channel</p>
                        <h4 class="text-sm md:text-base font-black text-[#11223a] leading-tight">Pesantren Al-Furqoniyah</h4>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                            <a href="https://www.youtube.com/@pesantrenalfurqoniyah47" target="_blank" rel="noopener noreferrer" class="font-bold text-red-600 hover:text-red-700 hover:underline">Subscribe Sekarang</a>
                        </p>
                    </div>
                </div>

                <!-- Kanan: Creator Credit -->
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow w-full md:w-auto">
                    <!-- YouTube Icon/Avatar -->
                    <div class="flex-shrink-0">
                        <a href="https://www.youtube.com/@Dioifanto" target="_blank" rel="noopener noreferrer" class="group relative flex items-center justify-center w-12 h-12 bg-red-50 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <!-- Ping Animation -->
                            <span class="absolute inset-0 rounded-full border border-red-600 animate-ping opacity-20"></span>
                        </a>
                    </div>
                    <!-- Text Detail -->
                    <div class="text-left pr-2 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Dibuat oleh:</p>
                        <h4 class="text-sm md:text-base font-black text-[#11223a] flex items-center gap-1.5 leading-tight">
                            Dio Ifanto 
                            <span class="text-[9px] md:text-[10px] font-bold text-[#044E37] px-2 py-0.5 bg-[#C4D01D]/30 rounded border border-[#C4D01D]/50">Alumni</span>
                        </h4>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                            <a href="https://www.youtube.com/@Dioifanto" target="_blank" rel="noopener noreferrer" class="font-bold text-red-600 hover:text-red-700 hover:underline">Kunjungi Channel</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        

        <!-- 4. Berita Terkini / Prestasi Terbaru Section — Editorial Layout -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 border-t border-gray-200/60">

            {{-- Section Header --}}
            <div class="flex items-end justify-between mb-10 lg:mb-12">
                <div>
                    <span class="text-xs font-bold tracking-[0.22em] uppercase text-[#C4D01D] flex items-center gap-2 mb-3">
                        <span class="w-6 h-[1.5px] bg-[#C4D01D] inline-block"></span>
                        Kabar Terbaru
                    </span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-[#11223a] tracking-tight leading-tight" style="font-family:'Playfair Display','Georgia',serif;">
                        Berita &amp; Prestasi<br class="hidden lg:block"> Terkini
                    </h2>
                </div>
                {{-- Minimal CTA --}}
                <a href="#" class="hidden md:inline-flex items-center gap-2 text-[#044E37] font-semibold text-sm tracking-wide border-b border-[#044E37] pb-0.5 hover:text-[#C4D01D] hover:border-[#C4D01D] transition-all duration-300 group flex-shrink-0 mb-1">
                    Lihat Semua Berita
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            {{-- Editorial Grid: 60% Featured | 40% Sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-0 lg:gap-10 xl:gap-14">

                {{-- ── LEFT: Featured Article (60%) ─────────────────── --}}
                <article class="lg:col-span-3 group cursor-pointer mb-10 lg:mb-0">

                    {{-- Image with Islamic arch top treatment --}}
                    <div class="relative overflow-hidden" style="border-radius: 1.5rem 1.5rem 0.5rem 0.5rem;">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=900&auto=format&fit=crop"
                             alt="Juara Kaligrafi"
                             class="w-full h-72 md:h-96 lg:h-[420px] object-cover transition-transform duration-700 group-hover:scale-105">

                        {{-- Gradient overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a1f14]/75 via-transparent to-transparent"></div>

                        {{-- Islamic arch SVG overlay at top of image --}}
                        <div class="absolute top-0 left-0 right-0 pointer-events-none" style="height:56px;">
                            <svg viewBox="0 0 800 56" preserveAspectRatio="none" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0,56 L0,28 Q0,0 28,0 L772,0 Q800,0 800,28 L800,56 Z" fill="rgba(10,31,20,0)" stroke="rgba(201,164,74,0.55)" stroke-width="1.5" fill-opacity="0"/>
                                {{-- Pointed arch motif center top --}}
                                <path d="M340,56 Q400,20 460,56" fill="none" stroke="rgba(201,164,74,0.5)" stroke-width="1.2"/>
                                <circle cx="400" cy="21" r="3" fill="rgba(201,164,74,0.75)"/>
                            </svg>
                        </div>

                        {{-- Bottom-left: small reading time badge --}}
                        <div class="absolute bottom-4 right-4 bg-white/15 backdrop-blur-md text-white text-[10px] font-semibold tracking-widest uppercase px-3 py-1.5 rounded-full border border-white/20">
                            3 min baca
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="pt-5 pr-0 lg:pr-6">
                        {{-- Category badge above title --}}
                        <span class="text-[11px] font-bold tracking-[0.22em] uppercase text-[#c9a44a] mb-2 block">
                            ✦ &nbsp;Prestasi
                        </span>

                        {{-- Serif title --}}
                        <h3 class="text-2xl md:text-3xl font-bold text-[#11223a] leading-snug mb-3 group-hover:text-[#044E37] transition-colors duration-300" style="font-family:'Playfair Display','Georgia',serif;">
                            Juara Umum Lomba Kaligrafi Tingkat Kabupaten Bogor
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-gray-500 text-[15px] leading-relaxed mb-4 line-clamp-3">
                            Santri Al-Furqoniyah berhasil meraih juara umum pada ajang perlombaan kaligrafi yang diselenggarakan oleh Kementerian Agama tingkat Kabupaten Bogor, mengharumkan nama pesantren di kancah regional.
                        </p>

                        {{-- Meta row --}}
                        <div class="flex items-center gap-4 text-xs text-gray-400 font-medium">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#044E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                12 Mei 2026
                            </span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <a href="#" class="text-[#044E37] font-semibold hover:text-[#C4D01D] transition-colors flex items-center gap-1 group/lnk">
                                Baca Selengkapnya
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/lnk:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </article>

                {{-- ── RIGHT: Sidebar News List (40%) ─────────────────── --}}
                <aside class="lg:col-span-2 flex flex-col divide-y divide-gray-100 lg:border-l lg:border-gray-200 lg:pl-10">

                    {{-- Item 1 --}}
                    <article class="group cursor-pointer py-3.5 first:pt-0">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=200&auto=format&fit=crop"
                                     alt="Kegiatan"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[9px] font-bold tracking-[0.2em] uppercase text-[#c9a44a] mb-1 block">Kegiatan</span>
                                <h4 class="text-[13px] font-bold text-[#11223a] leading-snug mb-1 group-hover:text-[#044E37] transition-colors line-clamp-2">
                                    Kunjungan Edukatif ke Perpustakaan Nasional
                                </h4>
                                <span class="text-[11px] text-gray-400">05 Mei 2026</span>
                            </div>
                        </div>
                    </article>

                    {{-- Item 2 --}}
                    <article class="group cursor-pointer py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1511649475669-e288648b2339?q=80&w=200&auto=format&fit=crop"
                                     alt="Pengumuman"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[9px] font-bold tracking-[0.2em] uppercase text-[#c9a44a] mb-1 block">Pengumuman</span>
                                <h4 class="text-[13px] font-bold text-[#11223a] leading-snug mb-1 group-hover:text-[#044E37] transition-colors line-clamp-2">
                                    Penerimaan Santri Baru Gelombang 2 Resmi Dibuka
                                </h4>
                                <span class="text-[11px] text-gray-400">28 April 2026</span>
                            </div>
                        </div>
                    </article>

                    {{-- Item 3 --}}
                    <article class="group cursor-pointer py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=200&auto=format&fit=crop"
                                     alt="Program"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[9px] font-bold tracking-[0.2em] uppercase text-[#c9a44a] mb-1 block">Program</span>
                                <h4 class="text-[13px] font-bold text-[#11223a] leading-snug mb-1 group-hover:text-[#044E37] transition-colors line-clamp-2">
                                    Peluncuran Program Tahfidz Intensif Semester Ganjil
                                </h4>
                                <span class="text-[11px] text-gray-400">15 April 2026</span>
                            </div>
                        </div>
                    </article>
                </aside>
            </div>

            {{-- Mobile CTA --}}
            <div class="mt-8 md:hidden text-center">
                <a href="#" class="inline-flex items-center gap-2 text-[#044E37] font-semibold text-sm border-b border-[#044E37] pb-0.5">
                    Lihat Semua Berita &rarr;
                </a>
            </div>

        </section>


        <!-- 5. Rincian Biaya Section — Slip & Receipt Layout -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 border-t border-gray-200/60 bg-gray-50/30">
            
            {{-- Section Header --}}
            <div class="text-center mb-16 lg:mb-20">
                <span class="text-xs font-bold tracking-[0.25em] uppercase text-[#c9a44a] flex items-center justify-center gap-2 mb-3">
                    <span class="w-6 h-[1.5px] bg-[#c9a44a] inline-block"></span>
                    Informasi Pendaftaran
                </span>
                <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold text-[#044E37] tracking-tight mb-4" style="font-family:'Playfair Display','Georgia',serif;">
                    Rincian Biaya Pendidikan
                </h2>
                <p class="text-slate-500 max-w-xl mx-auto text-sm md:text-base leading-relaxed">
                    Informasi pembiayaan administrasi secara terbuka dan transparan untuk calon wali santri Pondok Pesantren Al-Furqoniyah.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                
                {{-- ── CARD 1: MTs (Tsanawiyah) ────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-100/50 border border-slate-200/80 flex flex-col justify-between overflow-hidden hover:-translate-y-1.5 transition-transform duration-300">
                    <div>
                        {{-- Arch Header --}}
                        <div class="relative bg-[#044E37] text-white py-8 px-6 overflow-hidden">
                            {{-- Pointed Arch SVG Motif --}}
                            <div class="absolute inset-x-0 bottom-0 top-0 opacity-10 pointer-events-none flex justify-center items-end">
                                <svg class="w-full h-full text-white" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                                    <path d="M 0 100 L 0 35 C 20 0, 80 0, 100 35 L 100 100 Z"/>
                                </svg>
                            </div>
                            <div class="relative z-10 text-center">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-[#C4D01D] font-bold block mb-1">Jenjang Pendidikan</span>
                                <h3 class="text-2xl font-bold tracking-wide" style="font-family:'Playfair Display',serif;">Madrasah Tsanawiyah (MTs)</h3>
                            </div>
                        </div>

                        {{-- Line Items --}}
                        <div class="p-8 space-y-6">
                            
                            {{-- Item 1 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Biaya Pendaftaran</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sekali di awal pendaftaran</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 300.000</span>
                            </div>

                            {{-- Item 2 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Uang Pangkal / Masuk</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sarana, prasarana, &amp; seragam</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 2.000.000</span>
                            </div>

                            {{-- Item 3 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Syahriah Bulanan</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sudah termasuk asrama &amp; konsumsi</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 1.500.000</span>
                            </div>

                        </div>
                    </div>

                    {{-- Footer/CTA --}}
                    <div class="px-8 pb-8">
                        <a href="#" class="block w-full py-3.5 rounded-lg bg-[#c9a44a] hover:bg-[#b08e3d] text-white text-center text-sm font-bold tracking-wider uppercase transition-all duration-300 shadow-md">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>

                {{-- ── CARD 2: MA (Aliyah) ─────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-100/50 border border-slate-200/80 flex flex-col justify-between overflow-hidden hover:-translate-y-1.5 transition-transform duration-300">
                    <div>
                        {{-- Arch Header --}}
                        <div class="relative bg-[#044E37] text-white py-8 px-6 overflow-hidden">
                            {{-- Pointed Arch SVG Motif --}}
                            <div class="absolute inset-x-0 bottom-0 top-0 opacity-10 pointer-events-none flex justify-center items-end">
                                <svg class="w-full h-full text-white" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                                    <path d="M 0 100 L 0 35 C 20 0, 80 0, 100 35 L 100 100 Z"/>
                                </svg>
                            </div>
                            <div class="relative z-10 text-center">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-[#C4D01D] font-bold block mb-1">Jenjang Pendidikan</span>
                                <h3 class="text-2xl font-bold tracking-wide" style="font-family:'Playfair Display',serif;">Madrasah Aliyah (MA)</h3>
                            </div>
                        </div>

                        {{-- Line Items --}}
                        <div class="p-8 space-y-6">
                            
                            {{-- Item 1 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Biaya Pendaftaran</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sekali di awal pendaftaran</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 350.000</span>
                            </div>

                            {{-- Item 2 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Uang Pangkal / Masuk</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sarana, prasarana, &amp; seragam</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 3.000.000</span>
                            </div>

                            {{-- Item 3 --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-left">
                                    <span class="text-sm font-bold text-slate-800 block">Syahriah Bulanan</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Sudah termasuk asrama &amp; konsumsi</span>
                                </div>
                                <span class="flex-grow border-b border-dotted border-slate-300 mx-4"></span>
                                <span class="text-base font-bold text-[#044E37] font-serif" style="font-family:'Playfair Display',serif;">Rp 1.800.000</span>
                            </div>

                        </div>
                    </div>

                    {{-- Footer/CTA --}}
                    <div class="px-8 pb-8">
                        <a href="#" class="block w-full py-3.5 rounded-lg bg-[#c9a44a] hover:bg-[#b08e3d] text-white text-center text-sm font-bold tracking-wider uppercase transition-all duration-300 shadow-md">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>

            </div>
        </section>
            </div>
        </section>

        <!-- 6. FAQ Section — 3D Open-Book / Kitab Manuscript -->
        <section class="relative w-full border-t border-gray-200/60 bg-gray-50/30 overflow-hidden py-16 lg:py-24">
            
            <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <style>
                    /* Thick 3D Open-Book (Kitab) Styling */
                    .kitab-book-base {
                        position: relative;
                        background: #022116; /* Deep forest green hardcover base */
                        border-radius: 24px;
                        padding: 6px 8px 22px 8px; /* Exposes the bottom cover to show thickness */
                        box-shadow: 
                            0 25px 60px -15px rgba(0,0,0,0.45),
                            0 35px 80px -20px rgba(4,78,55,0.25);
                    }
                    
                    .kitab-paper-stack {
                        position: relative;
                        background: #fdfcf7; /* Premium unlined paper background */
                        border-radius: 14px 14px 16px 16px;
                        /* Layered paper sheet shadows simulating page thickness */
                        box-shadow: 
                            0 1px 0 #f5f3eb,
                            0 2px 0 #edeacd,
                            0 3px 0 #e5e1b9,
                            0 4px 0 #d9d4a0,
                            0 5px 0 #cdca89,
                            0 6px 0 #beb971,
                            0 7px 0 #b0ab5f,
                            0 8px 0 #9f9b51,
                            inset 0 1px 0 rgba(255,255,255,0.7),
                            inset 0 -12px 24px rgba(0,0,0,0.03);
                    }

                    /* Gradated shadows inside book pages to create curving depth */
                    .kitab-page-left {
                        background-color: #fdfcf9;
                        background-image: linear-gradient(to right, rgba(0,0,0,0.02) 0%, rgba(255,255,255,0) 80%, rgba(0,0,0,0.08) 100%);
                    }

                    .kitab-page-right {
                        background-color: #fdfcf9;
                        background-image: linear-gradient(to left, rgba(0,0,0,0.02) 0%, rgba(255,255,255,0) 80%, rgba(0,0,0,0.08) 100%);
                    }

                    /* Ribbon Animation */
                    @keyframes swingRibbon {
                        0% { transform: rotate(0deg); }
                        50% { transform: rotate(2deg); }
                        100% { transform: rotate(0deg); }
                    }
                </style>

                <!-- 3D Hardcover Base -->
                <div class="kitab-book-base">
                    
                    <!-- Layered Paper Stack Pages -->
                    <div class="kitab-paper-stack relative flex flex-col lg:flex-row overflow-hidden border border-[#11223a]/5">
                        
                        <!-- Middle Spine Shadow Crease -->
                        <div class="hidden lg:block absolute top-0 bottom-0 left-1/2 w-20 -ml-10 bg-gradient-to-r from-transparent via-black/15 to-transparent pointer-events-none z-20"></div>

                        <!-- Center Stitching / Sewing Detail -->
                        <div class="hidden lg:flex absolute top-0 bottom-0 left-1/2 -ml-2 w-4 flex-col justify-evenly items-center z-30 pointer-events-none">
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                            <div class="w-1 h-5 rounded-full bg-slate-400/60 shadow-[inset_1px_1px_2px_rgba(0,0,0,0.2)]"></div>
                        </div>

                        <!-- Red Bookmark Ribbon with Soft Filter Shadow -->
                        <div class="hidden lg:block absolute -top-1 left-1/2 ml-10 z-30 pointer-events-auto" style="filter: drop-shadow(3px 5px 4px rgba(0, 0, 0, 0.22));">
                            <div class="w-7 h-48 bg-[#be123c] animate-[swingRibbon_5s_ease-in-out_infinite] origin-top hover:scale-x-105 transition-transform" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 88%, 0 100%);"></div>
                        </div>

                        <!-- LEFT PAGE: Student Photos -->
                        <div class="w-full lg:w-1/2 px-6 pt-12 pb-8 lg:px-12 lg:pt-20 flex justify-center items-center kitab-page-left relative">
                            <img src="{{ asset('images/santri3.png') }}" 
                                 alt="Santri Al-Furqoniyah" 
                                 class="w-full max-w-sm lg:max-w-lg h-auto object-contain drop-shadow-[0_15px_30px_rgba(0,0,0,0.15)] z-10 scale-95 lg:scale-110">
                        </div>

                        <!-- RIGHT PAGE: FAQ Accordions -->
                        <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 kitab-page-right flex flex-col justify-between relative">
                            
                            <div>
                                <!-- Header -->
                                <div class="text-left mb-8">
                                    <span class="text-[10px] font-bold tracking-[0.25em] uppercase text-[#c9a44a] block mb-2">Tanya &amp; Jawab</span>
                                    <h3 class="text-2xl md:text-3xl font-bold text-[#044E37] tracking-tight" style="font-family:'Playfair Display','Georgia',serif;">
                                        Pertanyaan Umum
                                    </h3>
                                    <p class="text-xs md:text-sm text-slate-500 mt-2">Temukan jawaban cepat terkait pendaftaran, asrama, dan administrasi.</p>
                                </div>

                                <!-- Accordion Wrapper -->
                                <div class="space-y-4">
                                    
                                    <!-- FAQ Item 1 -->
                                    <div class="faq-item border-b border-slate-200/80 pb-3 cursor-pointer group">
                                        <div class="faq-trigger flex justify-between items-center text-slate-800 hover:text-[#044E37] transition-colors py-1.5">
                                            <span class="font-bold text-sm md:text-base" style="font-family:'Playfair Display',serif;">Apakah biaya bulanan sudah mencakup makan &amp; asrama?</span>
                                            <span class="faq-chevron transition-transform duration-300 ease-in-out text-[#c9a44a] rotate-0">
                                                <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="18"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </span>
                                        </div>
                                        <div class="faq-content grid grid-rows-[0fr] opacity-0 invisible transition-all duration-300 ease-in-out overflow-hidden">
                                            <div class="min-h-0">
                                                <p class="text-slate-600 text-xs md:text-sm leading-relaxed pt-2 pl-1">
                                                    Ya, biaya syahriah bulanan sudah mencakup seluruh fasilitas kamar asrama, makan 3 kali sehari, layanan kesehatan dasar poskestren, serta bimbingan terpadu santri.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FAQ Item 2 -->
                                    <div class="faq-item border-b border-slate-200/80 pb-3 cursor-pointer group">
                                        <div class="faq-trigger flex justify-between items-center text-slate-800 hover:text-[#044E37] transition-colors py-1.5">
                                            <span class="font-bold text-sm md:text-base" style="font-family:'Playfair Display',serif;">Apakah wali santri bisa mendaftar secara langsung?</span>
                                            <span class="faq-chevron transition-transform duration-300 ease-in-out text-[#c9a44a] rotate-0">
                                                <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="18"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </span>
                                        </div>
                                        <div class="faq-content grid grid-rows-[0fr] opacity-0 invisible transition-all duration-300 ease-in-out overflow-hidden">
                                            <div class="min-h-0">
                                                <p class="text-slate-600 text-xs md:text-sm leading-relaxed pt-2 pl-1">
                                                    Tentu. Pendaftaran secara langsung (offline) dapat dilakukan dengan mengunjungi sekretariat penerimaan santri baru kami di Kecamatan Cigombong, Bogor, pada hari kerja.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FAQ Item 3 -->
                                    <div class="faq-item border-b border-slate-200/80 pb-3 cursor-pointer group">
                                        <div class="faq-trigger flex justify-between items-center text-slate-800 hover:text-[#044E37] transition-colors py-1.5">
                                            <span class="font-bold text-sm md:text-base" style="font-family:'Playfair Display',serif;">Kapan batas waktu pendaftaran ditutup?</span>
                                            <span class="faq-chevron transition-transform duration-300 ease-in-out text-[#c9a44a] rotate-0">
                                                <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="18"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </span>
                                        </div>
                                        <div class="faq-content grid grid-rows-[0fr] opacity-0 invisible transition-all duration-300 ease-in-out overflow-hidden">
                                            <div class="min-h-0">
                                                <p class="text-slate-600 text-xs md:text-sm leading-relaxed pt-2 pl-1">
                                                    Pendaftaran Gelombang 1 akan ditutup pada akhir bulan Mei. Gelombang 2 akan langsung dibuka apabila kuota asrama dan kelas masih tersedia.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FAQ Item 4 -->
                                    <div class="faq-item border-b border-slate-200/80 pb-3 cursor-pointer group">
                                        <div class="faq-trigger flex justify-between items-center text-slate-800 hover:text-[#044E37] transition-colors py-1.5">
                                            <span class="font-bold text-sm md:text-base" style="font-family:'Playfair Display',serif;">Apakah lulusan MTs wajib melanjutkan ke jenjang MA?</span>
                                            <span class="faq-chevron transition-transform duration-300 ease-in-out text-[#c9a44a] rotate-0">
                                                <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="18"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </span>
                                        </div>
                                        <div class="faq-content grid grid-rows-[0fr] opacity-0 invisible transition-all duration-300 ease-in-out overflow-hidden">
                                            <div class="min-h-0">
                                                <p class="text-slate-600 text-xs md:text-sm leading-relaxed pt-2 pl-1">
                                                    Tidak bersifat wajib, namun sangat direkomendasikan agar proses pembinaan karakter, kedisiplinan, dan target hafalan Al-Qur'an (tahfidz) santri dapat tercapai optimal.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- WhatsApp Contact Footer -->
                            <div class="mt-10">
                                <a href="#" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-[#044E37] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#033f2c] transition-colors shadow-md">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.183-.573c.978.581 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.765-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.205.534 1.292.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.666.596 1.218.774 1.393.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                    Tanya Admin via WhatsApp
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </section>


    </main>    <x-footer />

    <!-- Floating Back to Top Bubble (Muncul saat scroll) -->
    <div id="backToTopBtn" class="fixed bottom-8 right-6 md:right-10 z-[90] opacity-0 pointer-events-none transition-all duration-500 translate-y-12">
        <div class="animate-[bounce_3s_infinite]">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    class="relative flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-gradient-to-tr from-[#00a651] to-[#C4D01D] text-white shadow-[0_10px_25px_rgba(0,166,81,0.4)] transition-all duration-300 hover:scale-110 group"
                    style="border-radius: 50% 50% 0 50%;"> <!-- Bentuk gelembung chat -->
                <!-- Efek cahaya gelembung -->
                <div class="absolute top-1.5 left-2.5 w-3 h-3 bg-white/50 rounded-full blur-[1px]"></div>
                
                <svg class="w-6 h-6 md:w-7 md:h-7 ml-0.5 mb-0.5 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 0. FAQ Accordion Dropdown Logic (Smooth Grid Transition)
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const trigger = item.querySelector('.faq-trigger');
                const content = item.querySelector('.faq-content');
                const chevron = item.querySelector('.faq-chevron');

                item.addEventListener('click', () => {
                    const isExpanded = content.classList.contains('grid-rows-[1fr]');

                    // Close all other accordions
                    faqItems.forEach(otherItem => {
                        const otherContent = otherItem.querySelector('.faq-content');
                        const otherChevron = otherItem.querySelector('.faq-chevron');
                        
                        otherContent.classList.remove('grid-rows-[1fr]', 'opacity-100', 'visible');
                        otherContent.classList.add('grid-rows-[0fr]', 'opacity-0', 'invisible');
                        otherChevron.classList.remove('rotate-180');
                        otherChevron.classList.add('rotate-0');
                    });

                    // Toggle selected accordion
                    if (!isExpanded) {
                        content.classList.remove('grid-rows-[0fr]', 'opacity-0', 'invisible');
                        content.classList.add('grid-rows-[1fr]', 'opacity-100', 'visible');
                        chevron.classList.remove('rotate-0');
                        chevron.classList.add('rotate-180');
                    }
                });
            });

            // 1. Dynamic Navbar & Back To Top Scrolled State
            const nav = document.getElementById('main-nav');
            const backToTopBtn = document.getElementById('backToTopBtn');
            
            window.addEventListener('scroll', () => {
                // Navbar logic
                if (window.scrollY > 50) {
                    nav.classList.remove('bg-transparent');
                    nav.classList.add('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg', 'border-b', 'border-white/10');
                } else {
                    nav.classList.add('bg-transparent');
                    nav.classList.remove('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg', 'border-b', 'border-white/10');
                }
                
                // Back to Top logic (muncul setelah scroll 400px)
                if (window.scrollY > 400) {
                    backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                }
            });

            // 2. Mobile Menu Toggle Logic
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
            });

            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
            });

            // 3. Background Slider (Infinite Smooth Loop)
            const track = document.getElementById('slider-track');
            const slides = document.querySelectorAll('.slide-item');
            const slideCount = slides.length;
            
            if (slideCount > 1) {
                // Clone the first slide and append it to create an infinite loop illusion
                const firstClone = slides[0].cloneNode(true);
                track.appendChild(firstClone);
                
                let currentSlide = 0;
                const slideInterval = 5000; // How long a slide stays (5 seconds)
                const transitionTime = 1500; // Must precisely match the CSS duration-[1500ms]
                
                setInterval(() => {
                    currentSlide++;
                    
                    // Restore transitions (removes inline 'none' style if present)
                    track.style.transition = ''; 
                    track.style.transform = `translateX(-${currentSlide * 100}%)`;
                    
                    // Once we slide smoothly to the injected clone slide...
                    if (currentSlide === slideCount) {
                        setTimeout(() => {
                            // Instantly reset to the original real first slide without animating it!
                            track.style.transition = 'none';
                            currentSlide = 0;
                            track.style.transform = `translateX(0%)`;
                        }, transitionTime); // Trigger exactly when the visual slide finishes
                    }
                }, slideInterval);
            }

            // 4. Custom Minimalis Dot Follower (Smooth Delay)
            const cursorDot = document.getElementById('cursor-dot');
            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let dotX = mouseX;
            let dotY = mouseY;

            // Update target koordinat saat mouse bergerak
            window.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });

            // Efek membesar ketika hover pada link/tombol
            const interactables = document.querySelectorAll('a, button, input');
            interactables.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursorDot.style.width = '48px';
                    cursorDot.style.height = '48px';
                    cursorDot.style.backgroundColor = 'rgba(196, 208, 29, 0.3)';
                });
                el.addEventListener('mouseleave', () => {
                    cursorDot.style.width = '32px';
                    cursorDot.style.height = '32px';
                    cursorDot.style.backgroundColor = 'rgba(196, 208, 29, 0.15)';
                });
            });

            // Animasi Loop menggunakan Lerp (Linear Interpolation) untuk efek delay yang sangat halus
            function animateDot() {
                // Faktor 0.15 menentukan seberapa lambat delay-nya (semakin kecil = semakin lambat)
                dotX += (mouseX - dotX) * 0.15;
                dotY += (mouseY - dotY) * 0.15;
                
                cursorDot.style.left = dotX + 'px';
                cursorDot.style.top  = dotY + 'px';
                
                requestAnimationFrame(animateDot);
            }
            animateDot();

            // 5. Animasi Counter Angka Statistik
            const statNumbers = document.querySelectorAll('.stat-number');
            let hasAnimated = false;
            
            const animateStats = () => {
                statNumbers.forEach(stat => {
                    const target = +stat.getAttribute('data-target');
                    const duration = 2000; // durasi animasi 2 detik
                    const increment = target / (duration / 16); // Asumsi 60 fps (16ms per frame)
                    
                    let current = 0;
                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            // Menambahkan koma untuk format ribuan (seperti 2,000)
                            stat.innerText = Math.ceil(current).toLocaleString('en-US');
                            requestAnimationFrame(updateCounter);
                        } else {
                            stat.innerText = target.toLocaleString('en-US');
                        }
                    };
                    updateCounter();
                });
            };

            const statsObserver = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && !hasAnimated) {
                    hasAnimated = true;
                    animateStats();
                }
            }, { threshold: 0.2 }); // Trigger saat 20% bagian ini terlihat
            
            // Target observasi adalah elemen angka yang paling pertama
            if (statNumbers.length > 0) {
                statsObserver.observe(statNumbers[0].closest('.grid'));
            }

        });
    </script>

</body>
</html>
