@extends('layouts.app')

@section('extra-styles')
<style>
/* ===== CUSTOM DATE PICKER — Admin Theme ===== */
.custom-datepicker-wrapper { position: relative; }
.custom-datepicker-trigger {
    display: flex; align-items: center; gap: 8px;
    padding: 0.5rem 1.25rem;
    background: white; border-radius: 50px;
    border: 1.5px solid var(--neo-border, #DED8CF);
    cursor: pointer; transition: all 0.25s ease;
    user-select: none; min-height: 38px; height: 38px; width: 100%;
    font-family: inherit; font-size: 0.85rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    white-space: nowrap; overflow: hidden;
}
.custom-datepicker-trigger:hover { border-color: var(--af-positive, #5D7052); }
.custom-datepicker-trigger.active {
    border-color: var(--af-positive, #5D7052);
    box-shadow: 0 0 0 3px rgba(93,112,82,0.15);
}
.custom-datepicker-trigger .dp-cal-icon { color: #78786C; font-size: 0.85rem; flex-shrink: 0; cursor: pointer; pointer-events: none; }
.custom-datepicker-trigger .dp-value { flex: 1; color: var(--af-dark, #2C2C24); font-weight: 600; font-size: 0.85rem; cursor: pointer; pointer-events: none; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.custom-datepicker-trigger .dp-value.placeholder { color: #A0AEC0; font-weight: 400; }
.custom-datepicker-trigger .dp-arrow { color: #78786C; transition: transform 0.2s; font-size: 0.7rem; cursor: pointer; pointer-events: none; }
.custom-datepicker-trigger.active .dp-arrow { transform: rotate(180deg); }

.custom-datepicker-popup {
    position: fixed; z-index: 9999; width: 300px;
    background: white; border-radius: 1.5rem;
    border: 1px solid var(--neo-border, #DED8CF);
    box-shadow: 0 10px 40px -10px rgba(74,85,104,0.25);
    padding: 1.25rem; opacity: 0;
    transform: scale(0.97) translateY(-4px);
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.34, 1.4, 0.64, 1);
    font-family: inherit;
}
.custom-datepicker-popup.show { opacity: 1; transform: scale(1) translateY(0); pointer-events: all; }
.dp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
.dp-nav-btn {
    width: 30px; height: 30px; border-radius: 50%;
    border: 1.5px solid var(--neo-border, #DED8CF); background: white;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--af-positive, #5D7052); font-size: 0.75rem; transition: all 0.2s; flex-shrink: 0;
}
.dp-nav-btn:hover { background: var(--af-positive, #5D7052); color: white; border-color: var(--af-positive, #5D7052); }
.dp-month-year { font-weight: 800; font-size: 0.92rem; color: var(--af-dark, #2C2C24); letter-spacing: -0.01em; }
.dp-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-bottom: 6px; }
.dp-weekday { text-align: center; font-size: 0.65rem; font-weight: 700; color: #A0AEC0; text-transform: uppercase; padding: 3px 0; }
.dp-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
.dp-day {
    aspect-ratio: 1; border-radius: 50%; border: none; background: transparent;
    cursor: pointer; font-size: 0.8rem; font-weight: 600; color: var(--af-dark, #2C2C24);
    font-family: inherit; transition: all 0.15s ease;
    display: flex; align-items: center; justify-content: center;
}
.dp-day:hover:not(.dp-day-selected) { background: var(--af-bg, #F0EBE5); color: var(--af-positive, #5D7052); }
.dp-day-today:not(.dp-day-selected) { background: rgba(93,112,82,0.12); color: #5D7052; font-weight: 800; position: relative; }
.dp-day-today:not(.dp-day-selected)::after {
    content: ''; position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%);
    width: 3px; height: 3px; border-radius: 50%; background: #5D7052;
}
.dp-day-selected { background: var(--af-positive, #5D7052) !important; color: white !important; font-weight: 800; box-shadow: 0 4px 12px -2px rgba(93,112,82,0.4); }
.dp-day-other-month { color: #C1C9D2; }
.dp-footer { margin-top: 10px; padding-top: 10px; border-top: 1px solid #F0EBE5; display: flex; justify-content: space-between; align-items: center; }
.dp-today-btn { font-size: 0.78rem; font-weight: 700; color: #5D7052; border: none; background: transparent; cursor: pointer; padding: 4px 10px; border-radius: 50px; font-family: inherit; transition: background 0.2s; }
.dp-today-btn:hover { background: rgba(93,112,82,0.1); }
.dp-clear-btn { font-size: 0.78rem; font-weight: 600; color: #A0AEC0; border: none; background: transparent; cursor: pointer; padding: 4px 10px; border-radius: 50px; font-family: inherit; transition: background 0.2s; }
.dp-clear-btn:hover { background: #F0EBE5; color: #78786C; }
</style>
@endsection

@section('content')


<!-- Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--af-positive)">
            <i class="bi bi-clipboard-check me-2"></i>Data Absensi {{ request('jenis') ? '— ' . ucfirst(request('jenis')) : '' }}
        </h3>
        <p class="text-muted mb-0">Kelola data kehadiran santri (Pengajian & Sekolah)</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100" style="max-width: max-content;">
        <a href="{{ route('absensi.create') }}" class="neo-btn neo-btn-primary flex-grow-1 text-center" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
            <i class="bi bi-plus-circle me-1"></i> Tambah Absensi
        </a>
    </div>
</div>


<!-- Filter -->
<div class="neo-card p-3 mb-4">
    <form method="GET" action="{{ route('absensi.index') }}" class="row m-0 g-2 align-items-center">
        @if(request('jenis'))
            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
        @endif
        
        <div class="col-12 col-md-4 col-lg-3">
            <input type="text" name="search" class="form-control neo-input w-100" placeholder="Cari nama santri..." value="{{ $search ?? '' }}">
        </div>
        
        <div class="col-12 col-md-4 col-lg-2">
            {{-- Custom Date Picker --}}
            <input type="hidden" name="tanggal" id="adminTanggalHidden" value="{{ $tanggal ?? '' }}">
            <div class="custom-datepicker-wrapper">
                <div class="custom-datepicker-trigger" id="adminDpTrigger" onclick="adminToggleDp()">
                    <i class="bi bi-calendar3 dp-cal-icon"></i>
                    <span class="dp-value {{ ($tanggal ?? '') ? '' : 'placeholder' }}" id="adminDpDisplay">
                        {{ ($tanggal ?? '') ? \Carbon\Carbon::parse($tanggal)->format('d/m/Y') : 'Pilih Tanggal...' }}
                    </span>
                    <i class="bi bi-chevron-down dp-arrow"></i>
                </div>
                <div class="custom-datepicker-popup" id="adminDpPopup">
                    <div class="dp-header">
                        <button type="button" class="dp-nav-btn" onclick="adminChangeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                        <span class="dp-month-year" id="adminDpMonthYear"></span>
                        <button type="button" class="dp-nav-btn" onclick="adminChangeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div class="dp-weekdays">
                        <div class="dp-weekday">Min</div><div class="dp-weekday">Sen</div>
                        <div class="dp-weekday">Sel</div><div class="dp-weekday">Rab</div>
                        <div class="dp-weekday">Kam</div><div class="dp-weekday">Jum</div>
                        <div class="dp-weekday">Sab</div>
                    </div>
                    <div class="dp-days" id="adminDpDays"></div>
                    <div class="dp-footer">
                        <button type="button" class="dp-today-btn" onclick="adminSelectToday()"><i class="bi bi-geo-alt-fill me-1"></i>Hari Ini</button>
                        <button type="button" class="dp-clear-btn" onclick="adminClearDate()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-4 col-lg-2">
            {{-- Dropdown Gender --}}
            <select name="jenis_kelamin" class="form-select neo-input w-100">
                <option value="">Semua Gender</option>
                <option value="Putra" {{ ($filterGender ?? '') === 'Putra' ? 'selected' : '' }}>Putra</option>
                <option value="Putri" {{ ($filterGender ?? '') === 'Putri' ? 'selected' : '' }}>Putri</option>
            </select>
        </div>
        
        <div class="col-12 col-md-4 col-lg-2">
            @if(request('jenis') == 'pengajian')
                {{-- Dropdown Ruang Pengajian --}}
                <select name="kelas" class="form-select neo-input w-100">
                    <option value="">Semua Ruang</option>
                    @foreach($ruangList as $ruang)
                        <option value="{{ $ruang }}" {{ ($kelasFilter ?? '') == $ruang ? 'selected' : '' }}>
                            {{ $ruang }}
                        </option>
                    @endforeach
                </select>
            @else
                {{-- Dropdown Kelas --}}
                <select name="kelas" class="form-select neo-input w-100">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->nama_kelas }}" {{ ($kelasFilter ?? '') == $kelas->nama_kelas ? 'selected' : '' }}>
                            {{ $kelas->jenjang }} - {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="col-12 col-md-8 col-lg-3">
            <div class="d-flex gap-2 w-100">
                {{-- Dropdown Mata Pelajaran --}}
                <select name="jenis_kegiatan" class="form-select neo-input flex-grow-1">
                    <option value="">Semua Mata Pelajaran</option>
                    @if(request('jenis') == 'pengajian')
                        <option value="Al-Quran"         {{ ($jenisKegiatan ?? '') == 'Al-Quran'         ? 'selected' : '' }}>📖 Al-Quran</option>
                        <option value="Fiqih"            {{ ($jenisKegiatan ?? '') == 'Fiqih'            ? 'selected' : '' }}>📖 Fiqih</option>
                        <option value="Tafsir"           {{ ($jenisKegiatan ?? '') == 'Tafsir'           ? 'selected' : '' }}>📖 Tafsir</option>
                        <option value="Hadits"           {{ ($jenisKegiatan ?? '') == 'Hadits'           ? 'selected' : '' }}>📖 Hadits</option>
                        <option value="Akhlak"           {{ ($jenisKegiatan ?? '') == 'Akhlak'           ? 'selected' : '' }}>📖 Akhlak</option>
                        <option value="Bahasa Arab"      {{ ($jenisKegiatan ?? '') == 'Bahasa Arab'      ? 'selected' : '' }}>📖 Bahasa Arab</option>
                    @elseif(request('jenis') == 'sekolah')
                        <option value="Matematika"       {{ ($jenisKegiatan ?? '') == 'Matematika'       ? 'selected' : '' }}>🎓 Matematika</option>
                        <option value="Bahasa Indonesia" {{ ($jenisKegiatan ?? '') == 'Bahasa Indonesia' ? 'selected' : '' }}>🎓 Bahasa Indonesia</option>
                        <option value="Bahasa Inggris"   {{ ($jenisKegiatan ?? '') == 'Bahasa Inggris'   ? 'selected' : '' }}>🎓 Bahasa Inggris</option>
                        <option value="IPA"              {{ ($jenisKegiatan ?? '') == 'IPA'              ? 'selected' : '' }}>🎓 IPA</option>
                        <option value="IPS"              {{ ($jenisKegiatan ?? '') == 'IPS'              ? 'selected' : '' }}>🎓 IPS</option>
                        <option value="PKn"              {{ ($jenisKegiatan ?? '') == 'PKn'              ? 'selected' : '' }}>🎓 PKn</option>
                    @else
                        <optgroup label="📖 Pengajian">
                            <option value="Al-Quran"         {{ ($jenisKegiatan ?? '') == 'Al-Quran'         ? 'selected' : '' }}>📖 Al-Quran</option>
                            <option value="Fiqih"            {{ ($jenisKegiatan ?? '') == 'Fiqih'            ? 'selected' : '' }}>📖 Fiqih</option>
                            <option value="Tafsir"           {{ ($jenisKegiatan ?? '') == 'Tafsir'           ? 'selected' : '' }}>📖 Tafsir</option>
                            <option value="Hadits"           {{ ($jenisKegiatan ?? '') == 'Hadits'           ? 'selected' : '' }}>📖 Hadits</option>
                            <option value="Akhlak"           {{ ($jenisKegiatan ?? '') == 'Akhlak'           ? 'selected' : '' }}>📖 Akhlak</option>
                            <option value="Bahasa Arab"      {{ ($jenisKegiatan ?? '') == 'Bahasa Arab'      ? 'selected' : '' }}>📖 Bahasa Arab</option>
                        </optgroup>
                        <optgroup label="🎓 Sekolah">
                            <option value="Matematika"       {{ ($jenisKegiatan ?? '') == 'Matematika'       ? 'selected' : '' }}>🎓 Matematika</option>
                            <option value="Bahasa Indonesia" {{ ($jenisKegiatan ?? '') == 'Bahasa Indonesia' ? 'selected' : '' }}>🎓 Bahasa Indonesia</option>
                            <option value="Bahasa Inggris"   {{ ($jenisKegiatan ?? '') == 'Bahasa Inggris'   ? 'selected' : '' }}>🎓 Bahasa Inggris</option>
                            <option value="IPA"              {{ ($jenisKegiatan ?? '') == 'IPA'              ? 'selected' : '' }}>🎓 IPA</option>
                            <option value="IPS"              {{ ($jenisKegiatan ?? '') == 'IPS'              ? 'selected' : '' }}>🎓 IPS</option>
                            <option value="PKn"              {{ ($jenisKegiatan ?? '') == 'PKn'              ? 'selected' : '' }}>🎓 PKn</option>
                        </optgroup>
                    @endif
                </select>
                <button type="submit" class="neo-btn neo-btn-primary px-3" style="height: 42px;">
                    <i class="bi bi-search"></i>
                </button>
                @if($search || $tanggal || $jenisKegiatan || ($kelasFilter ?? ''))
                    <a href="{{ route('absensi.index', request('jenis') ? ['jenis' => request('jenis')] : []) }}" class="neo-btn px-3 text-danger" style="height: 42px;" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Batch Delete Panel -->
<div class="neo-card p-3 mb-4" style="border-left: 4px solid var(--af-negative);">
    <form action="{{ route('absensi.batch-delete') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-center" onsubmit="return confirm('⚠️ PERHATIAN: Semua data absensi {{ request('jenis') ? ucfirst(request('jenis')) : '' }} pada bulan/tahun yang dipilih akan DIHAPUS PERMANEN. Lanjutkan?')">
        @csrf
        @if(request('jenis'))
            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
        @endif
        <i class="bi bi-trash3 text-danger me-1" style="font-size: 1.2rem;"></i>
        <span class="fw-bold small me-2" style="color: var(--af-negative);">Hapus Massal:</span>
        <select name="bulan" class="form-select neo-input" style="max-width: 140px;" required>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>
        <select name="tahun" class="form-select neo-input" style="max-width: 100px;" required>
            @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="neo-btn px-3" style="height: 42px; color: var(--af-negative);">
            <i class="bi bi-trash-fill me-1"></i> Hapus Semua
        </button>
    </form>
</div>

<!-- Notifikasi Error -->
@if($errors->has('duplicate'))
    <div class="alert bg-danger text-white rounded-3 mb-4 border-0">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('duplicate') }}
    </div>
@endif

<!-- Tabel Absensi -->
<div class="neo-card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="table table-borderless table-hover align-middle" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.25rem;">No</th>
                    <th style="padding: 1rem 1.25rem;">NIS</th>
                    <th style="padding: 1rem 1.25rem;">Nama Santri</th>
                    <th style="padding: 1rem 1.25rem;">L/P</th>
                    @if(request('jenis') == 'pengajian')
                        <th class="text-center" style="padding: 1rem 1.25rem;">Ruang Pengajian</th>
                    @else
                        <th class="text-center" style="padding: 1rem 1.25rem;">Kelas</th>
                    @endif
                    <th class="text-center" style="padding: 1rem 1.25rem;">Guru</th>
                    <th class="text-center" style="padding: 1rem 1.25rem;">Jenis Kegiatan</th>
                    <th class="text-center" style="padding: 1rem 1.25rem;">Tanggal</th>
                    <th class="text-center" style="padding: 1rem 1.25rem;">Status</th>
                    <th class="text-end" style="padding: 1rem 1.25rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $index => $absensi)
                <tr>
                    <td style="padding: 0.85rem 1.25rem;" class="fw-bold text-muted">{{ $absensis->firstItem() + $index }}</td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="text-muted">{{ $absensi->santri->nis ?? '-' }}</span>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="fw-bold" style="color: var(--af-positive);">{{ $absensi->santri->nama ?? '-' }}</span>
                        <br><small class="text-muted">{{ $absensi->santri->kamar ?? '' }}</small>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        @if(($absensi->santri->jenis_kelamin ?? '') == 'Putra')
                            <span class="badge" style="background:#EBF8FF;color:#2B6CB0;"><i class="bi bi-gender-male"></i> L</span>
                        @elseif(($absensi->santri->jenis_kelamin ?? '') == 'Putri')
                            <span class="badge" style="background:#FFF5F5;color:#C53030;"><i class="bi bi-gender-female"></i> P</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center" style="padding: 0.85rem 1.25rem;">
                        @if(request('jenis') == 'pengajian')
                            <span class="badge" style="background-color:var(--af-bg); color:var(--af-dark); box-shadow:var(--neo-shadow-inner);">{{ $absensi->santri->ruang_pengajian ?? '-' }}</span>
                        @else
                            <span class="badge" style="background-color:var(--af-bg); color:var(--af-dark); box-shadow:var(--neo-shadow-inner);">{{ $absensi->santri->kelas ?? '-' }}</span>
                        @endif
                    </td>
                    <td class="text-center" style="padding: 0.85rem 1.25rem;">
                        @if($absensi->user)
                            <span class="badge" style="background-color:var(--af-bg); color:var(--af-positive); box-shadow:var(--neo-shadow-inner);"><i class="bi bi-person-badge me-1"></i>{{ $absensi->user->name }}</span>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td class="text-center" style="padding: 0.85rem 1.25rem;">
                        @if(in_array($absensi->jenis_kegiatan, ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian']))
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(128,90,213,0.15); color: #805AD5; font-weight: 600;">
                                <i class="bi bi-book me-1"></i>{{ $absensi->jenis_kegiatan === 'Pengajian' ? 'Pengajian' : 'Pengajian (' . $absensi->jenis_kegiatan . ')' }}
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(221,107,32,0.15); color: #DD6B20; font-weight: 600;">
                                <i class="bi bi-mortarboard me-1"></i>{{ $absensi->jenis_kegiatan === 'Sekolah' ? 'Sekolah' : 'Sekolah (' . $absensi->jenis_kegiatan . ')' }}
                            </span>
                        @endif
                    </td>
                    <td class="text-center" style="padding: 0.85rem 1.25rem;">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="text-center" style="padding: 0.85rem 1.25rem;">
                        @if($absensi->status == 'Hadir')
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i>Hadir</span>
                        @elseif(in_array($absensi->status, ['Izin', 'Sakit']))
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge rounded-pill px-3 py-2" style="{{ $absensi->status == 'Sakit' ? 'background:#3182CE;color:white;' : 'background:#ffc107;color:#000;' }}">
                                    <i class="bi {{ $absensi->status == 'Sakit' ? 'bi-thermometer-half' : 'bi-envelope' }} me-1"></i>{{ $absensi->status }}
                                </span>
                                @if($absensi->keterangan || $absensi->bukti_izin)
                                    <button type="button" class="btn btn-sm p-0 {{ $absensi->status == 'Sakit' ? 'text-primary' : 'text-warning' }}" data-bs-toggle="modal" data-bs-target="#modalIzinTable_{{ $absensi->id }}" title="Lihat Keterangan">
                                        <i class="bi bi-info-circle-fill fs-5"></i>
                                    </button>
                                    
                                    <!-- Modal Keterangan Izin Table -->
                                    <div class="modal fade text-start" id="modalIzinTable_{{ $absensi->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold {{ $absensi->status == 'Sakit' ? 'text-primary' : 'text-warning' }}"><i class="bi {{ $absensi->status == 'Sakit' ? 'bi-thermometer-half' : 'bi-envelope-paper-fill' }} me-2"></i>Detail {{ $absensi->status }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center pt-2">
                                                    <div class="fw-bold" style="font-size: 1.1rem; color: var(--af-dark);">{{ $absensi->santri->nama ?? '-' }}</div>
                                                    <div class="text-muted small mb-3">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}</div>
                                                    
                                                    <div class="p-3 mb-3 text-start" style="background: rgba(214,158,46,0.1); border-radius: 12px;">
                                                        <div class="small fw-bold text-muted mb-1">Alasan:</div>
                                                        <div style="font-size: 0.9rem; color: var(--af-dark); text-wrap: wrap;">{{ $absensi->keterangan ?: 'Tidak ada keterangan.' }}</div>
                                                    </div>

                                                    @if($absensi->bukti_izin)
                                                        <div class="text-start">
                                                            <div class="small fw-bold text-muted mb-2">Bukti Lampiran:</div>
                                                            <a href="{{ asset('storage/' . $absensi->bukti_izin) }}" target="_blank" class="d-block overflow-hidden position-relative" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc;">
                                                                @if(Str::endsWith(strtolower($absensi->bukti_izin), ['.jpg', '.jpeg', '.png']))
                                                                    <img src="{{ asset('storage/' . $absensi->bukti_izin) }}" alt="Bukti" class="img-fluid w-100" style="object-fit: contain; max-height: 200px;">
                                                                    <div class="position-absolute top-50 start-50 translate-middle" style="background: rgba(0,0,0,0.5); color: white; padding: 6px 12px; border-radius: 50px; font-size: 0.8rem; opacity: 0; transition: 0.3s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">Buka Layar Penuh</div>
                                                                @else
                                                                    <div class="p-4 text-center">
                                                                        <i class="bi bi-file-earmark-pdf-fill text-danger mb-2 d-block" style="font-size: 2.5rem;"></i>
                                                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Lihat Dokumen PDF</div>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i>Alpa</span>
                        @endif
                    </td>
                    <td class="text-end" style="padding: 0.85rem 1.25rem;">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('absensi.edit', $absensi->id) }}" class="neo-btn px-2 py-1" style="font-size: 0.8rem;" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data absensi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="neo-btn px-2 py-1" style="font-size: 0.8rem; color: var(--af-negative);" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            Belum ada data absensi. 
                            <a href="{{ route('absensi.create') }}" class="text-decoration-none">Tambah data pertama →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($absensis->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3"
         style="border-top: 1px solid var(--neo-border, #dde4ed);">
        <div class="text-muted small">
            {{ $absensis->firstItem() }}–{{ $absensis->lastItem() }} dari
            <strong>{{ $absensis->total() }}</strong> data
        </div>
        <div class="d-flex gap-1">
            {{-- Prev --}}
            @if($absensis->onFirstPage())
                <span class="neo-btn px-3 py-1" style="opacity:.35;cursor:not-allowed;font-size:.85rem;">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $absensis->appends(request()->query())->previousPageUrl() }}"
                   class="neo-btn px-3 py-1" style="font-size:.85rem;">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Window 5 halaman --}}
            @foreach($absensis->appends(request()->query())->getUrlRange(
                max(1, $absensis->currentPage() - 2),
                min($absensis->lastPage(), $absensis->currentPage() + 2)
            ) as $page => $url)
                <a href="{{ $url }}"
                   class="neo-btn px-3 py-1 {{ $page == $absensis->currentPage() ? 'neo-btn-primary' : '' }}"
                   style="font-size:.85rem;min-width:36px;text-align:center;">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Next --}}
            @if($absensis->hasMorePages())
                <a href="{{ $absensis->appends(request()->query())->nextPageUrl() }}"
                   class="neo-btn px-3 py-1" style="font-size:.85rem;">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="neo-btn px-3 py-1" style="opacity:.35;cursor:not-allowed;font-size:.85rem;">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @elseif($absensis->count() > 0)
    <div class="px-4 py-3" style="border-top: 1px solid var(--neo-border, #dde4ed);">
        <span class="text-muted small">Total: <strong>{{ $absensis->total() }}</strong> data</span>
    </div>
    @endif

</div>
@endsection

@section('extra-scripts')
<script>
const MONTHS_ID_ADMIN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
let adminDpCurrent = new Date();
let adminDpSelected = null;

(function() {
    const v = document.getElementById('adminTanggalHidden').value;
    if (v) {
        const p = v.split('-');
        adminDpSelected = new Date(parseInt(p[0]), parseInt(p[1])-1, parseInt(p[2]));
        adminDpCurrent  = new Date(adminDpSelected);
    }
    adminRenderCalendar();
})();

function adminToggleDp() {
    const popup   = document.getElementById('adminDpPopup');
    const trigger = document.getElementById('adminDpTrigger');
    if (popup.classList.contains('show')) {
        popup.classList.remove('show'); trigger.classList.remove('active'); return;
    }
    adminRenderCalendar();
    const rect = trigger.getBoundingClientRect();
    const popupH = 360, popupW = 300, margin = 10;
    const spaceBelow = window.innerHeight - rect.bottom;
    const spaceAbove = rect.top;
    let top;
    if (spaceBelow >= popupH + margin)      top = rect.bottom + margin;
    else if (spaceAbove >= popupH + margin) top = rect.top - popupH - margin;
    else                                    top = Math.max(margin, (window.innerHeight - popupH) / 2);
    top = Math.max(margin, Math.min(top, window.innerHeight - popupH - margin));
    let left = rect.left;
    if (left + popupW > window.innerWidth - margin) left = window.innerWidth - popupW - margin;
    left = Math.max(margin, left);
    popup.style.top = top + 'px'; popup.style.left = left + 'px';
    popup.classList.add('show'); trigger.classList.add('active');
}
function adminCloseDp() {
    document.getElementById('adminDpPopup').classList.remove('show');
    document.getElementById('adminDpTrigger').classList.remove('active');
}
function adminChangeMonth(d) { adminDpCurrent.setMonth(adminDpCurrent.getMonth() + d); adminRenderCalendar(); }
function adminRenderCalendar() {
    const y = adminDpCurrent.getFullYear(), m = adminDpCurrent.getMonth();
    document.getElementById('adminDpMonthYear').textContent = MONTHS_ID_ADMIN[m] + ' ' + y;
    const firstDay = new Date(y, m, 1).getDay();
    const daysInMonth = new Date(y, m+1, 0).getDate();
    const daysInPrev  = new Date(y, m, 0).getDate();
    const today = new Date();
    let html = '';
    for (let i = firstDay-1; i >= 0; i--) {
        const d = daysInPrev - i;
        html += `<button type="button" class="dp-day dp-day-other-month" onclick="adminSelectDate(${y},${m-1<0?11:m-1},${d})">${d}</button>`;
    }
    for (let d = 1; d <= daysInMonth; d++) {
        const isToday    = d===today.getDate() && m===today.getMonth() && y===today.getFullYear();
        const isSelected = adminDpSelected && d===adminDpSelected.getDate() && m===adminDpSelected.getMonth() && y===adminDpSelected.getFullYear();
        let cls = 'dp-day';
        if (isToday)    cls += ' dp-day-today';
        if (isSelected) cls += ' dp-day-selected';
        html += `<button type="button" class="${cls}" onclick="adminSelectDate(${y},${m},${d})">${d}</button>`;
    }
    const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
    for (let d = 1; d <= totalCells - firstDay - daysInMonth; d++) {
        html += `<button type="button" class="dp-day dp-day-other-month" onclick="adminSelectDate(${y},${m+1>11?0:m+1},${d})">${d}</button>`;
    }
    document.getElementById('adminDpDays').innerHTML = html;
}
function adminSelectDate(y, m, d) {
    adminDpSelected = new Date(y, m, d); adminDpCurrent = new Date(y, m, d);
    const pad = n => String(n).padStart(2,'0');
    document.getElementById('adminTanggalHidden').value = `${y}-${pad(m+1)}-${pad(d)}`;
    const el = document.getElementById('adminDpDisplay');
    el.textContent = `${pad(d)}/${pad(m+1)}/${y}`;
    el.classList.remove('placeholder');
    adminRenderCalendar();
    setTimeout(adminCloseDp, 150);
}
function adminSelectToday() { const n=new Date(); adminSelectDate(n.getFullYear(),n.getMonth(),n.getDate()); }
function adminClearDate() {
    adminDpSelected = null;
    document.getElementById('adminTanggalHidden').value = '';
    const el = document.getElementById('adminDpDisplay');
    el.textContent = 'Pilih Tanggal...'; el.classList.add('placeholder');
    adminRenderCalendar();
}
document.addEventListener('click', function(e) {
    const w = document.querySelector('.custom-datepicker-wrapper');
    if (w && !w.contains(e.target)) adminCloseDp();
});
</script>
@endsection
