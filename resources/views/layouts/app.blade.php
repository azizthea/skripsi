<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Furqoniyah - Sistem Analitik Kedisiplinan</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ══════════════════════════════════════
           ORGANIC DESIGN TOKENS
           Admin Identity: Moss Green
        ══════════════════════════════════════ */
        :root {
            --bg:          #FDFCF8;
            --fg:          #2C2C24;
            --primary:     #5D7052;
            --primary-fg:  #F3F4F1;
            --secondary:   #C18C5D;
            --accent:      #E6DCCD;
            --muted:       #F0EBE5;
            --muted-fg:    #78786C;
            --border:      #DED8CF;
            --positive:    #5D7052;
            --warning:     #C18C5D;
            --negative:    #A85448;
            --shadow-soft: 0 4px 20px -2px rgba(93,112,82,0.15);
            --shadow-float: 0 10px 40px -10px rgba(93,112,82,0.2);
            --sidebar-w:   260px;

            /* Legacy & Compatibility Aliases for Full Visibility */
            --af-bg:       #FDFCF8;
            --af-dark:     #2C2C24;
            --af-positive: #5D7052;
            --af-warning:  #C18C5D;
            --af-negative: #A85448;
            --af-guru:     #5D7052;
            --af-guru-dark:#4A5E42;
            --neo-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --neo-shadow-outer: 0 4px 20px -2px rgba(93,112,82,0.12);
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
            box-shadow: 0 4px 16px -2px rgba(93,112,82,0.3);
        }
        .neo-btn-primary:hover {
            background: #4A5E42;
            color: white !important;
            border-color: #4A5E42;
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
            box-shadow: 0 0 0 3px rgba(93,112,82,0.15);
            background: white;
        }

        .badge-positive {
            background: rgba(93,112,82,0.15) !important;
            color: #5D7052 !important;
            border: 1px solid rgba(93,112,82,0.3);
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
        }
        .badge-warning {
            background: rgba(193,140,93,0.15) !important;
            color: #7A5230 !important;
            border: 1px solid rgba(193,140,93,0.3);
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
        }
        .badge-danger {
            background: rgba(168,84,72,0.15) !important;
            color: #A85448 !important;
            border: 1px solid rgba(168,84,72,0.3);
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
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
            padding: 1.5rem 0; z-index: 1000;
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 24px rgba(93,112,82,0.08);
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
        }
        .org-sidebar::-webkit-scrollbar { display: none; } /* Chrome */
        
        .org-sidebar::before {
            content: '';
            position: absolute; top: -60px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            background: rgba(93,112,82,0.08);
            pointer-events: none;
            z-index: -1;
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
            background: linear-gradient(135deg, var(--primary), #4a5e42);
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
        .org-nav { list-style: none; flex: 1; padding: 0.5rem 0; }
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
        .org-nav-sublink:hover, .org-nav-sublink.active-sub { background: rgba(93,112,82,0.1); color: var(--primary); }

        /* Logout */
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
            padding: 1.5rem; margin-bottom: 1.5rem;
        }

        /* Buttons */
        .org-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            border-radius: 50px; padding: 0.55rem 1.5rem;
            font-family: 'Nunito', sans-serif; font-weight: 700;
            font-size: 0.85rem; border: none; cursor: pointer;
            text-decoration: none; transition: all 0.3s ease;
        }
        .org-btn:active { transform: scale(0.96); }
        .org-btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 20px -2px rgba(93,112,82,0.3); }
        .org-btn-primary:hover { transform: scale(1.04); box-shadow: 0 6px 24px -4px rgba(93,112,82,0.35); color: white; }
        .org-btn-danger { background: var(--negative); color: white; box-shadow: 0 4px 16px -2px rgba(168,84,72,0.3); }
        .org-btn-danger:hover { transform: scale(1.04); color: white; }
        .org-btn-ghost { background: transparent; color: var(--muted-fg); border: 1.5px solid var(--border); }
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
            outline: none; border-color: rgba(93,112,82,0.5);
            box-shadow: 0 0 0 3px rgba(93,112,82,0.12); background: white;
        }
        select.org-input {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2378786C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;
            padding-right: 2.5rem;
        }

        /* Badges */
        .org-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 0.2rem 0.75rem; border-radius: 50px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: 0.3px;
        }
        .org-badge-primary { background: rgba(93,112,82,0.12); color: var(--primary); }
        .org-badge-warning { background: rgba(193,140,93,0.15); color: #7A5230; }
        .org-badge-danger  { background: rgba(168,84,72,0.12); color: var(--negative); }
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
        .org-table tbody tr:hover { background: rgba(230,220,205,0.15); }

        /* Toast / Alerts */
        .toast-area {
            position: fixed; top: 1rem; left: 50%; transform: translateX(-50%);
            z-index: 9999; min-width: 360px; max-width: 90%;
        }
        .org-alert {
            border-radius: 1rem; padding: 0.85rem 1.5rem;
            color: white; font-weight: 600; font-size: 0.88rem;
            margin-bottom: 0.5rem; text-align: center;
            box-shadow: var(--shadow-float); border: none;
        }

        /* Mobile Layout */
        .org-mobile-header {
            display: none; align-items: center; justify-content: space-between;
            background: rgba(253,252,248,0.85); backdrop-filter: blur(12px);
            border-radius: 1.25rem; padding: 0.75rem 1.25rem;
            box-shadow: var(--shadow-soft); margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            position: sticky; top: 1rem; z-index: 900;
        }
        .org-mobile-toggle {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--primary); color: white; border: none;
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-soft); cursor: pointer;
        }
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(44,44,36,0.4); backdrop-filter: blur(4px);
            z-index: 999; opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: auto; }

        @media (max-width: 991px) {
            .org-sidebar { transform: translateX(-100%); }
            .org-sidebar.open { transform: translateX(0); }
            .org-main { margin-left: 0; padding: 1rem; }
            .org-mobile-header { display: flex; }
        }

        @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
        .pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--positive); display: inline-block; animation: pulse-dot 2s infinite; }
    </style>
    @yield('extra-styles')
