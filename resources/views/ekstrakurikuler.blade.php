<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - Al-Furqoniyah</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    
    <!-- Vite + Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
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

        /* Custom Asymmetric Hero Clip-path (Sleek Gen Z Slant) */
        .hero-slant {
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        /* Glassmorphism utility */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-[#FAF9F5] antialiased overflow-x-hidden text-[#1E2E2A]">
    
    <x-loader />
    <div id="cursor-dot"></div>
    <x-navbar />
    <!-- HERO WRAPPER - Rounded Diamond Editorial Layout -->
    <div class="relative w-full min-h-[90vh] lg:h-screen flex items-center bg-[#FAF9F5] overflow-hidden">
        
        <!-- Left Geometric Background (Angled Cut) with Premium Batik Kawung SVG Pattern Overlay -->
        <div class="absolute top-0 left-0 h-full w-full lg:w-[55%] bg-gradient-to-br from-[#02281c] to-[#044E37] z-0" style="clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);">
            <!-- Premium traditional Indonesian Batik Kawung SVG pattern overlay (Increased visibility) -->
            <div class="absolute inset-0 opacity-[0.22]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0 C15 0 0 15 0 30 C0 45 15 60 30 60 C45 60 60 45 60 30 C60 15 45 0 30 0 Z' fill='none' stroke='%23C4D01D' stroke-dasharray='2 2' stroke-width='0.75'/%3E%3Cpath d='M30 0 C30 15 15 30 0 30 C15 30 30 45 30 60 C30 45 45 30 60 30 C45 30 30 15 30 0 Z' fill='%23C4D01D'/%3E%3Ccircle cx='30' cy='30' r='3' fill='%23FAF9F5'/%3E%3Ccircle cx='15' cy='15' r='1.5' fill='%23C4D01D'/%3E%3Ccircle cx='45' cy='15' r='1.5' fill='%23C4D01D'/%3E%3Ccircle cx='15' cy='45' r='1.5' fill='%23C4D01D'/%3E%3Ccircle cx='45' cy='45' r='1.5' fill='%23C4D01D'/%3E%3C/svg%3E&quot;); background-size: 60px 60px;"></div>
        </div>

        <!-- Content Container (Increased top padding pt-40 md:pt-44 lg:pt-48 to avoid navbar collision) -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 h-full flex flex-col lg:flex-row items-center pt-40 pb-24 lg:pt-48 lg:pb-32">
            
            <!-- Left Column: Typography & Actions (50%) -->
            <div class="w-full lg:w-1/2 text-left pr-0 lg:pr-12 text-white">

                <!-- Massive Bold Headline (Reduced scale to text-4xl md:text-5xl lg:text-6xl and leading-tight) -->
                <h1 class="font-black text-4xl md:text-5xl lg:text-6xl leading-tight tracking-tight uppercase font-display mb-8">
                    Gali Potensi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#C4D01D] to-[#90a800]">Ekskul Terbaik</span>
                </h1>

                <!-- Clean Underline -->
                <div class="w-20 h-2 bg-[#C4D01D] mb-8 rounded-full"></div>

                <!-- Short Paragraph -->
                <p class="text-white/70 text-sm md:text-lg leading-relaxed max-w-md font-medium mb-12">
                    Jelajahi beragam program ekstrakurikuler unggulan pesantren. Dari bela diri hingga seni dan olahraga, temukan ruang berekspresi untuk mengembangkan bakat dan mencetak prestasi.
                </p>

            </div>

            <!-- Right Column: Rounded Diamond Image Grid (50%) -->
            <div class="w-full lg:w-1/2 mt-16 lg:mt-0 relative flex justify-center items-center h-[600px] lg:h-[800px]">
                
                <!-- Background Decoration to fill empty space -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] z-0 pointer-events-none flex justify-center items-center opacity-40 lg:translate-x-16">
                    <div class="absolute w-[300px] h-[300px] md:w-[550px] md:h-[550px] border-[2px] border-dashed border-[#044E37]/30 rounded-full animate-[spin_60s_linear_infinite]"></div>
                    <div class="absolute w-[400px] h-[400px] md:w-[750px] md:h-[750px] border border-[#044E37]/15 rounded-full animate-[spin_90s_linear_infinite_reverse]"></div>
                    <div class="absolute w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-gradient-to-tr from-[#C4D01D]/30 to-transparent blur-[80px] rounded-full"></div>
                </div>

                <div class="relative w-full max-w-[750px] aspect-square mx-auto pointer-events-none lg:pointer-events-auto lg:translate-x-16 xl:translate-x-20">
                    
                    <!-- Center Large Diamond -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[18rem] h-[18rem] md:w-[24rem] md:h-[24rem] lg:w-[28rem] lg:h-[28rem] rotate-45 rounded-[2.5rem] overflow-hidden shadow-[0_40px_80px_rgba(0,0,0,0.25)] z-20 border-[8px] md:border-[12px] border-[#FAF9F5] group pointer-events-auto">
                        <img src="{{ asset('images/santri.png') }}" class="w-full h-full object-cover -rotate-45 scale-[1.5] transition-transform duration-700 group-hover:scale-[1.6]" alt="Pencak Silat">
                        <div class="absolute inset-0 bg-[#044E37]/10 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    
                    <!-- Top Left Diamond -->
                    <div class="absolute top-[0%] left-[0%] md:-top-[2%] md:left-[2%] lg:-top-[5%] lg:left-[2%] w-48 h-48 md:w-64 md:h-64 lg:w-[19rem] lg:h-[19rem] rotate-45 rounded-[1.8rem] md:rounded-[2rem] overflow-hidden shadow-2xl z-10 border-[6px] md:border-[10px] border-[#FAF9F5] group pointer-events-auto">
                        <img src="{{ asset('images/santri2.png') }}" class="w-full h-full object-cover -rotate-45 scale-[1.5] transition-transform duration-700 group-hover:scale-[1.6]" alt="Hadroh">
                    </div>

                    <!-- Bottom Left Diamond -->
                    <div class="absolute bottom-[5%] left-[10%] md:bottom-[0%] md:left-[15%] lg:-bottom-[2%] lg:left-[15%] w-36 h-36 md:w-52 md:h-52 lg:w-60 lg:h-60 rotate-45 rounded-2xl md:rounded-[1.8rem] overflow-hidden shadow-2xl z-30 border-[6px] md:border-[8px] border-[#FAF9F5] group pointer-events-auto">
                        <img src="{{ asset('images/santri3.png') }}" class="w-full h-full object-cover -rotate-45 scale-[1.5] transition-transform duration-700 group-hover:scale-[1.6]" alt="Kaligrafi">
                    </div>

                    <!-- Right Diamond -->
                    <div class="absolute top-[30%] right-[0%] md:top-[35%] md:-right-[2%] lg:top-[30%] lg:-right-[5%] w-52 h-52 md:w-72 md:h-72 lg:w-[22rem] lg:h-[22rem] rotate-45 rounded-[2rem] md:rounded-[2.5rem] overflow-hidden shadow-2xl z-10 border-[6px] md:border-[10px] border-[#FAF9F5] group pointer-events-auto">
                        <img src="{{ asset('images/masjid 1.png') }}" class="w-full h-full object-cover -rotate-45 scale-[1.5] transition-transform duration-700 group-hover:scale-[1.6]" alt="IT Club">
                    </div>

                </div>

            </div>
            
        </div>
    </div><!-- /END HERO WRAPPER -->

    <!-- FILTER AND BENTO GRID SECTION -->

    <section class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Category Filtering Control Center (Neo-Brutalist Pills) -->
            <div class="flex flex-col items-center mb-20 text-center">
                <span class="text-xs font-black tracking-[0.2em] text-[#044E37] uppercase mb-4">Choose Your Path</span>
                <h2 class="text-3xl md:text-5xl font-black text-[#044E37] uppercase tracking-tight mb-8">Eksplorasi Minat & Bakat</h2>
                
                <div class="flex flex-wrap justify-center items-center gap-3 bg-white p-2.5 rounded-3xl border border-gray-100 shadow-sm max-w-3xl">
                    <button onclick="filterEkskul('semua')" id="btn-semua" class="tab-btn active px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 transform active:scale-95 bg-[#044E37] text-white shadow-md">
                        Semua Bidang
                    </button>
                    <button onclick="filterEkskul('Keagamaan')" id="btn-Keagamaan" class="tab-btn px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 transform active:scale-95 text-gray-500 hover:text-[#044E37] hover:bg-[#044E37]/5">
                        Keagamaan
                    </button>
                    <button onclick="filterEkskul('Keterampilan')" id="btn-Keterampilan" class="tab-btn px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 transform active:scale-95 text-gray-500 hover:text-[#044E37] hover:bg-[#044E37]/5">
                        Keterampilan
                    </button>
                    <button onclick="filterEkskul('Seni')" id="btn-Seni" class="tab-btn px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 transform active:scale-95 text-gray-500 hover:text-[#044E37] hover:bg-[#044E37]/5">
                        Seni & Shalawat
                    </button>
                    <button onclick="filterEkskul('Olahraga')" id="btn-Olahraga" class="tab-btn px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 transform active:scale-95 text-gray-500 hover:text-[#044E37] hover:bg-[#044E37]/5">
                        Olahraga & Bela Diri
                    </button>
                </div>
            </div>

            <!-- BENTO GRID SYSTEM -->
            @php
                $ekskuls = [
                    [
                        'id' => 'silat',
                        'name' => 'Pencak Silat Pagar Nusa',
                        'category' => 'Olahraga',
                        'icon' => '⚔️',
                        'desc' => 'Wadah olah fisik, mental, dan spiritual santri. Menguasai seni bela diri legendaris warisan leluhur Indonesia dengan disiplin tinggi, refleks secepat kilat, dan jiwa kesatria tawadhu.',
                        'jadwal' => 'Ahad Pagi',
                        'pembina' => 'Ustadz H. Abdul Halim'
                    ],
                    [
                        'id' => 'paskibra',
                        'name' => 'Paskibra',
                        'category' => 'Keterampilan',
                        'icon' => '🇮🇩',
                        'desc' => 'Pelatihan tata upacara bendera, baris-berbaris presisi, kedisiplinan, serta pembentukan kepribadian patriotik berkarakter kuat.',
                        'jadwal' => 'Kamis Sore',
                        'pembina' => 'Ustadz Fauzan Azima'
                    ],
                    [
                        'id' => 'hadroh',
                        'name' => 'Hadroh & Shalawat',
                        'category' => 'Seni',
                        'icon' => '🥁',
                        'desc' => 'Ekspresi kecintaan kepada Rasulullah melalui aransemen ketukan rebana modern dan harmoni olah suara.',
                        'jadwal' => 'Malam Sabtu',
                        'pembina' => 'Ustadz Ahmad Rofi\'i, S.Pd.I'
                    ],
                    [
                        'id' => 'kaligrafi',
                        'name' => 'Seni Kaligrafi',
                        'category' => 'Seni',
                        'icon' => '🎨',
                        'desc' => 'Seni melukis ayat Al-Qur\'an secara indah (Khot) guna merawat kehalusan rasa serta motorik halus santri.',
                        'jadwal' => 'Selasa Sore',
                        'pembina' => 'Ustadz Drs. H. Maimun'
                    ],
                    [
                        'id' => 'muhadhoroh',
                        'name' => 'Muhadhoroh',
                        'category' => 'Keagamaan',
                        'icon' => '🎙️',
                        'desc' => 'Pelatihan retorika pidato tiga bahasa (Indonesia, Arab, Inggris) guna melatih keberanian mentalitas dakwah.',
                        'jadwal' => 'Malam Jumat',
                        'pembina' => 'Ustadz M. Yusuf'
                    ],
                    [
                        'id' => 'pramuka',
                        'name' => 'Pramuka',
                        'category' => 'Keterampilan',
                        'icon' => '🧭',
                        'desc' => 'Latihan kecakapan hidup, tali-temali, sandi, semaphore, pertolongan pertama, serta kemandirian berkemah.',
                        'jadwal' => 'Sabtu Siang',
                        'pembina' => 'Ustadz Ahmad Fauzi'
                    ],
                    [
                        'id' => 'marching_band',
                        'name' => 'Marching Band',
                        'category' => 'Seni',
                        'icon' => '🎺',
                        'desc' => 'Kreativitas seni musik perkusi dan tiup dalam format ansambel berbaris. Santri dilatih kekompakan tempo, musikalitas, dan penampilan syiar Islami.',
                        'jadwal' => 'Ahad Pagi',
                        'pembina' => 'Ustadz Rahmat Hidayat'
                    ]
                ];
            @endphp

            <div id="ekskul-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($ekskuls as $index => $ekskul)
                    @if($index == 0)
                        <!-- Card 0 (Hero Card) -->
                        <div class="ekskul-card md:col-span-2 md:row-span-2 bg-[#0B2416] text-[#F9F8F4] p-10 flex flex-col justify-between min-h-[450px] relative overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(11,36,22,0.25)] group" data-category="{{ $ekskul['category'] }}">
                            <!-- Large Index Number -->
                            <span class="text-9xl absolute right-4 top-4 opacity-10 pointer-events-none select-none font-black" style="-webkit-text-stroke: 1px #F9F8F4; color: transparent;">
                                {{ sprintf("%02d", $index + 1) }}
                            </span>
                            
                            <!-- Abstract circle decor -->
                            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-xl pointer-events-none"></div>

                            <!-- Content Top -->
                            <div>
                                <div class="flex justify-between items-start mb-8">
                                    <span class="border border-current px-3 py-1 text-xs uppercase tracking-widest font-mono rounded-none">
                                        {{ $ekskul['icon'] }} {{ $ekskul['category'] }}
                                    </span>
                                </div>

                                <h3 class="tracking-tighter leading-none text-3xl md:text-5xl font-black uppercase mb-6 group-hover:text-[#C4D01D] transition-colors duration-300">
                                    {{ $ekskul['name'] }}
                                </h3>
                                <p class="text-[#FAF9F5]/70 text-sm md:text-base leading-relaxed max-w-xl">
                                    {{ $ekskul['desc'] }}
                                </p>
                            </div>

                            <!-- Content Bottom -->
                            <div class="flex flex-wrap justify-between items-end gap-6 mt-8 z-10">
                                <div class="space-y-1 text-xs text-[#FAF9F5]/60 font-mono uppercase">
                                    <div>Jadwal: <span class="text-[#FAF9F5] font-bold">{{ $ekskul['jadwal'] }}</span></div>
                                    <div>Pembina: <span class="text-[#FAF9F5] font-bold">{{ $ekskul['pembina'] }}</span></div>
                                </div>
                                <button onclick="showEkskulDetail('{{ $ekskul['id'] }}')" class="px-6 py-3 bg-[#C4D01D] hover:bg-[#FAF9F5] text-[#0B2416] font-bold text-xs uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                                    Explore Details <span>➔</span>
                                </button>
                            </div>
                        </div>

                    @elseif($index == 1)
                        <!-- Card 1 (Vertical Card) -->
                        <div class="ekskul-card md:col-span-1 md:row-span-2 bg-white border border-[#0B2416]/10 p-8 flex flex-col justify-between min-h-[450px] relative overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] hover:-translate-y-2 hover:border-[#0B2416] hover:shadow-[0_20px_50px_rgba(11,36,22,0.15)] group" data-category="{{ $ekskul['category'] }}">
                            <!-- Large Index Number -->
                            <span class="text-9xl absolute right-4 top-4 opacity-10 pointer-events-none select-none font-black" style="-webkit-text-stroke: 1px #0B2416; color: transparent;">
                                {{ sprintf("%02d", $index + 1) }}
                            </span>

                            <!-- Content Top -->
                            <div>
                                <div class="flex justify-between items-start mb-8">
                                    <span class="border border-[#0B2416] text-[#0B2416] px-3 py-1 text-xs uppercase tracking-widest font-mono rounded-none">
                                        {{ $ekskul['icon'] }} {{ $ekskul['category'] }}
                                    </span>
                                </div>

                                <h3 class="tracking-tighter leading-none text-2xl md:text-3xl font-black uppercase text-[#0B2416] mb-6 group-hover:text-[#C4D01D] transition-colors duration-300">
                                    {{ $ekskul['name'] }}
                                </h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    {{ $ekskul['desc'] }}
                                </p>
                            </div>

                            <!-- Content Bottom -->
                            <div class="flex flex-col gap-6 mt-8 z-10">
                                <div class="space-y-1 text-xs text-gray-400 font-mono uppercase">
                                    <div>Jadwal: <span class="text-[#0B2416] font-bold">{{ $ekskul['jadwal'] }}</span></div>
                                    <div>Pembina: <span class="text-[#0B2416] font-bold">{{ $ekskul['pembina'] }}</span></div>
                                </div>
                                <button onclick="showEkskulDetail('{{ $ekskul['id'] }}')" class="w-full py-3 bg-[#0B2416] text-[#FAF9F5] hover:bg-[#C4D01D] hover:text-[#0B2416] font-bold text-xs uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-2">
                                    Explore Details <span>➔</span>
                                </button>
                            </div>
                        </div>

                    @else
                        <!-- Card Sisa (Landscape/Square) -->
                        <div class="ekskul-card {{ $index % 2 == 0 ? 'md:col-span-2' : 'md:col-span-1' }} bg-white border border-[#0B2416]/10 p-8 flex flex-col justify-between min-h-[350px] relative overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] hover:-translate-y-2 hover:border-[#0B2416] hover:shadow-[0_20px_50px_rgba(11,36,22,0.15)] group" data-category="{{ $ekskul['category'] }}">
                            <!-- Large Index Number -->
                            <span class="text-9xl absolute right-4 top-4 opacity-10 pointer-events-none select-none font-black" style="-webkit-text-stroke: 1px #0B2416; color: transparent;">
                                {{ sprintf("%02d", $index + 1) }}
                            </span>

                            <!-- Content Top -->
                            <div>
                                <div class="flex justify-between items-start mb-8">
                                    <span class="border border-[#0B2416] text-[#0B2416] px-3 py-1 text-xs uppercase tracking-widest font-mono rounded-none">
                                        {{ $ekskul['icon'] }} {{ $ekskul['category'] }}
                                    </span>
                                </div>

                                <h3 class="tracking-tighter leading-none text-2xl md:text-3xl font-black uppercase text-[#0B2416] mb-6 group-hover:text-[#C4D01D] transition-colors duration-300">
                                    {{ $ekskul['name'] }}
                                </h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    {{ $ekskul['desc'] }}
                                </p>
                            </div>

                            <!-- Content Bottom -->
                            <div class="flex flex-wrap justify-between items-end gap-6 mt-8 z-10">
                                <div class="space-y-1 text-xs text-gray-400 font-mono uppercase">
                                    <div>Jadwal: <span class="text-[#0B2416] font-bold">{{ $ekskul['jadwal'] }}</span></div>
                                    <div>Pembina: <span class="text-[#0B2416] font-bold">{{ $ekskul['pembina'] }}</span></div>
                                </div>
                                <button onclick="showEkskulDetail('{{ $ekskul['id'] }}')" class="px-6 py-3 bg-[#0B2416] text-[#FAF9F5] hover:bg-[#C4D01D] hover:text-[#0B2416] font-bold text-xs uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                                    Explore Details <span>➔</span>
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- PREMIUM DETAILED POPUP MODAL (Gen Z Glassmorphic Card Slider Layout) -->
    <div id="ekskul-modal" class="fixed inset-0 z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 ease-out">
        <!-- Backdrop blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md" onclick="closeEkskulDetail()"></div>
        
        <!-- Modal Content Container -->
        <div id="modal-container" class="relative bg-white rounded-[3rem] w-[92%] max-w-xl p-6 md:p-8 shadow-[0_30px_70px_rgba(0,0,0,0.5)] border border-gray-100 transform scale-95 opacity-0 transition-all duration-300 z-10 flex flex-col max-h-[85vh] overflow-y-auto">
            <!-- Header Ornament -->
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-yellow-400 via-[#044E37] to-yellow-400 rounded-t-[3rem]"></div>
            
            <!-- Close Button (Gen Z Rounded Button Style) -->
            <button onclick="closeEkskulDetail()" class="absolute top-5 right-5 text-gray-400 hover:text-[#044E37] hover:bg-gray-100 p-2.5 rounded-full transition-all focus:outline-none z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <!-- Detailed Content -->
            <div class="mt-4 flex-grow">
                
                <!-- Category badge & Title -->
                <span id="modal-badge" class="inline-block px-3 py-1 bg-yellow-400/20 text-yellow-700 text-[10px] font-black tracking-widest uppercase rounded-full mb-3">Kategori</span>
                <h3 id="modal-name" class="font-black text-2xl md:text-4xl text-[#044E37] uppercase leading-tight mb-4">Nama Ekskul</h3>
                
                <!-- Description -->
                <p id="modal-desc" class="text-sm md:text-base text-gray-500 leading-relaxed mb-6">Deskripsi lengkap mengenai ekstrakurikuler pesantren.</p>
                
                <!-- Details grid (Jadwal & Pembina - Modern block) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-5 rounded-3xl border border-gray-100 mb-6 text-left">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">📅 Jadwal Latihan</span>
                        <span id="modal-jadwal" class="text-xs md:text-sm font-black text-[#044E37] mt-1 block">Hari & Jam</span>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">👤 Pembina</span>
                        <span id="modal-pembina" class="text-xs md:text-sm font-black text-[#044E37] mt-1 block">Nama Pembina</span>
                    </div>
                </div>

                <!-- Competencies Trained -->
                <div class="mb-6 text-left">
                    <h4 class="font-black text-xs text-[#044E37] uppercase tracking-[0.2em] mb-4">Target Kompetensi :</h4>
                    <ul id="modal-comp-list" class="space-y-2.5 text-xs md:text-sm text-gray-600 leading-relaxed">
                        <!-- Filled dynamically -->
                    </ul>
                </div>

                <!-- Prestasi Unggulan -->
                <div class="text-left">
                    <h4 class="font-black text-xs text-[#044E37] uppercase tracking-[0.2em] mb-4">Prestasi Unggulan :</h4>
                    <ul id="modal-ach-list" class="space-y-2.5 text-xs md:text-sm text-gray-600 leading-relaxed">
                        <!-- Filled dynamically -->
                    </ul>
                </div>

            </div>
            
            <!-- Footer action button (Retro Button) -->
            <button onclick="closeEkskulDetail()" class="mt-8 w-full py-4 bg-[#044E37] hover:bg-[#033c2a] text-white font-black text-xs tracking-widest uppercase rounded-2xl transition-all shadow-md active:scale-98">
                Tutup Rincian
            </button>
        </div>
    </div>

    <!-- CTA & INSPIRED CALLOUT (Gen Z Neo-Brutalist Block Banner) -->
    <section class="py-24 bg-[#FAF9F5] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative w-full rounded-[3.5rem] bg-[#044E37] p-8 md:p-16 text-center shadow-[15px_15px_0px_#C4D01D] border-2 border-[#044E37] overflow-hidden">
                <!-- Grid background -->
                <div class="absolute inset-0 z-0 opacity-5" style="background-image: radial-gradient(circle, #C4D01D 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
                
                <!-- Glowing Ambient Lights Inside -->
                <div class="absolute -top-32 -left-32 w-80 h-80 rounded-full bg-emerald-400/20 blur-[80px] pointer-events-none"></div>
                <div class="absolute -bottom-32 -right-32 w-80 h-80 rounded-full bg-yellow-400/10 blur-[80px] pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <span class="inline-block px-3 py-1 bg-yellow-400/10 text-yellow-400 border border-yellow-400/20 text-[9px] font-black tracking-widest uppercase rounded-full mb-6">Ready to join?</span>
                    <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tight mb-6">Gali Potensimu, <br>Raih Prestasimu!</h2>
                    <p class="text-white/70 text-sm md:text-base leading-relaxed mb-10">
                        Pesantren Al-Furqoniyah berkomitmen memadukan kecerdasan spiritual dengan keterampilan praktis demi mencetak generasi emas masa depan.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-block px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-[#044E37] font-black text-xs tracking-widest uppercase rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 border-2 border-white">
                        Hubungi Koordinator Ekskul
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-footer />

    <!-- Floating Back to Top Bubble (Muncul saat scroll) -->
    <div id="backToTopBtn" class="fixed bottom-8 right-6 md:right-10 z-[90] opacity-0 pointer-events-none transition-all duration-500 translate-y-12">
        <div class="animate-[bounce_3s_infinite]">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    class="relative flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-[#044E37] hover:bg-[#033c2a] text-white shadow-[0_10px_25px_rgba(4,78,55,0.4)] border-2 border-yellow-400 transition-all duration-300 hover:scale-110 group"
                    style="border-radius: 50% 50% 0 50%;"> <!-- Bentuk gelembung chat -->
                <div class="absolute top-1.5 left-2.5 w-3 h-3 bg-white/50 rounded-full blur-[1px]"></div>
                <svg class="w-6 h-6 md:w-7 md:h-7 ml-0.5 mb-0.5 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- JS Scripts for Filtering, Popup Modals, and Interactive Effects -->
    <script>
        const ekskulData = {
            muhadhoroh: {
                name: "Muhadhoroh & Khitobah",
                category: "Keagamaan",
                pembina: "Ustadz Muhammad Yusuf, S.H",
                jadwal: "Malam Jumat (Pukul 20.00 - 22.00 WIB)",
                desc: "Muhadhoroh merupakan kawah candradimuka bagi mentalitas dakwah santri. Di sini, para santri dilatih untuk menyusun konsep khutbah, berpidato dalam tiga bahasa (Indonesia, Arab, Inggris), serta memimpin jalannya forum resmi di hadapan ratusan jamaah santri lainnya.",
                competencies: [
                    "Kemampuan berbicara di depan umum (Public Speaking)",
                    "Penguasaan materi dakwah dan retorika pidato",
                    "Keterampilan berbahasa asing (Arab & Inggris)",
                    "Kewibawaan dan rasa percaya diri yang tinggi"
                ],
                achievements: [
                    "Juara 1 Da'i Muda Tingkat Provinsi Jawa Barat (2024)",
                    "Juara 2 Pidato Bahasa Arab Nasional di UIN Syarif Hidayatullah (2023)",
                    "Kaderisasi 100% santri siap terjun khidmat ke masyarakat"
                ]
            },
            kaligrafi: {
                name: "Seni Kaligrafi Islam",
                category: "Seni",
                pembina: "Ustadz Drs. H. Maimun",
                jadwal: "Selasa Sore (Pukul 15.30 - 17.00 WIB)",
                desc: "Seni menulis indah ayat Al-Qur'an (Kaligrafi) diajarkan secara mendalam mulai dari kaidah penulisan dasar (Khot Naskhi, Riq'ah) hingga tingkat mahir (Khot Tsuluts, Diwani, dan Kaligrafi Kontemporer). Kegiatan ini melatih kesabaran, kelembutan hati, dan rasa seni santri.",
                competencies: [
                    "Penguasaan anatomi huruf Arab (Kaidah Khot Klasik)",
                    "Teknik pewarnaan dan dekorasi lukisan kontemporer",
                    "Fokus tinggi dan ketelatenan motorik halus",
                    "Apresiasi estetika seni rupa Islami"
                ],
                achievements: [
                    "Juara 1 Kaligrafi Lukis Tingkat Kabupaten Bogor (2025)",
                    "Juara Harapan 1 MQK (Musabaqah Qira'atil Kutub) Nasional (2023)",
                    "Pameran Seni Kaligrafi Tahunan Pesantren Al-Furqoniyah"
                ]
            },
            hadroh: {
                name: "Hadroh & Shalawat",
                category: "Seni",
                pembina: "Ustadz Ahmad Rofi'i, S.Pd.I",
                jadwal: "Malam Sabtu (Pukul 20.00 - 22.30 WIB)",
                desc: "Mengembangkan bakat musikalitas santri dalam balutan syiar shalawat nabi. Santri diajarkan teknik perkusi hadroh (banjari, habsyi), vokal solo, pembagian harmoni suara, serta aransemen musik rebana modern. Grup hadroh Al-Furqoniyah aktif tampil di berbagai acara resmi daerah.",
                competencies: [
                    "Teknik ketukan perkusi hadroh (lanangan, wedokan, golong)",
                    "Vokal pernapasan diafragma dan kontrol nada shalawat",
                    "Kerjasama tim dan penyelarasan tempo",
                    "Manajemen penampilan panggung (performance art)"
                ],
                achievements: [
                    "Grup Hadroh Terbaik Festival Shalawat Se-Bogor Raya (2024)",
                    "Pengisi Acara Resmi Pembukaan MTQ Tingkat Kabupaten (2024)",
                    "Telah merilis album shalawat kompilasi internal pesantren"
                ]
            },
            pramuka: {
                name: "Kepramukaan (Pramuka)",
                category: "Keterampilan",
                pembina: "Kak Ustadz Ahmad Fauzi, M.Pd",
                jadwal: "Sabtu Siang (Pukul 13.00 - 15.00 WIB)",
                desc: "Gerakan Pramuka di Al-Furqoniyah diintegrasikan dengan kepemimpinan Islam untuk membentuk pribadi santri yang disiplin, mandiri, dan tanggap darurat. Meliputi latihan tali temali, semaphore, navigasi darat, kepemimpinan regu, serta berkemah (Peta & Kompas).",
                competencies: [
                    "Kemandirian hidup di alam bebas (Survival)",
                    "Sandi, Semaphore, dan Morse sebagai alat komunikasi taktis",
                    "Keterampilan pertolongan pertama (P3K) dan tali temali (Pioneering)",
                    "Jiwa kepemimpinan dan bela negara"
                ],
                achievements: [
                    "Regu Berprestasi Tinggi (Juara Umum) Jambore Cabang Bogor (2023)",
                    "Penyelenggara Perkemahan Bakti Santri Se-Jawa Barat (2024)",
                    "Penghargaan Lencana Garuda untuk 5 Santri Teladan (2025)"
                ]
            },
            silat: {
                name: "Pencak Silat (Pagar Nusa)",
                category: "Olahraga",
                pembina: "Ustadz H. Abdul Halim",
                jadwal: "Ahad Pagi (Pukul 06.00 - 08.00 WIB)",
                desc: "Pencak Silat Pagar Nusa merupakan wadah olah fisik, mental, dan spiritual santri. Santri dilatih seni bela diri warisan leluhur nusantara, teknik kembangan, pertarungan tanding, penguatan stamina, serta dididik untuk selalu bersikap tawadhu dan membela kebenaran.",
                competencies: [
                    "Teknik dasar bela diri (pukulan, tendangan, tangkisan, bantingan)",
                    "Kerapian jurus baku IPSI dan jurus paket Pagar Nusa",
                    "Peningkatan kekuatan fisik, refleks, dan stamina",
                    "Pengendalian emosi dan pertahanan spiritual"
                ],
                achievements: [
                    "Juara Umum 3 Kejuaraan Silat Antar Pelajar Jawa Barat (2024)",
                    "2 Medali Emas Kelas Tanding di Turnamen Pencak Silat Bogor (2025)",
                    "Tim demonstrasi silat pada upacara penyambutan tokoh nasional"
                ]
            },
            paskibra: {
                name: "Paskibra",
                category: "Keterampilan",
                pembina: "Ustadz Fauzan Azima",
                jadwal: "Kamis Sore (Pukul 15.30 - 17.00 WIB)",
                desc: "Paskibra melatih santri dalam tata upacara bendera, baris-berbaris presisi, kedisiplinan tingkat tinggi, serta pembentukan kepribadian patriotik berkarakter kuat dan tangguh.",
                competencies: [
                    "Keterampilan baris-berbaris (PBB) dasar dan variasi formasi",
                    "Tata upacara bendera kenegaraan resmi",
                    "Disiplin fisik, ketahanan mental, dan ketepatan waktu",
                    "Jiwa kepemimpinan, kepatuhan komando, dan kerja sama tim"
                ],
                achievements: [
                    "Petugas Pengibar Bendera Hari Kemerdekaan RI Tingkat Kecamatan (2024)",
                    "Juara Harapan 1 Lomba PBB Indah Antar Pondok Pesantren (2025)",
                    "Penghargaan Danton Terbaik Lomba Baris-Berbaris Kabupaten (2025)"
                ]
            },
            marching_band: {
                name: "Marching Band Gema Al-Furqoniyah",
                category: "Seni",
                pembina: "Ustadz Rahmat Hidayat",
                jadwal: "Ahad Pagi (Pukul 08.00 - 10.30 WIB)",
                desc: "Kreativitas seni musik perkusi dan tiup dalam format ansambel berbaris. Santri dilatih kekompakan tempo, musikalitas, penguasaan alat tiup dan drum, serta penampilan visual koreografis untuk syiar Islami.",
                competencies: [
                    "Penguasaan teknik tiup terompet, marching brass, melodeon",
                    "Teknik pukulan snare drum, bass drum, tenor, dan cymbal",
                    "Penyelarasan gerak baris dengan ketukan tempo musik",
                    "Kreativitas koreografi visual lapangan (marching show)"
                ],
                achievements: [
                    "Penampilan utama Pawai Ta'ruf Musabaqah Tilawatil Qur'an Daerah (2024)",
                    "Juara 2 Divisi Brass Festival Marching Band Bogor Raya (2025)",
                    "Penyaji Aransemen Shalawat Terbaik Tingkat Kabupaten (2025)"
                ]
            }
        };

        // Category Filter Logic
        function filterEkskul(category) {
            // Update Active Tab Button Styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-[#044E37]', 'text-white', 'shadow-md');
                btn.classList.add('text-gray-500', 'hover:text-[#044E37]', 'hover:bg-[#044E37]/5');
            });

            const activeBtn = document.getElementById(`btn-${category}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-500', 'hover:text-[#044E37]', 'hover:bg-[#044E37]/5');
                activeBtn.classList.add('active', 'bg-[#044E37]', 'text-white', 'shadow-md');
            }

            // Animate Card Visibility
            const cards = document.querySelectorAll('.ekskul-card');
            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                
                // Add fade-out state
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    if (category === 'semua' || cardCat === category) {
                        // Restore display properties for Bento layouts properly
                        if (card.classList.contains('md:col-span-2')) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'flex'; // grid elements
                        }
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        card.style.display = 'none';
                    }
                }, 300);
            });
        }

        // Show Extracurricular Detailed Modal
        function showEkskulDetail(id) {
            const data = ekskulData[id];
            if (!data) return;

            const modal = document.getElementById('ekskul-modal');
            const container = document.getElementById('modal-container');
            
            document.getElementById('modal-name').innerText = data.name;
            document.getElementById('modal-badge').innerText = data.category;
            document.getElementById('modal-desc').innerText = data.desc;
            document.getElementById('modal-jadwal').innerText = data.jadwal;
            document.getElementById('modal-pembina').innerText = data.pembina;

            // Render Competencies
            const compList = document.getElementById('modal-comp-list');
            compList.innerHTML = '';
            data.competencies.forEach(comp => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-3';
                li.innerHTML = `
                    <span class="text-[#00a651] mt-1 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                    <span class="text-gray-600 font-semibold text-xs md:text-sm">${comp}</span>
                `;
                compList.appendChild(li);
            });

            // Render Achievements
            const achList = document.getElementById('modal-ach-list');
            achList.innerHTML = '';
            data.achievements.forEach(ach => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-3';
                li.innerHTML = `
                    <span class="text-yellow-500 mt-1 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </span>
                    <span class="text-gray-700 font-black text-xs md:text-sm">${ach}</span>
                `;
                achList.appendChild(li);
            });

            // Open Transition
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
            }, 50);

            document.body.style.overflow = 'hidden';
        }

        // Close Modal
        function closeEkskulDetail() {
            const modal = document.getElementById('ekskul-modal');
            const container = document.getElementById('modal-container');

            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = '';
            }, 200);
        }

        // Scrolled Events & Cursor Follower Setup
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('main-nav');
            const backToTopBtn = document.getElementById('backToTopBtn');

            // Scroll Interactions
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    nav?.classList.remove('bg-transparent');
                    nav?.classList.add('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    nav?.classList.add('bg-transparent');
                    nav?.classList.remove('bg-[#044E37]/95', 'backdrop-blur-md', 'shadow-lg');
                }

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
            function bindCursorHovers() {
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
            }

            bindCursorHovers();

            // Re-bind when dynamic modal content might update interactables if needed
            window.showEkskulDetailWithBind = function(id) {
                showEkskulDetail(id);
                bindCursorHovers();
            }

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
