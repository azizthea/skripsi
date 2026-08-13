<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Guru — Al-Furqoniyah</title>
    <meta name="description" content="Portal Absensi Online Guru Pondok Pesantren Al-Furqoniyah">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ══════════════════════════════════════
           ORGANIC DESIGN TOKENS
           Guru identity: Deep Indigo / Slate Blue
        ══════════════════════════════════════ */
        :root {
            --bg:          #FDFCF8;
            --fg:          #2C2C24;
            --primary:     #4A5568;  /* Slate / Ash — calm, trustworthy, educator */
            --primary-alt: #5D7052;  /* Moss Green for success/hadir */
            --secondary:   #C18C5D;
            --accent:      #E8E6F0;  /* cool lavender stone */
            --muted:       #F0EBE5;
            --muted-fg:    #78786C;
            --border:      #DED8CF;
            --positive:    #5D7052;
            --warning:     #C18C5D;
            --negative:    #A85448;
            --shadow-soft: 0 4px 20px -2px rgba(74,85,104,0.15);
            --shadow-float: 0 10px 40px -10px rgba(74,85,104,0.2);
            --topbar-h:    64px;
            --sidebar-w:   240px;

            /* Legacy & Compatibility Aliases */
            --af-bg:       #FDFCF8;
            --af-dark:     #2C2C24;
            --af-positive: #5D7052;
            --af-warning:  #C18C5D;
            --af-negative: #A85448;
            --af-guru:     #4A5568;
            --af-guru-dark:#2D3748;
            --neo-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --neo-shadow-outer: 0 4px 20px -2px rgba(74,85,104,0.12);
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
            box-shadow: 0 4px 16px -2px rgba(74,85,104,0.3);
        }
        .neo-btn-primary:hover {
            background: #2D3748;
            color: white !important;
            border-color: #2D3748;
        }
        .neo-btn-danger {
            background: var(--negative);
            color: white !important;
            border-color: var(--negative);
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
            box-shadow: 0 0 0 3px rgba(74,85,104,0.15);
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
           TOPBAR (floating pill style)
        ══════════════════════════════════════ */
        .org-topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-h);
            background: rgba(253,252,248,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 0 2rem; z-index: 200;
            box-shadow: 0 2px 16px rgba(74,85,104,0.08);
        }

        .org-topbar-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
        }
        .org-topbar-brand-icon {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .org-topbar-brand-name {
            font-family: 'Fraunces', serif;
            font-weight: 700; font-size: 1.05rem; color: var(--fg);
            line-height: 1.1;
        }
        .org-topbar-brand-sub { font-size: 0.65rem; color: var(--muted-fg); font-weight: 500; }

        .org-topbar-right { display: flex; align-items: center; gap: 0.75rem; }

        .org-user-pill {
            display: flex; align-items: center; gap: 8px;
            background: var(--muted); border: 1px solid var(--border);
            border-radius: 50px; padding: 5px 14px 5px 6px;
        }
        .org-user-pill-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--primary); color: white;
            font-weight: 700; font-size: 0.78rem;
            display: flex; align-items: center; justify-content: center;
        }
        .org-user-pill-name { font-size: 0.82rem; font-weight: 700; color: var(--fg); }
        .org-user-pill-role { font-size: 0.62rem; color: var(--muted-fg); text-transform: uppercase; letter-spacing: 0.5px; }

        /* Mobile hamburger */
        .org-mobile-btn {
            display: none; width: 40px; height: 40px; border-radius: 50%;
            background: var(--muted); border: 1px solid var(--border);
            align-items: center; justify-content: center;
            font-size: 1.1rem; color: var(--fg); cursor: pointer;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .org-sidebar {
            position: fixed;
            top: var(--topbar-h); left: 0;
            width: var(--sidebar-w);
            height: calc(100vh - var(--topbar-h));
            background-color: var(--muted);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            padding: 1.25rem 0; z-index: 100;
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 20px rgba(74,85,104,0.07);
            overflow-y: auto;
        }
        .org-sidebar::after {
            content: '';
            position: absolute; bottom: -40px; left: -30px;
            width: 160px; height: 160px;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            background: rgba(74,85,104,0.05);
            pointer-events: none;
        }

        /* Nav */
        .org-nav { list-style: none; flex: 1; padding: 0.25rem 0; }
        .org-nav-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--muted-fg);
            padding: 0.75rem 1.5rem 0.3rem;
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
        .org-nav-sublink:hover, .org-nav-sublink.active-sub { background: rgba(74,85,104,0.08); color: var(--primary); }

        .org-logout-btn {
            display: flex; align-items: center; gap: 10px;
            width: calc(100% - 2rem); margin: 0 1rem; padding: 0.6rem 1rem;
            border-radius: 14px; background: none; border: none; cursor: pointer;
            color: var(--negative); font-size: 0.82rem; font-weight: 600;
            font-family: 'Nunito', sans-serif; transition: all 0.25s ease;
        }
        .org-logout-btn:hover { background: rgba(168,84,72,0.08); }
        .org-logout-area { padding: 1rem 0 0; border-top: 1px solid var(--border); margin-top: auto; }

        /* ══════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════ */
        .org-main {
            margin-left: var(--sidebar-w);
            padding: calc(var(--topbar-h) + 2rem) 2.5rem 3rem;
            min-height: 100vh; position: relative; z-index: auto;
        }

        /* ══════════════════════════════════════
           SHARED COMPONENTS
        ══════════════════════════════════════ */
        .org-card {
            background: white; border-radius: 2rem;
            border: 1px solid rgba(222,216,207,0.6);
            box-shadow: var(--shadow-soft); overflow: hidden;
        }
        .org-card-pad { padding: 1.5rem; }

        .org-btn {
            display: inline-flex; align-items: center; gap: 6px;
            border-radius: 50px; padding: 0.55rem 1.5rem;
            font-family: 'Nunito', sans-serif; font-weight: 700;
            font-size: 0.85rem; border: none; cursor: pointer;
            text-decoration: none; transition: all 0.3s ease;
        }
        .org-btn:active { transform: scale(0.96); }
        .org-btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 20px -2px rgba(74,85,104,0.3); }
        .org-btn-primary:hover { transform: scale(1.04); box-shadow: 0 6px 24px -4px rgba(74,85,104,0.35); color: white; }
        .org-btn-ghost { background: transparent; color: var(--muted-fg); border: 1.5px solid var(--border); }
        .org-btn-ghost:hover { background: var(--muted); color: var(--fg); }

        .org-input {
            background: rgba(255,255,255,0.6);
            border: 1.5px solid var(--border); border-radius: 50px;
            padding: 0.55rem 1.25rem;
            font-family: 'Nunito', sans-serif; font-size: 0.85rem;
            color: var(--fg); width: 100%; transition: all 0.25s ease;
        }
        .org-input:focus {
            outline: none; border-color: rgba(74,85,104,0.5);
            box-shadow: 0 0 0 3px rgba(74,85,104,0.1); background: white;
        }

        /* Stat cards */
        .org-stat-card {
            background: white; border-radius: 1.5rem;
            border: 1px solid rgba(222,216,207,0.6);
            box-shadow: var(--shadow-soft);
            padding: 1.25rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            transition: all 0.3s ease;
        }
        .org-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-float); }
        .org-stat-icon {
            width: 52px; height: 52px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }

        /* Action cards (absensi shortcut) */
        .org-action-card {
            background: white; border-radius: 2rem;
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-soft);
            padding: 2rem 1.5rem;
            text-align: center; text-decoration: none;
            color: var(--fg); transition: all 0.3s ease;
            display: block;
        }
        .org-action-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-float);
            color: var(--primary);
            border-color: rgba(74,85,104,0.3);
        }
        .org-action-icon {
            width: 76px; height: 76px; border-radius: 26px;
            margin: 0 auto 1.25rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; transition: transform 0.3s ease;
        }
        .org-action-card:hover .org-action-icon { transform: scale(1.08); }

        /* Progress bar */
        .org-progress {
            height: 8px; border-radius: 50px;
            background: var(--muted); overflow: hidden;
        }
        .org-progress-fill { height: 100%; border-radius: 50px; transition: width 1.2s ease; }

        /* Feed */
        .org-feed-item {
            display: flex; align-items: center; gap: 12px;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid rgba(222,216,207,0.4);
            transition: background 0.2s;
        }
        .org-feed-item:hover { background: rgba(232,230,240,0.25); }
        .org-feed-item:last-child { border-bottom: none; }
        .org-feed-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
        }

        /* Status badges */
        .pill-hadir { background: rgba(93,112,82,0.12);  color: var(--positive); padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; }
        .pill-izin  { background: rgba(193,140,93,0.15); color: #7A5230;         padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; }
        .pill-alpa  { background: rgba(168,84,72,0.1);   color: var(--negative); padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; }
        .pill-done  { background: rgba(93,112,82,0.12);  color: var(--positive); display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; margin-top: 0.6rem; }
        .pill-todo  { background: rgba(168,84,72,0.1);   color: var(--negative); display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; margin-top: 0.6rem; }

        /* Toast alerts */
        .toast-area {
            position: fixed; top: calc(var(--topbar-h) + 1rem);
            left: 50%; transform: translateX(-50%);
            z-index: 9999; min-width: 360px; max-width: 90%;
        }
        .org-alert {
            border-radius: 1rem; padding: 0.85rem 1.5rem;
            color: white; font-weight: 600; font-size: 0.88rem;
            margin-bottom: 0.5rem; text-align: center;
            box-shadow: var(--shadow-float); border: none;
        }

        /* Sidebar overlay (mobile) */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(44,44,36,0.4);
            backdrop-filter: blur(4px);
            z-index: 99; opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: auto; }

        /* Mobile responsive */
        @media (max-width: 991px) {
            .org-sidebar { transform: translateX(-100%); }
            .org-sidebar.open { transform: translateX(0); }
            .org-main { margin-left: 0; padding: calc(var(--topbar-h) + 1rem) 1rem 2rem; }
            .org-mobile-btn { display: flex; }
            .org-user-pill { display: none; }
        }

        @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
        .pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--positive); display: inline-block; animation: pulse-dot 2s infinite; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra-styles')
