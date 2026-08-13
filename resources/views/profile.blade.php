<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pesantren - Al-Furqoniyah</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Satisfy&display=swap" rel="stylesheet">
    
    <!-- Vite + Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        .font-script { font-family: 'Satisfy', cursive; }
        
        #cursor-dot {
            width: 32px; height: 32px;
            background-color: rgba(196, 208, 29, 0.15);
            border: 2px solid rgba(196, 208, 29, 0.8);
            border-radius: 50%;
            position: fixed; top: 0; left: 0;
            pointer-events: none; z-index: 99999;
            transform: translate(-50%, -50%);
            transition: width 0.2s, height 0.2s, background-color 0.2s;
        }
        @media (max-width: 768px) { #cursor-dot { display: none; } }
    </style>
</head>
<body class="bg-white antialiased overflow-x-hidden">
    
    <x-loader />
    <div id="cursor-dot"></div>
    <x-navbar />

    <!-- HERO SECTION (Geometric Slash & Interlocking Connecting Section) -->
    <div class="relative w-full h-[550px] md:h-[650px] overflow-hidden bg-[#044E37] flex items-center z-10" style="clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);">
        
        <!-- RIGHT SIDE: Full-Bleed Background Image (Mosque) with Cinematic Fade -->
        <div class="absolute inset-y-0 right-0 w-full lg:w-[60%] z-0">
            <img src="{{ asset('images/masjid 1.png') }}" class="w-full h-full object-cover">
            <!-- Cinematic gradient fading overlay merging the mosque smoothly into the dark green canvas on the left -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#044E37] via-[#044E37]/50 to-transparent"></div>
        </div>

        <!-- UNIFIED BACKGROUND GEOMETRIC SLASH RIBBON (Multi-layered, semi-transparent tracks skewing in parallel) -->
        <!-- Track 1: Gold Accent Slash Edge -->
        <div class="absolute inset-0 bg-[#C4D01D]/80 z-12 hidden lg:block" style="clip-path: polygon(48% 0, 48.3% 0, 33.3% 100%, 33% 100%);"></div>

        <!-- Track 2: Translucent Glass Ribbon (Allows background to peek through, creating a 100% unified feel) -->
        <div class="absolute inset-0 bg-white/5 backdrop-blur-[3px] border-x border-white/10 z-10 hidden lg:block" style="clip-path: polygon(48.5% 0, 52.5% 0, 37.5% 100%, 33.5% 100%);"></div>

        <!-- Track 3: High-Contrast White Glow Accent -->
        <div class="absolute inset-0 bg-white/80 z-12 hidden lg:block" style="clip-path: polygon(52.7% 0, 52.9% 0, 37.9% 100%, 37.7% 100%);"></div>

        <!-- Track 4: Soft Secondary Gold Accent Ribbon -->
        <div class="absolute inset-0 bg-[#C4D01D]/40 z-11 hidden lg:block" style="clip-path: polygon(53.1% 0, 53.6% 0, 38.6% 100%, 38.1% 100%);"></div>

        <!-- ORGANIC PALM LEAF OVERLAYS (Cast over the clean geometric slash) -->
        <!-- Top Leaf Overlay (Draped elegantly over the slash peak) -->
        <div class="absolute top-[-30px] left-[32%] w-56 h-56 z-30 pointer-events-none hidden lg:block transform -rotate-12 drop-shadow-[2px_8px_6px_rgba(0,0,0,0.18)]">
            <svg class="w-full h-full text-[#C4D01D]/90" viewBox="0 0 120 120" fill="currentColor">
                <path d="M10,95 Q45,55 105,15 M30,55 Q18,35 6,18 Q22,28 32,42 M45,45 Q35,22 25,2 Q40,15 48,30 M60,35 Q55,12 48,-8 Q58,5 62,20 M75,25 Q75,2 78,-18 Q81,-2 77,12 M90,15 Q95,-4 102,-22 Q98,-4 91,7 M102,8 Q110,-10 118,-28 Q112,-8 103,1"/>
            </svg>
        </div>
        <!-- Bottom Right Leaf Overlay (Framing the image bottom right) -->
        <div class="absolute bottom-[-10px] right-[-10px] w-64 h-64 z-30 pointer-events-none transform rotate-12 drop-shadow-[5px_5px_8px_rgba(0,0,0,0.25)] opacity-85">
            <svg class="w-full h-full text-[#C4D01D]" viewBox="0 0 120 120" fill="currentColor">
                <path d="M10,95 Q45,55 105,15 M30,55 Q18,35 6,18 Q22,28 32,42 M45,45 Q35,22 25,2 Q40,15 48,30 M60,35 Q55,12 48,-8 Q58,5 62,20 M75,25 Q75,2 78,-18 Q81,-2 77,12 M90,15 Q95,-4 102,-22 Q98,-4 91,7 M102,8 Q110,-10 118,-28 Q112,-8 103,1"/>
            </svg>
        </div>

        <!-- TOP RIGHT SOCIAL MEDIA BADGE -->
        <div class="absolute top-8 right-8 z-30 flex flex-col items-end gap-1.5 hidden md:flex text-white">
            <div class="flex gap-2">
                <a href="#" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center text-[10px] transition-all">FB</a>
                <a href="#" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center text-[10px] transition-all">IG</a>
                <a href="#" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center text-[10px] transition-all">YT</a>
            </div>
            <span class="text-[9px] font-bold tracking-wider text-white/70">@pesantren_alfurqoniyah</span>
        </div>

        <!-- MAIN BANNER CONTENT CONTAINER -->
        <div class="relative z-30 max-w-7xl mx-auto px-6 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                
                <!-- Left Side: Editorial Typography & Buttons -->
                <div class="lg:col-span-6 text-left relative z-10 lg:pr-8 py-10 lg:py-0">


                    <!-- Main Dynamic Header (Explore + Bold Text) -->
                    <h1 class="mb-6 select-none leading-none">
                        <!-- Dynamic Handwritten "Explore" (Cursive Satisfy Font matching reference) -->
                        <span class="font-script text-yellow-400 text-5xl md:text-6xl block mb-2 capitalize leading-none transform -rotate-3 origin-left drop-shadow-sm">
                            Jelajahi
                        </span>
                        <!-- Bold Display Text (Set to white for perfect legibility) -->
                        <span class="text-4xl md:text-[3.8rem] font-extrabold text-white tracking-tight uppercase leading-none block font-display">
                            Visi & Sejarah <br>
                            Al-Furqoniyah
                        </span>
                    </h1>

                    <!-- Subtitle tag -->
                    <p class="text-white/70 text-xs md:text-sm font-bold uppercase tracking-[0.2em] mb-10">
                        MEMBENTUK MUSLIM PERSONALITY sejak 1994
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- NOTEPAD PROFILE SECTION -->
    <section class="pt-32 pb-24 bg-[#fdfcf8] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <!-- 1. SIDE TITLE (Teks di Samping) - Diperkecil lebarnya -->
                <div class="lg:w-[10%]">
                    <div class="lg:sticky lg:top-32">
                        <h2 class="text-xl md:text-2xl font-black text-[#044E37] tracking-tighter uppercase lg:[writing-mode:vertical-lr] lg:rotate-180 flex items-center gap-4">
                            <span class="w-1.5 h-12 bg-yellow-400"></span>
                            PROFIL PONDOK PESANTREN AL FURQONIYAH CIGOMBONG BOGOR
                        </h2>
                    </div>
                </div>

                <!-- 2. NOTEPAD UI (Tengah) - Diperlebar -->
                <div class="lg:w-[65%] relative">
                    <!-- Spiral Binding (Kawat Spiral) -->
                    <div class="absolute -top-6 left-0 right-0 flex justify-evenly px-8 z-20">
                        @for ($i = 0; $i < 16; $i++)
                            <div class="w-3.5 h-10 bg-gradient-to-b from-gray-400 via-gray-200 to-gray-400 rounded-full shadow-md border-x border-gray-300"></div>
                        @endfor
                    </div>

                    <!-- Notepad Paper - Tinggi dikurangi (min-h-0) -->
                    <div class="bg-white rounded-b-2xl shadow-2xl border-t-[15px] border-gray-100 relative overflow-hidden notepad-paper p-8 md:p-10">
                        <!-- Margin Red Line -->
                        <div class="absolute top-0 bottom-0 left-10 w-[2px] bg-red-200 opacity-60"></div>
                        
                        <div class="relative z-10 pl-6">
                            <h3 class="text-2xl font-black text-[#11223a] mb-6">Informasi Lembaga</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider w-1/3">Nama Lembaga</td>
                                            <td class="py-2.5 text-gray-700 font-bold text-base">Pondok Pesantren Al Furqoniyah</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Lokasi</td>
                                            <td class="py-2.5 text-gray-700 font-medium text-base">Cigombong, Kab. Bogor, Jawa Barat</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Alamat</td>
                                            <td class="py-2.5 text-gray-600 text-sm">Kampung Citugu, Desa Tugujaya, Kec. Cigombong</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Pendidikan</td>
                                            <td class="py-2.5 text-gray-700 font-bold text-base">MTs dan MA</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Tahun Ops</td>
                                            <td class="py-2.5 text-gray-700 font-medium text-base">± 1970</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Akreditasi</td>
                                            <td class="py-2.5 font-black text-[#00a651] text-lg">A</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Kontak</td>
                                            <td class="py-2.5 text-[#044E37] font-bold text-base text-blue-600">0878-0922-2220</td>
                                        </tr>
                                        <tr class="group">
                                            <td class="py-2.5 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Website</td>
                                            <td class="py-2.5 text-blue-500 font-medium text-sm hover:underline italic">alfurqoniyah.blogspot.com</td>
                                        </tr>
                                        <tr class="group border-b-0">
                                            <td class="py-4 pr-4 font-black text-[#044E37] text-[10px] uppercase tracking-wider">Slogan</td>
                                            <td class="py-4 text-gray-500 font-bold italic text-base leading-tight">“Mencetak Muslim personality, membangun muslim community.”</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <style>
                        .notepad-paper {
                            background-image: repeating-linear-gradient(
                                transparent,
                                transparent 31px,
                                #f1f5f9 31px,
                                #f1f5f9 32px
                            );
                            background-position: 0 32px;
                        }
                    </style>
                </div>

                <!-- 3. FOTO KYAI (Kanan) - Diperkecil rasionya -->
                <div class="lg:w-[25%] relative group">
                    <div class="absolute -inset-4 bg-[#044E37]/10 rounded-[3rem] blur-2xl group-hover:bg-[#044E37]/20 transition-all duration-700"></div>
                    <div class="relative bg-white p-4 rounded-[3rem] shadow-2xl border border-gray-100 transform group-hover:-rotate-3 transition-transform duration-500">
                        <div class="rounded-[2.5rem] overflow-hidden bg-gray-50 border-4 border-[#044E37]/10">
                            <img src="{{ asset('images/kyai.png') }}" alt="Pimpinan Pesantren" class="w-full h-auto grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <div class="mt-6 text-center">
                            <h4 class="text-xl font-black text-[#044E37]">KH. Fulan bin Fulan</h4>
                            <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mt-1">Pengasuh Utama</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- LOGO PHILOSOPHY SECTION (Ancient 3D Scroll) -->
    <section class="py-32 bg-[#fdfcf8] relative overflow-hidden">
        <!-- Overlay debu halus -->
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/pinstriped-suit.png');"></div>

        <div class="max-w-4xl mx-auto px-6">
            <div class="relative flex justify-center">
                
                <!-- GULUNGAN ATAS (3D Effect - Warna Lebih Tua) -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-[92%] h-20 bg-[#8b5e34] z-30 scroll-roll-top border-b border-black/20"></div>

                <!-- THE ANCIENT PAPER (Main Body - Warna Ochre Tua) -->
                <div class="relative bg-[#a67c52] p-10 md:p-20 shadow-[0_40px_80px_rgba(0,0,0,0.6)] torn-paper-3d min-h-[850px] w-full max-w-3xl z-10 border-x border-[#5d4037]/30">
                    
                    <!-- Heavy Paper Texture Overlay -->
                    <div class="absolute inset-0 opacity-70 pointer-events-none mix-blend-multiply" style="background-image: url('https://www.transparenttextures.com/patterns/old-paper.png');"></div>
                    
                    <!-- Burned Edges Gradient -->
                    <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_120px_rgba(0,0,0,0.5)]"></div>

                    <!-- Content Area -->
                    <div class="relative z-10">
                        
                        <!-- Logo INSIDE (Bright & Integrated) -->
                        <div class="text-center mb-16 pt-10">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32 md:w-40 md:h-40 mx-auto object-contain mix-blend-multiply opacity-90 filter sepia-[0.2] contrast-110">
                            <div class="mt-8">
                                <h3 class="text-3xl md:text-5xl font-serif font-black text-[#2b1b0e] tracking-tighter uppercase drop-shadow-sm">Filosofi Logo</h3>
                                <div class="w-24 h-[2px] bg-[#2b1b0e]/30 mx-auto mt-4"></div>
                            </div>
                        </div>

                        <!-- Philosophy List (Text More Sharp/Dark) -->
                        <div class="space-y-12 font-serif text-[#1a1108] text-lg md:text-xl leading-relaxed italic px-4 md:px-10">
                            <div class="flex gap-6 items-start">
                                <div class="text-4xl text-black/40 font-black not-italic">I</div>
                                <p><span class="not-italic text-black font-black uppercase text-[10px] tracking-[0.2em] block mb-1">Hijau Khidmat</span> Kedamaian spiritual dan kesuburan ilmu yang terus tumbuh berkembang.</p>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="text-4xl text-black/40 font-black not-italic">II</div>
                                <p><span class="not-italic text-black font-black uppercase text-[10px] tracking-[0.2em] block mb-1">Kitab Terbuka</span> Semangat tadabbur dan ijtihad dalam memahami risalah langit.</p>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="text-4xl text-black/40 font-black not-italic">III</div>
                                <p><span class="not-italic text-black font-black uppercase text-[10px] tracking-[0.2em] block mb-1">Kubah Emas</span> Puncak tauhid dan kemuliaan akhlak yang menjadi tujuan utama pendidikan.</p>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="text-4xl text-black/40 font-black not-italic">IV</div>
                                <p><span class="not-italic text-black font-black uppercase text-[10px] tracking-[0.2em] block mb-1">Ikatan Ukhuwah</span> Jalinan kasih sayang antar sesama santri yang takkan lekang oleh waktu.</p>
                            </div>
                        </div>

                        <!-- Very Old Wax Seal -->
                        <div class="mt-24 flex justify-center md:justify-end md:pr-10">
                            <div class="relative w-24 h-24 bg-[#4a0404] rounded-full shadow-2xl flex items-center justify-center border-4 border-[#2d0202] transform -rotate-12">
                                <span class="text-white/40 font-serif font-bold text-3xl">AF</span>
                                <div class="absolute -bottom-8 -left-4 w-16 h-24 bg-[#4a0404]/60 -z-10" style="clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 50% 80%, 0% 100%);"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Deep Ambient Shadow for Roll -->
                    <div class="absolute top-0 left-0 right-0 h-28 bg-gradient-to-b from-black/40 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                </div>

                <!-- GULUNGAN BAWAH (3D Effect - Warna Lebih Tua) -->
                <div class="absolute -bottom-14 left-1/2 -translate-x-1/2 w-[95%] h-24 bg-[#8b5e34] z-30 scroll-roll-bottom border-t border-black/10"></div>
            </div>

        </div>
    </section>

    <style>
        .scroll-roll-top {
            background: linear-gradient(to bottom, #4a301a, #8b5e34 50%, #a67c52 100%);
            border-radius: 50% 50% 0 0 / 20px 20px 0 0;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
            clip-path: polygon(2% 0%, 98% 0%, 100% 100%, 0% 100%);
        }
        
        .scroll-roll-bottom {
            background: linear-gradient(to top, #4a301a, #8b5e34 50%, #a67c52 100%);
            border-radius: 0 0 50% 50% / 0 0 30px 30px;
            box-shadow: 0 -15px 30px rgba(0,0,0,0.5);
            clip-path: polygon(0% 0%, 100% 0%, 98% 100%, 2% 100%);
        }

        .torn-paper-3d {
            /* Clip-path khusus fokus pada sobekan sisi kiri dan kanan */
            clip-path: polygon(
                0% 0%, 100% 0%, 
                97% 5%, 100% 15%, 96% 25%, 100% 35%, 97% 45%, 100% 55%, 96% 65%, 100% 75%, 97% 85%, 100% 95%, 
                100% 100%, 0% 100%,
                3% 95%, 0% 85%, 4% 75%, 0% 65%, 3% 55%, 0% 45%, 4% 35%, 0% 25%, 3% 15%, 0% 5%
            );
        }
    </style>

    <!-- VISI, MISI & TUJUAN SECTION (High Visibility Light Theme) -->
    <section class="relative bg-[#fdfcf8] pt-40 pb-32 overflow-hidden">
        
        <!-- Organic Top Edge (Custom Wave) -->
        <div class="absolute top-0 left-0 right-0 h-32 bg-white shadow-sm" style="clip-path: ellipse(70% 100% at 50% 0%);"></div>

        <!-- Pattern Latar Belakang Halus -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/islamic-art.png');"></div>

        <div class="max-w-[1440px] mx-auto px-6 lg:px-16 relative z-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
                
                <!-- COLUMN 1: VISI & MISI -->
                <div class="lg:col-span-4 flex flex-col gap-8">
                    <!-- Visi Card -->
                    <div class="bg-white border-l-8 border-[#044E37] p-10 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform">
                                <svg class="w-6 h-6 text-[#044E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <h2 class="text-3xl font-black text-[#044E37] tracking-tighter uppercase">Visi</h2>
                        </div>
                        <p class="text-[17px] leading-relaxed text-gray-700 font-bold italic">
                            "Menjadi pusat keunggulan pendidikan Islam terpadu yang melahirkan kader Ulamaul 'Amilin berlandaskan iman, ilmu, dan akhlak mulia."
                        </p>
                    </div>

                    <!-- Misi Card -->
                    <div class="bg-white p-10 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] flex-grow border border-gray-100">
                        <h2 class="text-3xl font-black text-[#044E37] mb-8 tracking-tighter uppercase flex items-center gap-3">
                            <span class="w-10 h-1.5 bg-yellow-400 rounded-full"></span> Misi
                        </h2>
                        <ul class="space-y-6">
                            <li class="flex gap-5 group">
                                <span class="w-8 h-8 rounded-full bg-[#044E37] flex items-center justify-center text-[11px] font-black text-white shrink-0 group-hover:bg-yellow-400 group-hover:text-[#044E37] transition-all">01</span>
                                <p class="text-[15px] text-gray-800 leading-relaxed font-black">Menyelenggarakan pendidikan tahfidz dan sains yang kompetitif secara global.</p>
                            </li>
                            <li class="flex gap-5 group">
                                <span class="w-8 h-8 rounded-full bg-[#044E37] flex items-center justify-center text-[11px] font-black text-white shrink-0 group-hover:bg-yellow-400 group-hover:text-[#044E37] transition-all">02</span>
                                <p class="text-[15px] text-gray-800 leading-relaxed font-black">Membentuk karakter santri yang responsif, berakhlak, dan inovatif.</p>
                            </li>
                            <li class="flex gap-5 group">
                                <span class="w-8 h-8 rounded-full bg-[#044E37] flex items-center justify-center text-[11px] font-black text-white shrink-0 group-hover:bg-yellow-400 group-hover:text-[#044E37] transition-all">03</span>
                                <p class="text-[15px] text-gray-800 leading-relaxed font-black">Membangun kemandirian ekonomi umat melalui jiwa entrepreneurship santri.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- COLUMN 2: PORTRAIT -->
                <div class="lg:col-span-4 flex flex-col items-center justify-center relative py-16 lg:py-0">
                    <div class="relative">
                        <!-- Decorative Circles -->
                        <div class="absolute inset-0 bg-[#044E37]/5 rounded-full blur-3xl scale-150"></div>
                        
                        <div class="relative w-[320px] md:w-[380px] aspect-[4/5] rounded-[3rem] overflow-hidden shadow-[0_40px_80px_rgba(4,78,55,0.2)] border-8 border-white">
                            <img src="{{ asset('images/kyai.png') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#044E37]/40 via-transparent to-transparent"></div>
                        </div>

                        <!-- Badge Pimpinan -->
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-white px-10 py-6 rounded-[2rem] shadow-2xl text-center w-[90%] border-t-4 border-yellow-400">
                            <h4 class="text-[#044E37] font-black text-lg tracking-tight">KH. Fulan bin Fulan</h4>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Pimpinan Pondok Pesantren</p>
                        </div>
                    </div>
                </div>

                <!-- COLUMN 3: TUJUAN -->
                <div class="lg:col-span-4 bg-white p-10 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col">
                    <h2 class="text-3xl font-black text-[#044E37] mb-10 tracking-tighter uppercase flex items-center justify-between">
                        Tujuan 
                        <svg class="w-10 h-10 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </h2>
                    <ul class="space-y-8 flex-grow">
                        <li class="flex items-start gap-4">
                            <div class="mt-2 w-3 h-3 rounded-full bg-yellow-400 shadow-[0_0_15px_#facc15] shrink-0"></div>
                            <p class="text-[16px] text-[#044E37] leading-relaxed font-black">Mencetak alumni mahir kitab kuning dan sains modern.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-2 w-3 h-3 rounded-full bg-yellow-400 shadow-[0_0_15px_#facc15] shrink-0"></div>
                            <p class="text-[16px] text-[#044E37] leading-relaxed font-black">Mewujudkan lingkungan pendidikan religius dan asri.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-2 w-3 h-3 rounded-full bg-yellow-400 shadow-[0_0_15px_#facc15] shrink-0"></div>
                            <p class="text-[16px] text-[#044E37] leading-relaxed font-black">Menghasilkan karya tulis ilmiah bermanfaat bagi umat.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-2 w-3 h-3 rounded-full bg-yellow-400 shadow-[0_0_15px_#facc15] shrink-0"></div>
                            <p class="text-[16px] text-[#044E37] leading-relaxed font-black">Membangun jejaring alumni nasional dan internasional.</p>
                        </li>
                    </ul>
                    
                    <div class="mt-12">
                        <a href="#" class="group flex items-center gap-4 text-[#044E37] font-black text-sm">
                            <span class="w-14 h-14 bg-[#044E37] rounded-full flex items-center justify-center text-white group-hover:bg-yellow-400 group-hover:text-[#044E37] transition-all shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                            PELAJARI LEBIH LANJUT
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ORGANIZATIONAL STRUCTURE SECTION (Clear Branching Tree) -->
    <section class="py-20 md:py-32 bg-[#fdfcf8] relative overflow-hidden">
        
        <style>
            @keyframes flow {
                from { background-position: 0 0; }
                to { background-position: 20px 20px; }
            }
            .flow-line-v {
                width: 2px;
                background-image: linear-gradient(to bottom, #044E37 50%, transparent 50%);
                background-size: 2px 15px;
                animation: flow 1s linear infinite;
            }
            .flow-line-h {
                height: 2px;
                background-image: linear-gradient(to right, #044E37 50%, transparent 50%);
                background-size: 15px 2px;
                animation: flow 1s linear infinite;
            }
            .level-badge {
                writing-mode: vertical-rl;
                text-orientation: mixed;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10">
            <div class="text-center mb-16 md:mb-24">
                <h2 class="text-[10px] md:text-sm font-black text-[#044E37] uppercase tracking-[0.4em] mb-3 md:mb-4">Susunan Pengurus</h2>
                <h3 class="text-3xl md:text-5xl font-serif font-black text-[#044E37] tracking-tight">Struktur Organisasi</h3>
                <div class="w-16 md:w-24 h-1 md:h-1.5 bg-yellow-400 mx-auto mt-4 md:mt-6 rounded-full"></div>
            </div>

            <div class="flex flex-col items-center">
                
                <!-- LEVEL 1: TOP LEADERSHIP -->
                <div class="relative flex flex-col items-center mb-24 w-full">
                    <!-- Level Indicator -->
                    <div class="absolute -left-2 md:left-20 top-0 h-full flex flex-col items-center opacity-20 hidden sm:flex">
                        <span class="text-[10px] font-black uppercase tracking-widest level-badge py-4 border-l border-[#044E37]">PIMPINAN</span>
                    </div>

                    <div class="z-20 flex flex-col items-center cursor-pointer group/card" onclick="showJobDesc('pengasuh')">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-yellow-400/20 rounded-full blur-2xl opacity-50 group-hover/card:bg-yellow-400/30 transition-all duration-300"></div>
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-[#044E37] group-hover/card:border-yellow-400 p-1.5 bg-white shadow-2xl relative transition-all duration-300 transform group-hover/card:scale-105">
                                <img src="{{ asset('images/kyai.png') }}" class="w-full h-full object-cover rounded-full">
                                <div class="absolute -bottom-2 -right-2 bg-yellow-400 text-[#044E37] w-8 h-8 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 bg-[#044E37] group-hover/card:bg-[#033c2a] text-white px-8 py-4 rounded-2xl shadow-xl text-center border-b-4 border-yellow-400 max-w-[280px] md:max-w-none transition-all duration-300 transform group-hover/card:scale-105">
                            <h4 class="font-black text-lg md:text-2xl tracking-tight uppercase">KH. Fulan bin Fulan</h4>
                            <p class="text-[9px] md:text-[11px] font-bold text-yellow-400 mt-1 uppercase tracking-widest">Pengasuh Utama (Murobbi)</p>
                            <span class="block text-[8px] text-white/50 mt-1 uppercase tracking-wider italic">Klik untuk Detail Tugas</span>
                        </div>
                    </div>
                    <!-- Animated Line Down -->
                    <div class="absolute top-full left-1/2 -translate-x-1/2 h-24 w-0.5 flow-line-v z-10"></div>
                </div>

                <!-- LEVEL 2: YAYASAN & SEKRETARIS (Branching Layout) -->
                <div class="relative w-full max-w-5xl mb-24 pt-12">
                    <!-- Branch Lines -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[80%] md:w-[60%] h-0.5 flow-line-h"></div>
                    <div class="absolute top-0 left-[10%] h-12 w-0.5 flow-line-v"></div>
                    <div class="absolute top-0 right-[10%] h-12 w-0.5 flow-line-v"></div>

                    <div class="grid grid-cols-2 gap-4 md:gap-40">
                        @foreach([
                            ['id' => 'yayasan', 'role' => 'Ketua Yayasan', 'name' => 'Ustadz Ahmad Fauzi, M.Pd'],
                            ['id' => 'sekretaris', 'role' => 'Sekretaris Umum', 'name' => 'Ustadz Muhammad Yusuf, S.H']
                        ] as $item)
                        <div class="flex flex-col items-center">
                            <div class="z-20 bg-white border-2 border-[#044E37]/10 hover:border-yellow-400 p-3 md:p-6 rounded-[2rem] shadow-lg text-center w-full max-w-[160px] md:max-w-[280px] hover:shadow-2xl transition-all duration-300 cursor-pointer group/card transform hover:-translate-y-1" onclick="showJobDesc('{{ $item['id'] }}')">
                                <div class="w-16 h-16 md:w-24 md:h-24 mx-auto rounded-full border-2 border-dotted border-gray-200 p-1 mb-4 group-hover/card:border-yellow-400 transition-colors">
                                    <img src="{{ asset('images/santri3.png') }}" class="w-full h-full object-cover rounded-full opacity-80">
                                </div>
                                <h4 class="font-black text-[10px] md:text-lg text-[#044E37] uppercase leading-tight group-hover/card:text-[#033c2a]">{{ $item['name'] }}</h4>
                                <p class="text-[7px] md:text-[10px] font-bold text-gray-400 mt-1 uppercase">{{ $item['role'] }}</p>
                                <span class="block text-[6px] md:text-[8px] text-[#044E37]/50 mt-1.5 italic group-hover/card:text-yellow-500">Klik untuk Tugas</span>
                            </div>
                            <!-- Line Down -->
                            <div class="h-16 w-0.5 flow-line-v opacity-30 mt-2"></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- LEVEL 3: KEPALA BIDANG (Three Columns) -->
                <div class="relative w-full max-w-6xl pt-10">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[90%] h-0.5 flow-line-h opacity-20"></div>
                    
                    <div class="grid grid-cols-3 gap-2 md:gap-8">
                        @foreach([
                            ['id' => 'bendahara', 'icon' => 'bank', 'role' => 'Bendahara', 'name' => 'Ustadz H. Abdul Halim'],
                            ['id' => 'madrasah', 'icon' => 'book', 'role' => 'K. Madrasah', 'name' => 'Ustadz Drs. H. Maimun'],
                            ['id' => 'pengasuhan', 'icon' => 'shield', 'role' => 'K. Pengasuhan', 'name' => 'Ustadz Ahmad Rofi\'i']
                        ] as $bidang)
                        <div class="flex flex-col items-center">
                            <div class="absolute top-0 h-10 w-0.5 flow-line-v opacity-20"></div>
                            
                            <div class="z-20 mt-10 bg-white border-t-4 border-[#044E37] hover:border-yellow-400 p-2 md:p-6 rounded-xl shadow-md text-center w-full cursor-pointer hover:shadow-2xl transition-all duration-300 group/card transform hover:-translate-y-1" onclick="showJobDesc('{{ $bidang['id'] }}')">
                                <div class="w-8 h-8 md:w-12 md:h-12 mx-auto bg-gray-50 group-hover/card:bg-yellow-50 rounded-lg flex items-center justify-center mb-2 transition-colors">
                                    <svg class="w-4 h-4 md:w-6 md:h-6 text-[#044E37]/30 group-hover/card:text-[#044E37]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                </div>
                                <h4 class="font-black text-[8px] md:text-sm text-[#044E37] uppercase leading-tight group-hover/card:text-[#033c2a]">{{ $bidang['name'] }}</h4>
                                <p class="text-[6px] md:text-[9px] font-bold text-gray-400 mt-1 uppercase">{{ $bidang['role'] }}</p>
                                <span class="block text-[5px] md:text-[8px] text-[#044E37]/40 mt-1 italic group-hover/card:text-yellow-600">Klik untuk Tugas</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- LEVEL 4: STAF & ASATIDZ (Grid Panel) -->
                <div class="mt-24 w-full max-w-4xl bg-[#044E37]/5 rounded-[3rem] p-8 md:p-12 border-2 border-dashed border-[#044E37]/10 text-center">
                    <span class="px-6 py-2 bg-white rounded-full text-[9px] md:text-[11px] font-black text-[#044E37] uppercase tracking-widest shadow-sm mb-10 inline-block border border-[#044E37]/10">Asatidz & Staf Pelaksana (Klik untuk Detail Tugas)</span>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                        @foreach([
                            ['id' => 'staf_pengajar', 'label' => 'Pengajar'],
                            ['id' => 'staf_keamanan', 'label' => 'Keamanan'],
                            ['id' => 'staf_logistik', 'label' => 'Logistik'],
                            ['id' => 'staf_dapur', 'label' => 'Dapur']
                        ] as $staf)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-white hover:border-yellow-400 hover:shadow-md cursor-pointer transition-all duration-300 transform hover:-translate-y-1 active:scale-95 text-center group/card" onclick="showJobDesc('{{ $staf['id'] }}')">
                            <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full mx-auto mb-2 group-hover/card:scale-125 transition-transform"></div>
                            <h5 class="text-[10px] md:text-xs font-bold text-[#044E37] uppercase tracking-tighter">{{ $staf['label'] }}</h5>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- Premium Job Description Modal / Popup -->
        <div id="job-desc-modal" class="fixed inset-0 z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 ease-out">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeJobDesc()"></div>
            
            <!-- Modal Content Container -->
            <div id="modal-container" class="relative bg-white rounded-[2rem] w-[90%] max-w-lg p-6 md:p-8 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.4)] border border-gray-100 transform scale-95 opacity-0 transition-all duration-300 z-10 flex flex-col">
                <!-- Header Ornament -->
                <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-yellow-400 via-[#044E37] to-yellow-400 rounded-t-[2rem]"></div>
                
                <!-- Close Button -->
                <button onclick="closeJobDesc()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all focus:outline-none z-20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Profile Info Inside Modal -->
                <div class="flex items-center gap-4 border-b border-gray-100 pb-5 mb-5 mt-2">
                    <div id="modal-image-container" class="w-16 h-16 md:w-20 md:h-20 rounded-full border-2 border-dotted border-[#044E37] p-1 flex-shrink-0 bg-gray-50 flex items-center justify-center">
                        <img id="modal-image" src="" class="w-full h-full object-cover rounded-full hidden">
                        <div id="modal-icon-placeholder" class="w-full h-full bg-[#044E37]/10 text-[#044E37] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 id="modal-name" class="font-black text-lg md:text-xl text-[#044E37] uppercase leading-tight">Nama</h3>
                        <p id="modal-role" class="text-xs md:text-sm font-bold text-yellow-500 uppercase tracking-wider mt-1">Jabatan</p>
                    </div>
                </div>
                
                <!-- Tasks & Responsibilities Content -->
                <div class="flex-grow">
                    <h4 class="font-black text-xs md:text-sm text-[#044E37] uppercase tracking-[0.2em] mb-4">Tugas & Wewenang :</h4>
                    <ul id="modal-tasks-list" class="space-y-4 text-sm text-gray-600 leading-relaxed text-left">
                        <!-- Dynamic tasks list goes here -->
                    </ul>
                </div>
                
                <!-- Footer action button -->
                <button onclick="closeJobDesc()" class="mt-8 w-full py-3 bg-[#044E37] hover:bg-[#033c2a] text-white font-bold text-sm rounded-xl transition-all shadow-md active:scale-98">
                    Tutup Deskripsi
                </button>
            </div>
        </div>

        <script>
            const jobDescriptions = {
                pengasuh: {
                    name: "KH. Fulan bin Fulan",
                    role: "Pengasuh Utama (Murobbi)",
                    image: "{{ asset('images/kyai.png') }}",
                    tasks: [
                        "Merumuskan dan menentukan arah kebijakan umum pondok pesantren sesuai nilai syariat Islam.",
                        "Mengawasi dan membimbing seluruh aspek tarbiyah (pendidikan) dan spiritual santri secara berkala.",
                        "Memberikan fatwa, nasihat spiritual, serta penentu keputusan strategis tertinggi di pesantren."
                    ]
                },
                yayasan: {
                    name: "Ustadz Ahmad Fauzi, M.Pd",
                    role: "Ketua Yayasan",
                    image: "{{ asset('images/santri3.png') }}",
                    tasks: [
                        "Mengelola administrasi legalitas, sarana prasarana, serta keuangan yayasan secara mandiri.",
                        "Mewakili lembaga dalam hubungan eksternal dengan pemerintah, donatur, dan masyarakat umum.",
                        "Menyusun rencana strategis pengembangan jangka panjang sarana fisik pesantren."
                    ]
                },
                sekretaris: {
                    name: "Ustadz Muhammad Yusuf, S.H",
                    role: "Sekretaris Umum",
                    image: "{{ asset('images/santri3.png') }}",
                    tasks: [
                        "Mengelola tata usaha persuratan, pengarsipan berkas dinas, dan dokumentasi rapat lembaga.",
                        "Menyusun laporan berkala operasional yayasan kepada Ketua Yayasan dan Pengasuh.",
                        "Mengoordinasikan komunikasi administratif antar bidang di lingkungan pesantren."
                    ]
                },
                bendahara: {
                    name: "Ustadz H. Abdul Halim",
                    role: "Bendahara (Keuangan)",
                    tasks: [
                        "Mengatur sirkulasi arus kas keluar-masuk dana pesantren dan menyusun pembukuan keuangan bulanan.",
                        "Mengelola administrasi syahriah (SPP) santri serta pembayaran operasional staf/asatidz.",
                        "Menyusun laporan audit keuangan secara transparan dan akuntabel kepada pimpinan."
                    ]
                },
                madrasah: {
                    name: "Ustadz Drs. H. Maimun",
                    role: "Kepala Madrasah (Pendidikan)",
                    tasks: [
                        "Menyusun kurikulum pendidikan formal/non-formal di pesantren agar selaras dengan Kementerian Agama.",
                        "Mengawasi proses belajar mengajar (KBM) harian serta melakukan supervisi kinerja guru/asatidz.",
                        "Menyelenggarakan ujian penilaian berkala, penentuan kelulusan, dan evaluasi hasil belajar santri."
                    ]
                },
                pengasuhan: {
                    name: "Ustadz Ahmad Rofi'i, S.Pd.I",
                    role: "Kepala Pengasuhan",
                    tasks: [
                        "Bertanggung jawab penuh terhadap kedisiplinan, ketertiban, dan akhlak santri selama 24 jam di asrama.",
                        "Mengatur pembagian kamar, kebersihan lingkungan, serta perizinan keluar-masuk santri.",
                        "Menangani konseling santri bermasalah serta berkoordinasi dengan wali santri terkait perkembangan karakter."
                    ]
                },
                staf_pengajar: {
                    name: "Asatidz & Pengajar",
                    role: "Staf Akademik",
                    tasks: [
                        "Menyampaikan ilmu keagamaan (kitab kuning, tahfidz, materi madrasah) kepada para santri secara konsisten.",
                        "Menjadi teladan akhlakul karimah (akhlak mulia) dalam keseharian di lingkungan pesantren.",
                        "Melakukan evaluasi pembelajaran harian dan melaporkan perkembangan akademis santri ke Kepala Madrasah."
                    ]
                },
                staf_keamanan: {
                    name: "Tim Keamanan",
                    role: "Staf Ketertiban",
                    tasks: [
                        "Menjaga stabilitas ketertiban, keamanan fisik, dan memantau gerbang masuk-keluar pondok pesantren.",
                        "Menertibkan santri yang melakukan pelanggaran disiplin atau tidak mengikuti jadwal kegiatan wajib.",
                        "Melakukan ronda malam berkala untuk memastikan kenyamanan istirahat seluruh warga pondok."
                    ]
                },
                staf_logistik: {
                    name: "Tim Logistik",
                    role: "Sarana & Prasarana",
                    tasks: [
                        "Menyediakan, mendistribusikan, dan memelihara seluruh inventaris barang serta sarana prasarana penunjang kegiatan.",
                        "Memastikan pasokan kebutuhan harian pondok (listrik, air, alat tulis kantor) terpenuhi tanpa hambatan.",
                        "Melakukan inventarisasi berkala dan pengadaan aset baru yang disetujui pihak yayasan."
                    ]
                },
                staf_dapur: {
                    name: "Tim Dapur",
                    role: "Konsumsi & Gizi",
                    tasks: [
                        "Merencanakan menu makanan sehat bergizi seimbang untuk kebutuhan konsumsi harian seluruh santri dan asatidz.",
                        "Menjaga tingkat kebersihan, sanitasi ruang dapur, serta peralatan memasak dengan standar tinggi.",
                        "Mengatur jadwal distribusi makanan harian santri secara tertib dan terjadwal pagi, siang, dan sore."
                    ]
                }
            };

            function showJobDesc(id) {
                const data = jobDescriptions[id];
                if (!data) return;

                const modal = document.getElementById('job-desc-modal');
                const container = document.getElementById('modal-container');
                const img = document.getElementById('modal-image');
                const iconPlaceholder = document.getElementById('modal-icon-placeholder');
                
                document.getElementById('modal-name').innerText = data.name;
                document.getElementById('modal-role').innerText = data.role;
                
                if (data.image) {
                    img.src = data.image;
                    img.classList.remove('hidden');
                    iconPlaceholder.classList.add('hidden');
                } else {
                    img.classList.add('hidden');
                    iconPlaceholder.classList.remove('hidden');
                }

                const list = document.getElementById('modal-tasks-list');
                list.innerHTML = '';
                data.tasks.forEach(task => {
                    const li = document.createElement('li');
                    li.className = 'flex items-start gap-3';
                    li.innerHTML = `
                        <span class="text-yellow-400 mt-1 flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </span>
                        <span>${task}</span>
                    `;
                    list.appendChild(li);
                });

                modal.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                }, 50);

                document.body.style.overflow = 'hidden';
            }

            function closeJobDesc() {
                const modal = document.getElementById('job-desc-modal');
                const container = document.getElementById('modal-container');

                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = '';
                }, 200);
            }
        </script>
    </section>

    <!-- LEADERSHIP QUOTE SECTION — Asymmetrical Editorial Layout -->
    <section class="py-20 lg:py-28 bg-[#fdfcf7] relative overflow-hidden border-t border-gray-200/60">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/islamic-art.png');"></div>
        
        <div class="max-w-5xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                
                {{-- Left Column: Arched Profile Frame (1/3 Width) --}}
                <div class="md:col-span-1 flex justify-center">
                    <div class="relative w-64 md:w-72 aspect-[3/4] group">
                        <!-- Offset Gold Back-Card -->
                        <div class="absolute inset-0 bg-[#c9a44a]/10 rounded-t-[100px] rounded-b-2xl translate-x-3 translate-y-3 transition-transform duration-500 group-hover:translate-x-1.5 group-hover:translate-y-1.5"></div>
                        
                        <!-- Main Arched Image Container -->
                        <div class="relative w-full h-full rounded-t-[100px] rounded-b-2xl overflow-hidden border-4 border-white shadow-xl bg-white">
                            <img src="{{ asset('images/kyai.png') }}" 
                                 alt="KH. Fulan bin Fulan" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </div>

                {{-- Right Column: Quote & Accents (2/3 Width) --}}
                <div class="md:col-span-2 relative pl-2 md:pl-6">
                    <!-- Massive Decorative Gold Quote Mark -->
                    <div class="absolute -top-16 left-0 text-[11rem] font-serif text-[#c9a44a]/10 leading-none pointer-events-none select-none" style="font-family:'Playfair Display',serif;">
                        “
                    </div>

                    <div class="relative z-10 flex flex-col justify-center">
                        <!-- Vertical Gold Accent Line Anchor -->
                        <div class="border-l-2 border-[#c9a44a]/40 pl-6 md:pl-8">
                            <p class="text-xl md:text-2xl lg:text-[1.65rem] text-[#044E37] font-serif italic leading-relaxed mb-6" style="font-family:'Playfair Display','Georgia',serif;">
                                "Pendidikan adalah khidmah tertinggi kita kepada ummat. Di Al-Furqoniyah, kami tidak hanya mengajar, tapi kami membimbing jiwa menuju Ridho-Nya."
                            </p>
                            <div>
                                <h4 class="text-[#c9a44a] font-bold tracking-[0.2em] text-sm md:text-base uppercase">
                                    KH. Fulan bin Fulan
                                </h4>
                                <p class="text-slate-400 text-[10px] md:text-xs mt-1 uppercase tracking-widest">
                                    Pengasuh Pondok Pesantren
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <x-footer />

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('main-nav');
            const backToTopBtn = document.getElementById('backToTopBtn');

            window.addEventListener('scroll', () => {
                // Navbar scroll logic
                if (window.scrollY > 50) {
                    nav?.classList.remove('bg-transparent');
                    nav?.classList.add('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    nav?.classList.add('bg-transparent');
                    nav?.classList.remove('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                }

                // Back to Top logic (show/hide on scroll > 400px)
                if (window.scrollY > 400) {
                    backToTopBtn?.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn?.classList.add('opacity-100', 'translate-y-0');
                } else {
                    backToTopBtn?.classList.add('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn?.classList.remove('opacity-100', 'translate-y-0');
                }
            });

            // Cursor follower logic
            const cursorDot = document.getElementById('cursor-dot');
            let mouseX = window.innerWidth / 2, mouseY = window.innerHeight / 2, dotX = mouseX, dotY = mouseY;
            
            window.addEventListener('mousemove', (e) => { 
                mouseX = e.clientX; 
                mouseY = e.clientY; 
            });

            // Scale follower on hovering interactive elements
            const interactables = document.querySelectorAll('a, button, input');
            interactables.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    if (cursorDot) {
                        cursorDot.style.width = '48px';
                        cursorDot.style.height = '48px';
                        cursorDot.style.backgroundColor = 'rgba(196, 208, 29, 0.3)';
                    }
                });
                el.addEventListener('mouseleave', () => {
                    if (cursorDot) {
                        cursorDot.style.width = '32px';
                        cursorDot.style.height = '32px';
                        cursorDot.style.backgroundColor = 'rgba(196, 208, 29, 0.15)';
                    }
                });
            });

            function animateDot() {
                dotX += (mouseX - dotX) * 0.15; 
                dotY += (mouseY - dotY) * 0.15;
                if(cursorDot) { 
                    cursorDot.style.left = dotX + 'px'; 
                    cursorDot.style.top = dotY + 'px'; 
                }
                requestAnimationFrame(animateDot);
            }
            animateDot();
        });
    </script>
</body>
</html>
