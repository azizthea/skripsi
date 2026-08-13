<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pengurus — Virtual Counselor</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ══════════════════════════════════════
           ORGANIC DESIGN TOKENS
           Pengurus identity: Terracotta/Sienna accent
        ══════════════════════════════════════ */
        :root {
            --bg:          #FDFCF8;
            --fg:          #2C2C24;
            --primary:     #A85448;  /* Sienna / burnt terracotta for Pengurus */
            --primary-fg:  #FFF5F3;
            --secondary:   #C18C5D;
            --accent:      #F0E8E5;  /* warm rose-tinted stone */
            --muted:       #F0EBE5;
            --muted-fg:    #78786C;
            --border:      #DED8CF;
            --positive:    #5D7052;  /* Moss green retained for status badges */
            --shadow-soft: 0 4px 20px -2px rgba(168,84,72,0.12);
            --shadow-float: 0 10px 40px -10px rgba(168,84,72,0.18);
            --sidebar-w: 260px;

            /* Legacy & Compatibility Aliases */
            --af-bg:       #FDFCF8;
            --af-dark:     #2C2C24;
            --af-positive: #5D7052;
            --af-warning:  #C18C5D;
            --af-negative: #A85448;
            --af-guru:     #A85448;
            --af-guru-dark:#823E34;
            --neo-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --neo-shadow-outer: 0 4px 20px -2px rgba(168,84,72,0.12);
            --neo-shadow-inner: inset 0 2px 4px rgba(0,0,0,0.04);
            --neo-border: #DED8CF;
        }

        /* Compatibility Styles for Legacy .neo-* Classes */
        .neo-card {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .neo-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--fg) !important;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .neo-btn:hover {
            background: var(--muted);
            color: var(--fg) !important;
            border-color: var(--border);
        }
        .neo-btn-primary {
            background: var(--primary);
            color: white !important;
            border-color: var(--primary);
            box-shadow: 0 4px 16px -2px rgba(168,84,72,0.3);
        }
        .neo-btn-primary:hover {
            background: #8A433A;
            color: white !important;
            border-color: #8A433A;
        }
        .neo-btn-danger {
            background: var(--primary);
            color: white !important;
            border-color: var(--primary);
        }

        .neo-input, .form-control.neo-input, .form-select.neo-input {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-family: 'Nunito', sans-serif;
            font-size: 0.85rem;
            color: var(--fg);
            transition: all 0.25s ease;
        }
        .neo-input:focus, .form-control.neo-input:focus, .form-select.neo-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(168,84,72,0.15);
            background: white;
        }

        /* Modal Z-Index Fix for Bootstrap Overlays */
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal {
            z-index: 1055 !important;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg);
            color: var(--fg);
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Paper Grain Texture */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none; opacity: 0.035;
            mix-blend-mode: multiply;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .org-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background-color: var(--muted);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            padding: 1.5rem 0; z-index: 100;
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 24px rgba(168,84,72,0.07);
        }
        .org-sidebar::before {
            content: '';
            position: absolute; top: -60px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            background: rgba(168,84,72,0.07);
            pointer-events: none;
        }

        /* Brand */
        .org-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
        }
        .org-brand-icon {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .org-brand-name {
            font-family: 'Fraunces', serif; font-weight: 700;
            font-size: 1.05rem; color: var(--fg); line-height: 1.2;
        }
        .org-brand-sub { font-size: 0.65rem; color: var(--muted-fg); font-weight: 500; letter-spacing: 0.5px; }

        /* User card */
        .org-user-card {
            margin: 1.25rem 1rem;
            background: white; border-radius: 20px;
            padding: 0.85rem 1rem; border: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px;
        }
        .org-user-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #8B3D31);
            color: white; font-weight: 700; font-size: 0.85rem;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .org-user-name { font-weight: 700; font-size: 0.8rem; color: var(--fg); }
        .org-user-role {
            font-size: 0.6rem; background: var(--primary); color: white;
            border-radius: 50px; padding: 1px 8px; display: inline-block;
            margin-top: 2px; letter-spacing: 0.5px;
        }

        /* Nav */
        .org-nav { list-style: none; flex: 1; padding: 0.5rem 0; overflow-y: auto; }
        .org-nav-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--muted-fg);
            padding: 0.85rem 1.5rem 0.3rem;
        }
        .org-nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 0.55rem 1rem; margin: 2px 0.75rem;
            border-radius: 14px; color: var(--fg);
            font-size: 0.82rem; font-weight: 600;
            text-decoration: none; transition: all 0.25s ease;
        }
        .org-nav-link i { width: 20px; text-align: center; font-size: 0.95rem; }
        .org-nav-link:hover { background: var(--accent); color: var(--primary); }
        .org-nav-link.active { background: var(--primary); color: white; box-shadow: var(--shadow-soft); }

        /* Dropdown nav */
        .org-nav-dropdown-btn {
            display: flex; align-items: center; gap: 10px;
            width: calc(100% - 1.5rem); margin: 2px 0.75rem;
            padding: 0.55rem 1rem; border-radius: 14px;
            background: none; border: none; cursor: pointer;
            color: var(--fg); font-size: 0.82rem; font-weight: 600;
            font-family: 'Nunito', sans-serif; transition: all 0.25s ease;
        }
        .org-nav-dropdown-btn:hover { background: var(--accent); color: var(--primary); }
        .org-nav-dropdown-btn i:first-child { width: 20px; text-align: center; font-size: 0.95rem; }
        .org-nav-dropdown-btn .arrow { margin-left: auto; font-size: 0.7rem; transition: transform 0.3s; color: var(--muted-fg); }
        .org-nav-dropdown-btn.open .arrow { transform: rotate(180deg); }

        .org-nav-submenu { list-style: none; max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .org-nav-submenu.open { max-height: 200px; }
        .org-nav-sublink {
            display: flex; align-items: center; gap: 8px;
            padding: 0.45rem 1rem 0.45rem 2.5rem;
            margin: 2px 0.75rem; border-radius: 12px;
            color: var(--muted-fg); font-size: 0.78rem; font-weight: 600;
            text-decoration: none; transition: all 0.2s;
        }
        .org-nav-sublink:hover, .org-nav-sublink.active-sub { background: rgba(168,84,72,0.08); color: var(--primary); }

        /* Logout */
        .org-logout-btn {
            display: flex; align-items: center; gap: 10px;
            width: calc(100% - 2rem); margin: 0 1rem; padding: 0.6rem 1rem;
            border-radius: 14px; background: none; border: none; cursor: pointer;
            color: var(--primary); font-size: 0.82rem; font-weight: 600;
            font-family: 'Nunito', sans-serif; transition: all 0.25s ease;
        }
        .org-logout-btn:hover { background: rgba(168,84,72,0.08); }
        .org-logout-area { padding: 1rem 0 0; border-top: 1px solid var(--border); margin-top: auto; }

        /* ══════════════════════════════════════
           MAIN WRAPPER
        ══════════════════════════════════════ */
        .org-main {
            margin-left: var(--sidebar-w); min-height: 100vh;
            padding: 2rem 2.5rem; position: relative; z-index: auto;
        }

        /* ══════════════════════════════════════
           REUSABLE COMPONENTS
        ══════════════════════════════════════ */
        .org-card {
            background: white; border-radius: 2rem;
            border: 1px solid rgba(222,216,207,0.6);
            box-shadow: var(--shadow-soft); overflow: hidden;
        }

        /* Buttons */
        .org-btn {
            display: inline-flex; align-items: center; gap: 6px;
            border-radius: 50px; padding: 0.55rem 1.5rem;
            font-family: 'Nunito', sans-serif; font-weight: 700;
            font-size: 0.85rem; border: none; cursor: pointer;
            text-decoration: none; transition: all 0.3s ease;
        }
        .org-btn:active { transform: scale(0.96); }
        .org-btn-primary {
            background: var(--primary); color: white;
            box-shadow: 0 4px 20px -2px rgba(168,84,72,0.3);
        }
        .org-btn-primary:hover { transform: scale(1.04); box-shadow: 0 6px 24px -4px rgba(168,84,72,0.35); color: white; }
        .org-btn-danger {
            background: var(--primary); color: white;
            box-shadow: 0 4px 16px -2px rgba(168,84,72,0.3);
        }
        .org-btn-danger:hover { transform: scale(1.04); color: white; }
        .org-btn-ghost {
            background: transparent; color: var(--muted-fg);
            border: 1.5px solid var(--border);
        }
        .org-btn-ghost:hover { background: var(--muted); color: var(--fg); }

        /* Inputs */
        .org-input {
            background: rgba(255,255,255,0.6);
            border: 1.5px solid var(--border); border-radius: 50px;
            padding: 0.55rem 1.25rem;
            font-family: 'Nunito', sans-serif; font-size: 0.85rem;
            color: var(--fg); width: 100%; transition: all 0.25s ease;
        }
        .org-input:focus {
            outline: none; border-color: rgba(168,84,72,0.4);
            box-shadow: 0 0 0 3px rgba(168,84,72,0.1);
            background: white;
        }
        .org-textarea {
            background: rgba(255,255,255,0.6);
            border: 1.5px solid var(--border); border-radius: 1.25rem;
            padding: 0.75rem 1.25rem;
            font-family: 'Nunito', sans-serif; font-size: 0.85rem;
            color: var(--fg); width: 100%;
            transition: all 0.25s ease; resize: vertical;
        }
        .org-textarea:focus {
            outline: none; border-color: rgba(168,84,72,0.4);
            box-shadow: 0 0 0 3px rgba(168,84,72,0.1);
            background: white;
        }

        /* Badges */
        .org-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 0.2rem 0.75rem; border-radius: 50px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: 0.3px;
        }
        .org-badge-danger  { background: rgba(168,84,72,0.12); color: var(--primary); }
        .org-badge-success { background: rgba(93,112,82,0.12);  color: var(--positive); }
        .org-badge-muted   { background: var(--muted); color: var(--muted-fg); }

        /* Table */
        .org-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .org-table th {
            padding: 0.9rem 1rem; font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: var(--muted-fg); border-bottom: 1.5px solid var(--border);
            white-space: nowrap;
        }
        .org-table td {
            padding: 0.9rem 1rem; font-size: 0.85rem; color: var(--fg);
            border-bottom: 1px solid rgba(222,216,207,0.4); vertical-align: middle;
        }
        .org-table tr:last-child td { border-bottom: none; }
        .org-table tbody tr { transition: background 0.2s; }
        .org-table tbody tr:hover { background: rgba(240,232,229,0.3); }

        /* Live feed */
        .org-feed-item {
            display: flex; align-items: center; gap: 12px;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(222,216,207,0.4);
            transition: background 0.2s;
        }
        .org-feed-item:hover { background: rgba(240,232,229,0.25); }
        .org-feed-item:last-child { border-bottom: none; }
        .org-feed-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
        }

        /* Progress bar organic */
        .org-progress {
            height: 7px;
            background: var(--muted);
            border-radius: 50px;
            overflow: hidden;
        }
        .org-progress-fill {
            height: 100%;
            border-radius: 50px;
            background: linear-gradient(90deg, #E8A838, #C18C5D);
            transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
        }

        /* Mobile */
        @media (max-width: 991px) {
            .org-sidebar { transform: translateX(-100%); }
            .org-sidebar.open { transform: translateX(0); }
            .org-main { margin-left: 0; padding: 1rem; }
            .org-mobile-toggle {
                position: fixed; top: 1rem; left: 1rem; z-index: 200;
                width: 42px; height: 42px; border-radius: 50%;
                background: var(--primary); color: white; border: none;
                display: flex; align-items: center; justify-content: center;
                box-shadow: var(--shadow-soft); cursor: pointer;
            }
        }
        @media (min-width: 992px) { .org-mobile-toggle { display: none; } }

        @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
        .pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); display: inline-block; animation: pulse-dot 2s infinite; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra-styles')