</head>
<body>

<!-- Topbar -->
<header class="org-topbar">
    <a href="{{ in_array(auth()->user()->role, ['admin','bk','pengurus']) ? route('dashboard') : route('guru.dashboard') }}" class="org-topbar-brand">
        <div class="org-topbar-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 38px; height: 38px; object-fit: contain;">
        </div>
        <div>
            <div class="org-topbar-brand-name">Al-Furqoniyah</div>
            <div class="org-topbar-brand-sub">Portal Guru · Absensi Digital</div>
        </div>
    </a>

    <div class="org-topbar-right">
        <button class="org-mobile-btn" id="mobileMenuBtn">
            <i class="bi bi-list"></i>
        </button>
        <div class="org-user-pill d-none d-md-flex">
            <div class="org-user-pill-avatar">{{ substr(auth()->user()->name ?? 'G', 0, 1) }}</div>
            <div>
                <div class="org-user-pill-name">{{ auth()->user()->name ?? 'Guru' }}</div>
                <div class="org-user-pill-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
</header>

<!-- Sidebar -->
<aside class="org-sidebar" id="guruSidebar">
    <ul class="org-nav">
        <li><span class="org-nav-label">Menu Utama</span></li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('guru.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ in_array(auth()->user()->role, ['admin','bk','pengurus']) ? route('dashboard') : route('guru.dashboard') }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
        </li>

        <li><span class="org-nav-label">Absensi</span></li>
        <li>
            <button class="org-nav-dropdown-btn {{ request()->routeIs('guru.input-absensi') ? 'open' : '' }}"
                    id="dropdownAbsensi" onclick="toggleAbsensiDropdown()" type="button">
                <i class="bi bi-clipboard-check-fill"></i>
                Input Absensi
                <i class="bi bi-chevron-down arrow"></i>
            </button>
            <ul class="org-nav-submenu {{ request()->routeIs('guru.input-absensi') ? 'open' : '' }}" id="submenuAbsensi">
                @if(in_array(auth()->user()->role, ['admin','guru','pengurus']))
                <li>
                    <a class="org-nav-sublink {{ request()->routeIs('guru.input-absensi') && in_array(request('jenis_kegiatan'), ['Al-Quran','Fiqih','Tafsir','Hadits','Akhlak','Bahasa Arab','Pengajian']) ? 'active-sub' : '' }}"
                       href="{{ route('guru.input-absensi', ['jenis_kegiatan'=>'Al-Quran','tanggal'=>now()->toDateString()]) }}">
                        <i class="bi bi-book-fill" style="color:#805AD5;"></i> Pengajian
                    </a>
                </li>
                @endif
                @if(in_array(auth()->user()->role, ['admin','guru','bk']))
                <li>
                    <a class="org-nav-sublink {{ request()->routeIs('guru.input-absensi') && in_array(request('jenis_kegiatan'), ['Matematika','Bahasa Indonesia','Bahasa Inggris','IPA','IPS','PKn','Sekolah']) ? 'active-sub' : '' }}"
                       href="{{ route('guru.input-absensi', ['jenis_kegiatan'=>'Matematika','tanggal'=>now()->toDateString()]) }}">
                        <i class="bi bi-mortarboard-fill" style="color:#DD6B20;"></i> Sekolah
                    </a>
                </li>
                @endif
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

<!-- Sidebar overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Main Content -->
<main class="org-main">
    <!-- Toast / Session Alerts -->
    <div class="toast-area">
        @if(session('success'))
            <div class="org-alert auto-dismiss" style="background:var(--positive);">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="org-alert auto-dismiss" style="background:var(--negative);">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="org-alert auto-dismiss" style="background:var(--negative);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif
    </div>

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn  = document.getElementById('mobileMenuBtn');
        const sidebar  = document.getElementById('guruSidebar');
        const overlay  = document.getElementById('sidebarOverlay');

        if (menuBtn) menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        });
        if (overlay) overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // Auto dismiss alerts
        document.querySelectorAll('.auto-dismiss').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 4000);
        });

        // Auto-open dropdown if on absensi page
        if ({{ request()->routeIs('guru.input-absensi') ? 'true' : 'false' }}) {
            document.getElementById('submenuAbsensi')?.classList.add('open');
            document.getElementById('dropdownAbsensi')?.classList.add('open');
        }
    });

    function toggleAbsensiDropdown() {
        const btn  = document.getElementById('dropdownAbsensi');
        const menu = document.getElementById('submenuAbsensi');
        const open = menu.classList.contains('open');
        menu.classList.toggle('open', !open);
        btn.classList.toggle('open', !open);
    }
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
