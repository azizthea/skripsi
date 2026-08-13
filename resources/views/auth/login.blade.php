<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Al-Furqoniyah</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jaini+Purva&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN untuk mengatasi isu CSS saat diakses dari HP via IP lokal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 antialiased overflow-x-hidden">

    <!-- Header / Navbar (Original Style) -->
    <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent">
        
        <!-- Absolute Logo Pill -->
        <div class="absolute top-0 left-4 sm:left-8 lg:left-20 xl:left-32 z-30">
            <div class="bg-white pt-2 lg:pt-3 pb-4 lg:pb-5 px-1.5 rounded-b-[30px] md:rounded-b-[40px] shadow-[0_10px_20px_rgba(0,0,0,0.3)] flex items-center justify-center w-20 md:w-24 lg:w-28 border-b-4 border-[#044E37]">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Furqoniyah" class="w-14 h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 object-contain hover:scale-105 transition-transform duration-300">
            </div>
        </div>

        <div class="relative z-10 w-full px-4 sm:px-8 lg:px-20 xl:px-32 pt-4 lg:pt-6">
            <!-- Navbar Area clean -->
        </div>
    </nav>

    <!-- Hero Section with Static Background (Original) -->
    <div class="relative w-full min-h-screen flex items-center py-24" style="background-image: url('{{ asset('images/slider 1.png') }}'); background-size: cover; background-position: center;">
        
        <div class="absolute inset-0 bg-[#064e3b]/60 z-0"></div>

        <!-- Glassmorphism Login Card (Original Layout) -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-xl bg-white/70 backdrop-blur-md border border-white/40 rounded-[2rem] p-6 sm:p-8 md:p-12 shadow-2xl mx-auto lg:ml-auto lg:mr-0">
                <!-- Headline (Original) -->
                <h1 class="leading-tight mb-2 drop-shadow-sm text-center" style="font-family: 'Jaini Purva', serif;">
                    <span class="block text-3xl md:text-4xl text-[#044E37] font-bold">
                        Dashboard Al-Furqoniyah
                    </span>
                </h1>
                
                <p class="text-sm md:text-base text-gray-700 font-medium mb-6 text-center">
                    Masuk ke portal kepengasuhan
                </p>


                <!-- Error -->
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Login Form (Original) -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-[#044E37] font-bold mb-2">Email Pengguna</label>
                        <input type="email" name="email" id="emailInput"
                            value="{{ old('email') }}" required 
                            class="w-full px-5 py-3.5 rounded-xl bg-white/80 border-2 border-white focus:border-[#044E37] focus:bg-white focus:ring-4 focus:ring-[#044E37]/10 focus:outline-none transition-all duration-300">
                    </div>
                    
                    <div class="mb-8">
                        <label class="block text-[#044E37] font-bold mb-2">Kata Sandi</label>
                        <input type="password" name="password" id="passwordInput"
                            required 
                            class="w-full px-5 py-3.5 rounded-xl bg-white/80 border-2 border-white focus:border-[#044E37] focus:bg-white focus:ring-4 focus:ring-[#044E37]/10 focus:outline-none transition-all duration-300">
                    </div>
                    
                    <button type="submit" id="btnSubmit"
                        class="w-full px-8 py-4 rounded-xl bg-[#044E37] text-white font-bold text-lg shadow-xl shadow-[#044E37]/20 hover:bg-[#033a29] transition-all duration-300 transform hover:-translate-y-1">
                        Masuk ke Dashboard &rarr;
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="{{ url('/') }}" class="text-[#044E37] hover:underline text-sm font-semibold">
                            &larr; Kembali ke Beranda
                        </a>
                    </div>
                </form>

            </div>
        </div>
        
    </div>

</body>
</html>
