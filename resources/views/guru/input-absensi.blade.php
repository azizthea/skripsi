@extends(in_array(auth()->user()->role, ['admin', 'bk', 'pengurus']) ? (auth()->user()->role === 'admin' ? 'layouts.app' : 'layouts.' . auth()->user()->role) : 'layouts.guru')

@section('extra-styles')
<style>
    /* SIAKAD-style attendance table */
    .absensi-header {
        background: linear-gradient(135deg, var(--af-guru, #5D7052), var(--af-guru-dark, #4A5E42)) !important;
        color: #FFFFFF !important;
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(47,133,90,0.3);
    }
    .absensi-header h3, .absensi-header p, .absensi-header i {
        color: #FFFFFF !important;
    }
    .filter-card {
        background: var(--af-bg);
        border-radius: 20px;
        box-shadow: var(--neo-shadow-outer);
        border: 1px solid rgba(255,255,255,0.4);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .absensi-table-wrapper {
        background: var(--af-bg);
        border-radius: 20px;
        box-shadow: var(--neo-shadow-outer);
        border: 1px solid rgba(255,255,255,0.4);
        overflow: hidden;
    }
    .absensi-table-header {
        background: linear-gradient(135deg, rgba(47, 133, 90, 0.08), rgba(47, 133, 90, 0.03));
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(163, 177, 198, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .student-row {
        display: flex;
        align-items: center;
        padding: 14px 24px;
        border-bottom: 1px solid rgba(163, 177, 198, 0.12);
        transition: background 0.2s;
        gap: 1.25rem;
    }
    .student-row:last-child { border-bottom: none; }
    .student-row:hover { background: rgba(47, 133, 90, 0.04); }
    .student-no {
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(163, 177, 198, 0.25);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.8rem; color: #718096;
        flex-shrink: 0;
    }
    .student-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        object-fit: cover; border: 2px solid rgba(47, 133, 90, 0.3);
        flex-shrink: 0;
    }
    .student-avatar-initial {
        width: 40px; height: 40px; border-radius: 50%;
        background: rgba(47, 133, 90, 0.12);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.9rem; color: var(--af-guru);
        border: 2px solid rgba(47, 133, 90, 0.2);
        flex-shrink: 0;
    }
    .student-info { flex: 1; min-width: 0; }
    .student-name { font-weight: 600; font-size: 0.95rem; color: var(--af-dark); white-space: normal; word-break: break-word; }
    .student-detail { font-size: 0.75rem; color: #718096; }
    /* Radio toggle buttons for status */
    .status-toggle { display: flex; gap: 8px; }
    .status-toggle input[type="radio"] { display: none; }
    .status-toggle label {
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: var(--neo-shadow-btn);
        border: none;
        background: var(--af-bg);
        color: #718096;
        user-select: none;
        white-space: nowrap;
        margin-bottom: 0;
    }
    .status-toggle input[value="Hadir"]:checked + label {
        background: linear-gradient(135deg, #38A169, #2F6F4A);
        color: white;
        box-shadow: 0 4px 12px rgba(56,161,105,0.4);
    }
    .status-toggle input[value="Izin"]:checked + label {
        background: linear-gradient(135deg, #D69E2E, #B7791F);
        color: white;
        box-shadow: 0 4px 12px rgba(214,158,46,0.4);
    }
    .status-toggle input[value="Sakit"]:checked + label {
        background: linear-gradient(135deg, #4299E1, #2B6CB0);
        color: white;
        box-shadow: 0 4px 12px rgba(66,153,225,0.4);
    }
    .status-toggle input[value="Alpa"]:checked + label {
        background: linear-gradient(135deg, #E53E3E, #C53030);
        color: white;
        box-shadow: 0 4px 12px rgba(229,62,62,0.4);
    }
    /* Floating save bar */
    .floating-save-bar {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 20px;
        padding: 1rem 2rem;
        box-shadow: 0 8px 40px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        z-index: 900;
        border: 1px solid rgba(255,255,255,0.8);
        width: 90%;
        max-width: 500px;
    }
    .save-counter { font-size: 0.85rem; color: #718096; flex-grow: 1; }
    .save-counter strong { color: var(--af-guru); font-size: 1rem; }
    /* Quick select all buttons */
    .quick-select { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-quick {
        padding: 6px 16px; border-radius: 50px; font-weight: 600; font-size: 0.8rem;
        border: none; cursor: pointer; transition: all 0.2s; box-shadow: var(--neo-shadow-btn);
        background: var(--af-bg);
    }
    .btn-quick-hadir { color: #38A169; }
    .btn-quick-hadir:hover { background: #38A169; color: white; }
    .btn-quick-izin { color: #D69E2E; }
    .btn-quick-izin:hover { background: #D69E2E; color: white; }
    .btn-quick-sakit { color: #3182CE; }
    .btn-quick-sakit:hover { background: #3182CE; color: white; }
    .btn-quick-alpa { color: #E53E3E; }
    .btn-quick-alpa:hover { background: #E53E3E; color: white; }

    @media (max-width: 767px) {
        .student-row {
            padding: 14px 16px;
            gap: 1rem;
        }
        .absensi-table-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1.5rem 1.25rem;
            gap: 1.25rem;
            text-align: center;
        }
        .keterangan-popup.show-mobile {
            display: block !important;
            position: fixed;
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 1055; width: 90%; max-width: 400px;
            background: #fff; padding: 1.5rem; border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .keterangan-backdrop {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5); z-index: 1050;
        }
        .keterangan-backdrop.show-mobile { display: block; }
    }
    @media (min-width: 768px) {
        .keterangan-popup.show-desktop {
            display: block !important;
            width: 100%;
            padding-left: 60px;
            margin-top: 0.5rem;
        }
        .keterangan-backdrop { display: none !important; }
    }
    .keterangan-popup { display: none; }
        .absensi-table-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1.5rem 1.25rem;
            gap: 1.25rem;
            text-align: center;
        }
        .quick-select {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 0.25rem;
        }
        .quick-select span {
            width: 100%;
            text-align: center;
            margin-bottom: 4px;
            display: block;
        }
    }

    @media (max-width: 576px) {
        .floating-save-bar {
            bottom: 1rem;
            padding: 0.6rem 1rem;
            width: 95%;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            border-radius: 16px;
        }
        .save-counter {
            text-align: left;
            font-size: 0.7rem;
            line-height: 1.2;
        }
        .save-counter .fw-bold {
            font-size: 0.75rem !important;
        }
        .save-counter strong {
            font-size: 0.85rem;
        }
        .floating-save-bar button {
            width: auto;
            padding: 8px 14px !important;
            font-size: 0.8rem !important;
        }
        .floating-save-bar button i {
            margin-right: 4px !important;
        }
        
        .absensi-header {
            padding: 1.25rem 1rem;
            text-align: center;
        }
        .absensi-header .d-flex {
            justify-content: center !important;
            flex-direction: column;
        }
        .absensi-header a {
            width: 100%;
        }
    }

    /* ===== CUSTOM DATE PICKER — Organic Theme ===== */
    .custom-datepicker-wrapper {
        position: relative;
    }
    .custom-datepicker-trigger {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem 1.25rem;
        background: white;
        border-radius: 50px;
        border: 1.5px solid #DED8CF;
        cursor: pointer;
        transition: all 0.25s ease;
        user-select: none;
        min-height: 38px;
        height: 38px;
        width: 100%;
        font-family: 'Nunito', sans-serif;
        font-size: 0.85rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        white-space: nowrap;
        overflow: hidden;
    }
    .custom-datepicker-trigger:hover {
        border-color: #4A5568;
        background: white;
    }
    .custom-datepicker-trigger.active {
        border-color: #4A5568;
        box-shadow: 0 0 0 3px rgba(74,85,104,0.15);
        background: white;
    }
    .custom-datepicker-trigger .dp-cal-icon {
        color: #78786C;
        font-size: 0.85rem;
        flex-shrink: 0;
        cursor: pointer;
        pointer-events: none;
    }
    .custom-datepicker-trigger .dp-value {
        flex: 1;
        color: #2C2C24;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        pointer-events: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .custom-datepicker-trigger .dp-value.placeholder {
        color: #A0AEC0;
        font-weight: 400;
    }
    .custom-datepicker-trigger .dp-arrow {
        color: #78786C;
        transition: transform 0.2s;
        font-size: 0.7rem;
        cursor: pointer;
        pointer-events: none;
    }
    .custom-datepicker-trigger.active .dp-arrow { transform: rotate(180deg); }

    /* Popup */
    .custom-datepicker-popup {
        position: fixed;
        z-index: 9999;
        width: 300px;
        background: white;
        border-radius: 1.5rem;
        border: 1px solid #DED8CF;
        box-shadow: 0 10px 40px -10px rgba(74,85,104,0.25);
        padding: 1.25rem;
        opacity: 0;
        transform: scale(0.97) translateY(-4px);
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.34, 1.4, 0.64, 1);
        font-family: 'Nunito', sans-serif;
    }
    .custom-datepicker-popup.show {
        opacity: 1;
        transform: scale(1) translateY(0);
        pointer-events: all;
    }

    /* Header */
    .dp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .dp-nav-btn {
        width: 30px; height: 30px;
        border-radius: 50%;
        border: 1.5px solid #DED8CF;
        background: white;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #4A5568;
        font-size: 0.75rem;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .dp-nav-btn:hover {
        background: #4A5568;
        color: white;
        border-color: #4A5568;
    }
    .dp-month-year {
        font-weight: 800;
        font-size: 0.92rem;
        color: #2C2C24;
        letter-spacing: -0.01em;
    }

    /* Weekdays */
    .dp-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 6px;
    }
    .dp-weekday {
        text-align: center;
        font-size: 0.65rem;
        font-weight: 700;
        color: #A0AEC0;
        text-transform: uppercase;
        padding: 3px 0;
    }

    /* Days grid */
    .dp-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }
    .dp-day {
        aspect-ratio: 1;
        border-radius: 50%;
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        color: #2C2C24;
        font-family: 'Nunito', sans-serif;
        transition: all 0.15s ease;
        display: flex; align-items: center; justify-content: center;
    }
    .dp-day:hover:not(.dp-day-selected) {
        background: #F0EBE5;
        color: #4A5568;
    }
    .dp-day-today:not(.dp-day-selected) {
        background: rgba(93,112,82,0.12);
        color: #5D7052;
        font-weight: 800;
        position: relative;
    }
    .dp-day-today:not(.dp-day-selected)::after {
        content: '';
        position: absolute;
        bottom: 3px;
        left: 50%; transform: translateX(-50%);
        width: 3px; height: 3px;
        border-radius: 50%;
        background: #5D7052;
    }
    .dp-day-selected {
        background: #4A5568 !important;
        color: white !important;
        font-weight: 800;
        box-shadow: 0 4px 12px -2px rgba(74,85,104,0.4);
    }
    .dp-day-other-month {
        color: #C1C9D2;
    }

    /* Footer */
    .dp-footer {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #F0EBE5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dp-today-btn {
        font-size: 0.78rem;
        font-weight: 700;
        color: #5D7052;
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 4px 10px;
        border-radius: 50px;
        font-family: 'Nunito', sans-serif;
        transition: background 0.2s;
    }
    .dp-today-btn:hover { background: rgba(93,112,82,0.1); }
    .dp-clear-btn {
        font-size: 0.78rem;
        font-weight: 600;
        color: #A0AEC0;
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 4px 10px;
        border-radius: 50px;
        font-family: 'Nunito', sans-serif;
        transition: background 0.2s;
    }
    .dp-clear-btn:hover { background: #F0EBE5; color: #78786C; }
</style>
@endsection

@section('content')
<div class="container-fluid pb-5" style="padding-bottom: 100px !important;">

    <!-- Header -->
    <div class="absensi-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-clipboard-check-fill me-2"></i>
                    Input Absensi – {{ in_array($jenisKegiatan, ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian']) ? 'Pengajian' : 'Sekolah' }}
                </h3>
                <p class="mb-0" style="opacity: 0.85; font-size: 0.9rem;">Sistem Absensi Online — Al-Furqoniyah</p>
            </div>
            <a href="{{ in_array(auth()->user()->role, ['admin', 'bk', 'pengurus']) ? route('dashboard') : route('guru.dashboard') }}" class="neo-btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Filter Form (SIAKAD-style) -->
    <div class="filter-card">
        <h6 class="fw-bold mb-3" style="color: var(--af-guru)"><i class="bi bi-funnel me-2"></i>Pilih Kelas & Sesi</h6>
        <form method="GET" action="{{ route('guru.input-absensi') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                @if(isset($isPengajian) && $isPengajian)
                    <label>Ruang Pengajian <span class="text-danger">*</span></label>
                    <select name="kelas" class="form-select neo-input" required>
                        <option value="">-- Pilih Ruang --</option>
                        @foreach($ruangList as $ruang)
                            <option value="{{ $ruang }}" {{ trim($kelasFilter ?? '') === trim($ruang) ? 'selected' : '' }}>
                                {{ $ruang }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <label>Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" class="form-select neo-input" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->nama_kelas }}" {{ trim($kelasFilter ?? '') === trim($kelas->nama_kelas) ? 'selected' : '' }}>
                                {{ $kelas->jenjang }} – {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="col-md-3">
                <label>Mata Pelajaran <span class="text-danger">*</span></label>
                @php
                    $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
                    $isPengajian = in_array($jenisKegiatan, $pengajianSubjects);
                @endphp
                <select name="jenis_kegiatan" class="form-select neo-input" required>
                    @if($isPengajian)
                        <option value="Al-Quran"         {{ $jenisKegiatan == 'Al-Quran'         ? 'selected' : '' }}>📖 Al-Quran</option>
                        <option value="Fiqih"            {{ $jenisKegiatan == 'Fiqih'            ? 'selected' : '' }}>📖 Fiqih</option>
                        <option value="Tafsir"           {{ $jenisKegiatan == 'Tafsir'           ? 'selected' : '' }}>📖 Tafsir</option>
                        <option value="Hadits"           {{ $jenisKegiatan == 'Hadits'           ? 'selected' : '' }}>📖 Hadits</option>
                        <option value="Akhlak"           {{ $jenisKegiatan == 'Akhlak'           ? 'selected' : '' }}>📖 Akhlak</option>
                        <option value="Bahasa Arab"      {{ $jenisKegiatan == 'Bahasa Arab'      ? 'selected' : '' }}>📖 Bahasa Arab</option>
                    @else
                        <option value="Matematika"       {{ $jenisKegiatan == 'Matematika'       ? 'selected' : '' }}>🎓 Matematika</option>
                        <option value="Bahasa Indonesia" {{ $jenisKegiatan == 'Bahasa Indonesia' ? 'selected' : '' }}>🎓 Bahasa Indonesia</option>
                        <option value="Bahasa Inggris"   {{ $jenisKegiatan == 'Bahasa Inggris'   ? 'selected' : '' }}>🎓 Bahasa Inggris</option>
                        <option value="IPA"              {{ $jenisKegiatan == 'IPA'              ? 'selected' : '' }}>🎓 IPA</option>
                        <option value="IPS"              {{ $jenisKegiatan == 'IPS'              ? 'selected' : '' }}>🎓 IPS</option>
                        <option value="PKn"              {{ $jenisKegiatan == 'PKn'              ? 'selected' : '' }}>🎓 PKn</option>
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label>Tanggal <span class="text-danger">*</span></label>
                {{-- Hidden input for form submission --}}
                <input type="hidden" name="tanggal" id="tanggalHidden" value="{{ $tanggal }}" required>
                <div class="custom-datepicker-wrapper">
                    <div class="custom-datepicker-trigger" id="dpTrigger" onclick="toggleDatepicker()">
                        <i class="bi bi-calendar3 dp-cal-icon"></i>
                        <span class="dp-value {{ $tanggal ? '' : 'placeholder' }}" id="dpDisplay">
                            {{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d/m/Y') : 'Pilih tanggal...' }}
                        </span>
                        <i class="bi bi-chevron-down dp-arrow"></i>
                    </div>
                    <div class="custom-datepicker-popup" id="dpPopup">
                        <div class="dp-header">
                            <button type="button" class="dp-nav-btn" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                            <span class="dp-month-year" id="dpMonthYear"></span>
                            <button type="button" class="dp-nav-btn" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <div class="dp-weekdays">
                            <div class="dp-weekday">Min</div>
                            <div class="dp-weekday">Sen</div>
                            <div class="dp-weekday">Sel</div>
                            <div class="dp-weekday">Rab</div>
                            <div class="dp-weekday">Kam</div>
                            <div class="dp-weekday">Jum</div>
                            <div class="dp-weekday">Sab</div>
                        </div>
                        <div class="dp-days" id="dpDays"></div>
                        <div class="dp-footer">
                            <button type="button" class="dp-today-btn" onclick="selectToday()"><i class="bi bi-geo-alt-fill me-1"></i>Hari Ini</button>
                            <button type="button" class="dp-clear-btn" onclick="clearDate()">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="neo-btn neo-btn-primary w-100" style="padding: 11px;">
                    <i class="bi bi-search me-2"></i>Tampilkan Santri
                </button>
            </div>
        </form>
    </div>

    @if($kelasFilter && $santris->count() > 0)
    <!-- Absensi Table (SIAKAD-style) -->
    <form action="{{ route('guru.store-absensi-batch') }}" method="POST" id="absensiForm" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="kelas" value="{{ $kelasFilter }}">
        <input type="hidden" name="jenis_kegiatan" value="{{ $jenisKegiatan }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="absensi-table-wrapper">
            <div class="absensi-table-header">
                <div>
                    <h6 class="fw-bold mb-0" style="color: var(--af-guru);">
                        <i class="bi bi-book-open-fill me-2" style="color: var(--af-guru)"></i>
                        {{ $jenisKegiatan }} — Kelas {{ $kelasFilter }}
                        <span class="badge ms-2" style="background: rgba(47,133,90,0.12); color: var(--af-guru); border-radius: 50px; padding: 4px 12px; font-size: 0.78rem;">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                        </span>
                    </h6>
                    <small class="text-muted">{{ $santris->count() }} santri terdaftar</small>
                </div>
                <!-- Quick Select All -->
                <div class="quick-select">
                    <span class="text-muted small me-1 align-self-center">Set semua:</span>
                    <button type="button" class="btn-quick btn-quick-hadir" onclick="setAll('Hadir')">
                        <i class="bi bi-check-circle me-1"></i>Hadir
                    </button>
                    <button type="button" class="btn-quick btn-quick-izin" onclick="setAll('Izin')">
                        <i class="bi bi-envelope me-1"></i>Izin
                    </button>
                    <button type="button" class="btn-quick btn-quick-sakit" onclick="setAll('Sakit')">
                        <i class="bi bi-thermometer-half me-1"></i>Sakit
                    </button>
                    <button type="button" class="btn-quick btn-quick-alpa" onclick="setAll('Alpa')">
                        <i class="bi bi-x-circle me-1"></i>Alpa
                    </button>
                </div>
            </div>

            <!-- Student Rows -->
            @foreach($santris as $index => $santri)
            @php $existing = $existingAbsensi->get($santri->id); @endphp
            <div class="student-row" style="flex-wrap: wrap;">
                @if($santri->foto)
                    <img src="{{ asset('storage/' . $santri->foto) }}" alt="{{ $santri->nama }}" class="student-avatar">
                @else
                    <div class="student-avatar-initial">{{ substr($santri->nama, 0, 1) }}</div>
                @endif
                <div class="student-info">
                    <div class="student-name">{{ $santri->nama }}</div>
                    <div class="student-detail">
                        <i class="bi bi-house-fill me-1" style="color: var(--af-guru)"></i>{{ $santri->kamar ?? 'N/A' }}
                        &bull; {{ $santri->jenjang }}
                        @if($santri->jenis_kelamin == 'Putra')
                            &bull; <span class="badge bg-primary text-white" style="font-size: 0.65rem;">L</span>
                        @elseif($santri->jenis_kelamin == 'Putri')
                            &bull; <span class="badge bg-danger text-white" style="font-size: 0.65rem;">P</span>
                        @endif
                    </div>
                </div>
                <div class="status-toggle ms-auto d-none d-md-flex align-items-center">
                    @foreach(['Hadir', 'Izin', 'Sakit', 'Alpa'] as $status)
                        @if(in_array($status, ['Izin', 'Sakit']))
                            <div class="position-relative d-inline-block">
                        @endif
                        
                        <input type="radio"
                            id="status_{{ $santri->id }}_{{ $status }}"
                            name="absensi[{{ $santri->id }}]"
                            value="{{ $status }}"
                            class="status-radio"
                            data-group="{{ $santri->id }}"
                            {{ $existing && $existing->status === $status ? 'checked' : '' }}>
                        <label for="status_{{ $santri->id }}_{{ $status }}">
                            @if($status === 'Hadir') ✓ Hadir
                            @elseif($status === 'Izin') 📩 Izin
                            @elseif($status === 'Sakit') 🤒 Sakit
                            @else ✗ Alpa
                            @endif
                        </label>

                        @if(in_array($status, ['Izin', 'Sakit']))
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="status-select-mobile d-md-none ms-auto me-2 position-relative">
                    <select class="form-select status-select-dropdown" data-group="{{ $santri->id }}" style="border-radius: 12px; font-weight: 600; padding: 6px 30px 6px 12px; border: none; font-size: 0.85rem; width: auto; position: relative; z-index: 5;">
                        <option value="" {{ !$existing ? 'selected' : '' }} disabled>Pilih</option>
                        <option value="Hadir" {{ $existing && $existing->status === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ $existing && $existing->status === 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ $existing && $existing->status === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alpa" {{ $existing && $existing->status === 'Alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                    
                    <!-- Icon Button di bawah Select -->
                    <button type="button" id="btn_izin_mobile_{{ $santri->id }}" class="btn btn-sm p-0 position-absolute btn-izin-toggle" style="top: 100%; left: 50%; transform: translateX(-50%); display: {{ $existing && in_array($existing->status, ['Izin', 'Sakit']) ? 'block' : 'none' }}; color: #D69E2E; padding-top: 2px !important; z-index: 10;" title="Keterangan & Bukti" onclick="openPopup({{ $santri->id }})">
                        <i class="bi bi-paperclip fs-5" style="filter: drop-shadow(0 2px 4px rgba(214,158,46,0.3));"></i>
                    </button>
                </div>
                
                <!-- Keterangan Izin Container (Inline di Desktop, Popup di Mobile) -->
                <div id="keterangan_container_{{ $santri->id }}" class="keterangan-popup {{ $existing && in_array($existing->status, ['Izin', 'Sakit']) ? 'show-desktop' : '' }}">
                    <!-- Mobile Header -->
                    <div class="d-md-none d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-envelope-paper me-2"></i>Keterangan Izin</h6>
                        <button type="button" class="btn-close" onclick="closePopup({{ $santri->id }})"></button>
                    </div>
                    
                    <div class="d-flex flex-column flex-md-row gap-2" style="max-width: 600px;">
                        <input type="text" name="keterangan[{{ $santri->id }}]" class="form-control form-control-sm neo-input flex-grow-1" placeholder="Tulis alasan izin (opsional)..." value="{{ $existing ? $existing->keterangan : '' }}" style="border: 1px solid rgba(214,158,46,0.3); background: rgba(214,158,46,0.05); border-radius: 8px; font-size: 0.85rem; color: #718096;">
                        
                        <div class="input-group input-group-sm" style="flex: 0 0 auto; width: auto;">
                            <span class="input-group-text" style="background: rgba(214,158,46,0.1); border: 1px solid rgba(214,158,46,0.3); color: #B7791F; border-radius: 8px 0 0 8px;"><i class="bi bi-paperclip"></i> Bukti (opsional)</span>
                            <input type="file" name="bukti_izin[{{ $santri->id }}]" class="form-control form-control-sm neo-input" accept=".jpg,.jpeg,.png,.pdf" style="border: 1px solid rgba(214,158,46,0.3); background: rgba(214,158,46,0.05); border-radius: 0 8px 8px 0; font-size: 0.8rem; width: 190px;">
                        </div>
                    </div>
                    @if($existing && $existing->bukti_izin)
                        <div class="mt-1 small" style="font-size: 0.75rem;">
                            <a href="{{ asset('storage/' . $existing->bukti_izin) }}" target="_blank" class="text-decoration-none" style="color: #D69E2E;"><i class="bi bi-file-earmark-check me-1"></i>Lihat Bukti Terlampir</a>
                        </div>
                    @endif

                    <!-- Mobile Footer -->
                    <div class="d-md-none mt-4">
                        <button type="button" class="neo-btn w-100 text-center" style="background: linear-gradient(135deg, #D69E2E, #B7791F); color: white; border-radius: 12px; padding: 10px;" onclick="closePopup({{ $santri->id }})">
                            <i class="bi bi-check2-circle me-2"></i>Simpan Keterangan
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div id="mobileBackdrop" class="keterangan-backdrop d-md-none" onclick="closeAllPopups()"></div>

        <!-- Floating Save Bar -->
        <div class="floating-save-bar">
            <div class="save-counter text-truncate">
                <div class="fw-bold text-truncate" style="font-size: 0.9rem; color: var(--af-dark);">
                    <i class="bi bi-clipboard-check me-1" style="color: var(--af-guru)"></i>
                    {{ $jenisKegiatan }} <span class="d-none d-sm-inline">· {{ $kelasFilter }}</span>
                </div>
                <div class="text-truncate">
                    <span class="d-none d-sm-inline">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }} · </span>
                    <strong id="countHadir">{{ $santris->count() }}</strong> santri <span class="d-none d-sm-inline">siap disimpan</span>
                </div>
            </div>
            <button type="submit" class="neo-btn neo-btn-primary" style="padding: 12px 28px; font-size: 0.9rem; white-space: nowrap; flex-shrink: 0;">
                <i class="bi bi-save-fill me-2"></i><span class="d-none d-sm-inline">Simpan Absensi</span><span class="d-inline d-sm-none">Simpan</span>
            </button>
        </div>
    </form>

    @elseif($kelasFilter && $santris->count() === 0)
    <div class="neo-card text-center py-5">
        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
        <h5 class="fw-bold text-muted">Tidak ada santri aktif di kelas ini</h5>
        <p class="text-muted">Periksa data santri atau pilih kelas lain.</p>
    </div>
    @else
    <div class="neo-card text-center py-5">
        <div style="width: 80px; height: 80px; background: rgba(49,130,206,0.1); border-radius: 24px; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-up-circle" style="font-size: 2.5rem; color: var(--af-guru);"></i>
        </div>
        <h5 class="fw-bold mb-2">Pilih Kelas Terlebih Dahulu</h5>
        <p class="text-muted">Pilih kelas, mata pelajaran, dan tanggal di form di atas untuk menampilkan daftar santri.</p>
    </div>
    @endif

</div>
@endsection

@section('extra-scripts')
<script>
function setAll(status) {
    document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(radio => {
        radio.checked = true;
        radio.dispatchEvent(new Event('change'));
    });
    updateCount();
}

function updateCount() {
    const total = document.querySelectorAll('.status-radio[value="Hadir"]:checked').length
        + document.querySelectorAll('.status-radio[value="Izin"]:checked').length
        + document.querySelectorAll('.status-radio[value="Sakit"]:checked').length
        + document.querySelectorAll('.status-radio[value="Alpa"]:checked').length;
    const el = document.getElementById('countHadir');
    if (el) el.textContent = total;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-radio').forEach(radio => {
        radio.addEventListener('change', updateCount);
    });
    updateCount();

    // Color and Sync logic for mobile dropdowns
    const dropdowns = document.querySelectorAll('.status-select-dropdown');
    
    const updateSelectStyle = (select, val) => {
        if (val === 'Hadir') {
            select.style.color = '#38A169';
            select.style.background = 'rgba(56,161,105,0.15)';
        } else if (val === 'Izin') {
            select.style.color = '#B7791F';
            select.style.background = 'rgba(214,158,46,0.15)';
        } else if (val === 'Sakit') {
            select.style.color = '#3182CE';
            select.style.background = 'rgba(49,130,206,0.15)';
        } else if (val === 'Alpa') {
            select.style.color = '#E53E3E';
            select.style.background = 'rgba(229,62,62,0.12)';
        } else {
            select.style.color = '#718096';
            select.style.background = 'rgba(163,177,198,0.2)';
        }
    };

    dropdowns.forEach(select => {
        // Set initial styles
        updateSelectStyle(select, select.value);

        // On change: update checked radio button
        select.addEventListener('change', function() {
            const group = this.getAttribute('data-group');
            const val = this.value;
            const radio = document.querySelector(`input[type="radio"][data-group="${group}"][value="${val}"]`);
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
            updateSelectStyle(this, val);
        });

        // Add custom event for styling sync from radio buttons
        select.addEventListener('update-style', function() {
            updateSelectStyle(this, this.value);
        });
    });

    // Sync radio button changes back to mobile dropdown
    document.querySelectorAll('.status-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const group = this.getAttribute('data-group');
                const val = this.value;
                const select = document.querySelector(`.status-select-dropdown[data-group="${group}"]`);
                if (select) {
                    select.value = val;
                    select.dispatchEvent(new Event('update-style'));
                }
                
                // Toggle Inline Desktop Display
                const ketContainer = document.getElementById('keterangan_container_' + group);
                if (ketContainer) {
                    if (val === 'Izin' || val === 'Sakit') {
                        ketContainer.classList.add('show-desktop');
                    } else {
                        ketContainer.classList.remove('show-desktop');
                    }
                }
                
                // Toggle Mobile Icon Button
                const btnMobile = document.getElementById('btn_izin_mobile_' + group);
                if (btnMobile) {
                    btnMobile.style.display = (val === 'Izin' || val === 'Sakit') ? 'block' : 'none';
                }
            }
        });
    });

    // Highlight row on change
    document.querySelectorAll('.status-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const row = this.closest('.student-row');
            if (row && this.checked) {
                row.style.transition = 'background 0.3s';
                row.style.background = 'rgba(47, 133, 90, 0.08)';
                setTimeout(() => row.style.background = '', 600);
            }
        });
    });

    // Validate form before submit
    const absensiForm = document.getElementById('absensiForm');
    if (absensiForm) {
        absensiForm.addEventListener('submit', function(e) {
            const totalSantri = {{ isset($santris) ? count($santris) : 0 }};
            if (totalSantri === 0) return;

            const checkedCount = document.querySelectorAll('.status-radio:checked').length;
            
            if (checkedCount < totalSantri) {
                e.preventDefault();
                Swal.fire({
                    title: 'Absensi Belum Lengkap!',
                    html: `Anda baru mengisi <strong>${checkedCount}</strong> dari <strong>${totalSantri}</strong> santri.<br>Mohon pastikan seluruh santri telah diberikan status (Hadir/Izin/Sakit/Alpa) sebelum menyimpan data.`,
                    icon: 'warning',
                    confirmButtonColor: 'var(--af-guru)',
                    confirmButtonText: '<i class="bi bi-pencil-square"></i> Lengkapi Sekarang',
                    shape: 'pill'
                });
            }
        });
    }
});

function openPopup(id) {
    document.getElementById('keterangan_container_' + id).classList.add('show-mobile');
    document.getElementById('mobileBackdrop').classList.add('show-mobile');
}
function closePopup(id) {
    document.getElementById('keterangan_container_' + id).classList.remove('show-mobile');
    document.getElementById('mobileBackdrop').classList.remove('show-mobile');
}
function closeAllPopups() {
    document.querySelectorAll('.keterangan-popup').forEach(el => el.classList.remove('show-mobile'));
    document.getElementById('mobileBackdrop').classList.remove('show-mobile');
}

// ===== CUSTOM DATE PICKER =====
const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const MONTHS_SHORT = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

let dpCurrentDate = new Date();
let dpSelectedDate = null;

// Init from existing value
(function() {
    const existing = document.getElementById('tanggalHidden').value;
    if (existing) {
        const parts = existing.split('-');
        dpSelectedDate = new Date(parseInt(parts[0]), parseInt(parts[1])-1, parseInt(parts[2]));
        dpCurrentDate = new Date(dpSelectedDate);
    }
    renderCalendar();
})();

function toggleDatepicker() {
    const popup = document.getElementById('dpPopup');
    const trigger = document.getElementById('dpTrigger');
    const isOpen = popup.classList.contains('show');
    if (isOpen) {
        popup.classList.remove('show');
        trigger.classList.remove('active');
    } else {
        renderCalendar();
        const rect = trigger.getBoundingClientRect();
        const popupH = 360;
        const popupW = 310;
        const margin = 10;

        // Determine vertical position
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;
        let top;
        if (spaceBelow >= popupH + margin) {
            // Enough space below → open downward
            top = rect.bottom + margin;
        } else if (spaceAbove >= popupH + margin) {
            // Enough space above → open upward
            top = rect.top - popupH - margin;
        } else {
            // Not enough on either side → center vertically in viewport
            top = Math.max(margin, (window.innerHeight - popupH) / 2);
        }
        // Clamp: never go above top margin or below bottom margin
        top = Math.max(margin, Math.min(top, window.innerHeight - popupH - margin));

        // Determine horizontal position
        let left = rect.left;
        if (left + popupW > window.innerWidth - margin) {
            left = window.innerWidth - popupW - margin;
        }
        left = Math.max(margin, left);

        popup.style.top  = top + 'px';
        popup.style.left = left + 'px';
        popup.classList.add('show');
        trigger.classList.add('active');
    }
}

function closeDatepicker() {
    document.getElementById('dpPopup').classList.remove('show');
    document.getElementById('dpTrigger').classList.remove('active');
}

function changeMonth(dir) {
    dpCurrentDate.setMonth(dpCurrentDate.getMonth() + dir);
    renderCalendar();
}

function renderCalendar() {
    const y = dpCurrentDate.getFullYear();
    const m = dpCurrentDate.getMonth();
    document.getElementById('dpMonthYear').textContent = MONTHS_ID[m] + ' ' + y;

    const firstDay = new Date(y, m, 1).getDay();
    const daysInMonth = new Date(y, m+1, 0).getDate();
    const daysInPrev = new Date(y, m, 0).getDate();
    const today = new Date();

    let html = '';
    // Prev month filler
    for (let i = firstDay - 1; i >= 0; i--) {
        const d = daysInPrev - i;
        html += `<button type="button" class="dp-day dp-day-other-month" onclick="selectDate(${y},${m-1<0?11:m-1},${d})">${d}</button>`;
    }
    // Current month
    for (let d = 1; d <= daysInMonth; d++) {
        const isToday = (d === today.getDate() && m === today.getMonth() && y === today.getFullYear());
        const isSelected = dpSelectedDate && (d === dpSelectedDate.getDate() && m === dpSelectedDate.getMonth() && y === dpSelectedDate.getFullYear());
        let cls = 'dp-day';
        if (isToday) cls += ' dp-day-today';
        if (isSelected) cls += ' dp-day-selected';
        html += `<button type="button" class="${cls}" onclick="selectDate(${y},${m},${d})">${d}</button>`;
    }
    // Next month filler
    const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
    const remaining = totalCells - firstDay - daysInMonth;
    for (let d = 1; d <= remaining; d++) {
        html += `<button type="button" class="dp-day dp-day-other-month" onclick="selectDate(${y},${m+1>11?0:m+1},${d})">${d}</button>`;
    }
    document.getElementById('dpDays').innerHTML = html;
}

function selectDate(y, m, d) {
    dpSelectedDate = new Date(y, m, d);
    dpCurrentDate = new Date(y, m, d);

    // Format as YYYY-MM-DD for hidden input
    const pad = n => String(n).padStart(2, '0');
    const formatted = `${dpSelectedDate.getFullYear()}-${pad(dpSelectedDate.getMonth()+1)}-${pad(dpSelectedDate.getDate())}`;
    document.getElementById('tanggalHidden').value = formatted;

    // Update display
    const displayEl = document.getElementById('dpDisplay');
    displayEl.textContent = `${pad(d)}/${pad(dpSelectedDate.getMonth()+1)}/${dpSelectedDate.getFullYear()}`;
    displayEl.classList.remove('placeholder');

    renderCalendar();
    setTimeout(closeDatepicker, 150);
}

function selectToday() {
    const now = new Date();
    selectDate(now.getFullYear(), now.getMonth(), now.getDate());
}

function clearDate() {
    dpSelectedDate = null;
    document.getElementById('tanggalHidden').value = '';
    const displayEl = document.getElementById('dpDisplay');
    displayEl.textContent = 'Pilih tanggal...';
    displayEl.classList.add('placeholder');
    renderCalendar();
}

// Close on outside click
document.addEventListener('click', function(e) {
    const wrapper = document.querySelector('.custom-datepicker-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        closeDatepicker();
    }
});
</script>
@endsection