</head>
<body>

<button class="org-mobile-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<aside class="org-sidebar" id="sidebar">
    <!-- Brand -->
    <a class="org-brand" href="{{ route('dashboard') }}">
        <div class="org-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 38px; height: 38px; object-fit: contain;">
        </div>
        <div>
            <div class="org-brand-name">Portal Pengurus</div>
            <div class="org-brand-sub">Virtual Counselor</div>
        </div>
    </a>

    <!-- User Card -->
    <div class="org-user-card">
        <div class="org-user-avatar">{{ substr(auth()->user()->name ?? 'P', 0, 1) }}</div>
        <div>
            <div class="org-user-name">{{ auth()->user()->name }}</div>
            <div class="org-user-role">PENGURUS</div>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="org-nav">
        <li><span class="org-nav-label">Menu Utama</span></li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
        </li>
        <li>
            <button class="org-nav-dropdown-btn {{ request()->routeIs('guru.input-absensi') ? 'open' : '' }}"
                    id="dropdownAbsensi" onclick="toggleAbsensiDropdown()" type="button">
                <i class="bi bi-clipboard-plus-fill"></i>
                Input Absensi
                <i class="bi bi-chevron-down arrow"></i>
            </button>
            <ul class="org-nav-submenu {{ request()->routeIs('guru.input-absensi') ? 'open' : '' }}" id="submenuAbsensi">
                <li>
                    <a href="{{ route('guru.input-absensi', ['jenis_kegiatan' => 'Al-Quran', 'tanggal' => now()->toDateString()]) }}"
                       class="org-nav-sublink {{ request()->routeIs('guru.input-absensi') && in_array(request('jenis_kegiatan'), ['Al-Quran','Fiqih','Tafsir','Hadits','Akhlak','Bahasa Arab','Pengajian']) ? 'active-sub' : '' }}">
                        <i class="bi bi-book-fill" style="color:#805AD5;"></i> Pengajian
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.input-absensi', ['jenis_kegiatan' => 'Matematika', 'tanggal' => now()->toDateString()]) }}"
                       class="org-nav-sublink {{ request()->routeIs('guru.input-absensi') && in_array(request('jenis_kegiatan'), ['Matematika','Bahasa Indonesia','Bahasa Inggris','IPA','IPS','PKn','Sekolah']) ? 'active-sub' : '' }}">
                        <i class="bi bi-mortarboard-fill" style="color:#DD6B20;"></i> Sekolah
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="org-logout-area">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="org-logout-btn">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<main class="org-main" id="mainWrapper">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleAbsensiDropdown() {
        const btn  = document.getElementById('dropdownAbsensi');
        const menu = document.getElementById('submenuAbsensi');
        const isOpen = menu.classList.contains('open');
        if (isOpen) { menu.classList.remove('open'); btn.classList.remove('open'); }
        else { menu.classList.add('open'); btn.classList.add('open'); }
    }
    function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); }
    document.addEventListener('DOMContentLoaded', function () {
        if ({{ request()->routeIs('guru.input-absensi') ? 'true' : 'false' }}) {
            document.getElementById('submenuAbsensi')?.classList.add('open');
            document.getElementById('dropdownAbsensi')?.classList.add('open');
        }
    });
</script>
@yield('extra-scripts')
    @if(session('login_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Autentikasi Berhasil!',
                text: "{{ session('login_success') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 1200,
                timerProgressBar: true,
                background: '#FDFCF8'
            });
        });
    </script>
    @endif
</body>
</html>