</head>
<body>

@auth
<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="org-sidebar" id="sidebar">
    <a class="org-brand" href="{{ route('dashboard') }}">
        <div class="org-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 38px; height: 38px; object-fit: contain;">
        </div>
        <div>
            <div class="org-brand-name">Portal Admin</div>
            <div class="org-brand-sub">Sistem Kedisiplinan</div>
        </div>
    </a>

    <div class="org-user-card">
        <div class="org-user-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
        <div style="min-width:0;">
            <div class="org-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
            <div class="org-user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
    </div>

    <ul class="org-nav">
        <li><span class="org-nav-label">Menu Utama</span></li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
        </li>

        @if(auth()->user()->role === 'admin')
        <li><span class="org-nav-label mt-2">Data Master</span></li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('santri.*') ? 'active' : '' }}" href="{{ route('santri.index') }}">
                <i class="bi bi-people-fill"></i> Data Santri
            </a>
        </li>
        <li>
            <button class="org-nav-dropdown-btn {{ request()->routeIs('ruangan.*') ? 'open' : '' }}" onclick="toggleDropdown('submenuRuangan', this)" type="button">
                <i class="bi bi-buildings-fill"></i> Data Ruang <i class="bi bi-chevron-down arrow"></i>
            </button>
            <ul class="org-nav-submenu {{ request()->routeIs('ruangan.*') ? 'open' : '' }}" id="submenuRuangan">
                <li><a href="{{ route('ruangan.index', ['jenis_ruang' => 'pengajian']) }}" class="org-nav-sublink {{ request()->routeIs('ruangan.*') && request('jenis_ruang') === 'pengajian' ? 'active-sub' : '' }}"><i class="bi bi-book-fill"></i> Pengajian</a></li>
                <li><a href="{{ route('ruangan.index', ['jenis_ruang' => 'sekolah']) }}" class="org-nav-sublink {{ request()->routeIs('ruangan.*') && request('jenis_ruang', 'sekolah') === 'sekolah' ? 'active-sub' : '' }}"><i class="bi bi-mortarboard-fill"></i> Sekolah</a></li>
            </ul>
        </li>

        <li><span class="org-nav-label mt-2">Rekap & Laporan</span></li>
        <li>
            <button class="org-nav-dropdown-btn {{ request()->routeIs('absensi.*') ? 'open' : '' }}" onclick="toggleDropdown('submenuAbsensi', this)" type="button">
                <i class="bi bi-clipboard-check-fill"></i> Data Absensi <i class="bi bi-chevron-down arrow"></i>
            </button>
            <ul class="org-nav-submenu {{ request()->routeIs('absensi.*') ? 'open' : '' }}" id="submenuAbsensi">
                <li><a href="{{ route('absensi.index', ['jenis' => 'pengajian']) }}" class="org-nav-sublink {{ request()->routeIs('absensi.*') && request('jenis') === 'pengajian' ? 'active-sub' : '' }}"><i class="bi bi-book-fill"></i> Pengajian</a></li>
                <li><a href="{{ route('absensi.index', ['jenis' => 'sekolah']) }}" class="org-nav-sublink {{ request()->routeIs('absensi.*') && request('jenis') === 'sekolah' ? 'active-sub' : '' }}"><i class="bi bi-mortarboard-fill"></i> Sekolah</a></li>
            </ul>
        </li>
        <li>
            <button class="org-nav-dropdown-btn {{ request()->routeIs('evaluasi.*') ? 'open' : '' }}" onclick="toggleDropdown('submenuEvaluasi', this)" type="button">
                <i class="bi bi-lightning-charge-fill"></i> Evaluasi SP <i class="bi bi-chevron-down arrow"></i>
            </button>
            <ul class="org-nav-submenu {{ request()->routeIs('evaluasi.*') ? 'open' : '' }}" id="submenuEvaluasi">
                <li><a href="{{ route('evaluasi.index', ['jenis' => 'pengajian']) }}" class="org-nav-sublink {{ request()->routeIs('evaluasi.*') && request('jenis', 'pengajian') === 'pengajian' ? 'active-sub' : '' }}"><i class="bi bi-book-fill"></i> Pengajian</a></li>
                <li><a href="{{ route('evaluasi.index', ['jenis' => 'sekolah']) }}" class="org-nav-sublink {{ request()->routeIs('evaluasi.*') && request('jenis') === 'sekolah' ? 'active-sub' : '' }}"><i class="bi bi-mortarboard-fill"></i> Sekolah</a></li>
            </ul>
        </li>

        <li><span class="org-nav-label mt-2">Sistem</span></li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-person-gear"></i> Kelola Akun
            </a>
        </li>
        <li>
            <a class="org-nav-link {{ request()->routeIs('setting.*') ? 'active' : '' }}" href="{{ route('setting.index') }}">
                <i class="bi bi-gear-fill"></i> Pengaturan
            </a>
        </li>
        @endif
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
    <div style="max-width:1100px; margin:0 auto;">
        
        <!-- Mobile Header -->
        <div class="org-mobile-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:32px; height:32px; object-fit:contain;">
                <h5 style="margin:0; font-family:'Fraunces',serif; font-weight:700; color:var(--primary); font-size:1.1rem;">Al-Furqoniyah</h5>
            </div>
            <button class="org-mobile-toggle" id="mobileToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Toast Notifications -->
        <div class="toast-area">
            @if(session('success'))
                <div class="org-alert auto-dismiss" style="background:var(--positive);">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="org-alert auto-dismiss" style="background:var(--negative);">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="org-alert auto-dismiss" style="background:var(--negative);">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                </div>
            @endif
        </div>

        @yield('content')
    </div>
</main>
@else
<main style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem;">
    @yield('content')
</main>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if(toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            });
        }
        if(overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        }

        // Auto dismiss alerts
        document.querySelectorAll('.auto-dismiss').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 4000);
        });
    });

    function toggleDropdown(menuId, btn) {
        const menu = document.getElementById(menuId);
        const isOpen = menu.classList.contains('open');
        menu.classList.toggle('open', !isOpen);
        btn.classList.toggle('open', !isOpen);
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
