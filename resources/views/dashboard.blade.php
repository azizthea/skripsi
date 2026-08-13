@extends('layouts.app')

@section('extra-styles')
<style>
/* ===== CUSTOM MONTH-YEAR PICKER — Dashboard ===== */
.dash-filter-wrapper { position: relative; }
.dash-filter-trigger {
    display: flex; align-items: center; gap: 6px;
    padding: 0.35rem 0.9rem;
    background: transparent; border: none;
    cursor: pointer; font-family: inherit;
    font-weight: 700; font-size: 0.9rem;
    color: var(--fg); border-radius: 50px;
    transition: background 0.2s;
    white-space: nowrap;
}
.dash-filter-trigger:hover { background: var(--muted); }
.dash-filter-trigger .dash-arrow { font-size: 0.65rem; color: var(--muted-fg); transition: transform 0.2s; }
.dash-filter-trigger.active .dash-arrow { transform: rotate(180deg); }

.dash-filter-popup {
    position: fixed; z-index: 9999;
    background: white; border-radius: 1.25rem;
    border: 1px solid var(--border); min-width: 180px;
    box-shadow: 0 10px 40px -10px rgba(74,85,104,0.25);
    padding: 0.5rem; opacity: 0;
    transform: scale(0.97) translateY(-4px);
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.34, 1.4, 0.64, 1);
    max-height: 260px; overflow-y: auto;
}
.dash-filter-popup.show { opacity: 1; transform: scale(1) translateY(0); pointer-events: all; }
.dash-filter-option {
    display: block; width: 100%; text-align: left;
    padding: 0.45rem 1rem; border: none; background: transparent;
    border-radius: 50px; font-family: inherit; font-size: 0.85rem;
    font-weight: 600; color: var(--fg); cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.dash-filter-option:hover { background: var(--muted); }
.dash-filter-option.selected { background: var(--primary); color: white; }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     HEADER & FILTER
══════════════════════════════════════ --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1.5rem; margin-bottom:2rem;">
    <div>
        <p style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--muted-fg); margin-bottom:0.25rem;">
            Sistem Klasifikasi Kedisiplinan
        </p>
        <h1 style="font-family:'Fraunces',serif; font-weight:700; font-size:2rem; color:var(--fg); line-height:1.2; margin-bottom:0.25rem; display:flex; align-items:center; gap:10px;">
            <i class="bi bi-shield-check" style="color:var(--primary);"></i>
            @if(auth()->user()->role === 'pengurus') Dashboard Pengurus
            @elseif(auth()->user()->role === 'bk') Dashboard Guru BK
            @elseif(auth()->user()->role === 'guru') Dashboard Guru
            @else Dashboard Admin
            @endif
        </h1>
        <p style="color:var(--muted-fg); font-size:0.88rem;">
            Early Warning System
        </p>
    </div>

    {{-- Custom Month-Year Filter --}}
    <form action="{{ route('dashboard') }}" method="GET" id="dashFilterForm" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap; background:white; padding:0.4rem 0.5rem; border-radius:50px; box-shadow:var(--shadow-soft); border:1px solid var(--border);">
        <input type="hidden" name="bulan" id="dashBulanHidden" value="{{ str_pad($bulan,2,'0',STR_PAD_LEFT) }}">
        <input type="hidden" name="tahun" id="dashTahunHidden" value="{{ $tahun }}">

        {{-- Month Trigger --}}
        <div class="dash-filter-wrapper">
            <button type="button" class="dash-filter-trigger" id="dashMonthTrigger" onclick="dashToggle('month')">
                <span id="dashMonthDisplay">{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</span>
                <i class="bi bi-chevron-down dash-arrow"></i>
            </button>
            <div class="dash-filter-popup" id="dashMonthPopup">
                @php $months=['January','February','March','April','May','June','July','August','September','October','November','December']; @endphp
                @foreach($months as $idx => $name)
                    <button type="button" class="dash-filter-option {{ $bulan == $idx+1 ? 'selected' : '' }}"
                        onclick="dashSelectMonth({{ $idx+1 }}, '{{ $name }}')">{{ $name }}</button>
                @endforeach
            </div>
        </div>

        <div style="width:1px; height:20px; background:var(--border);"></div>

        {{-- Year Trigger --}}
        <div class="dash-filter-wrapper">
            <button type="button" class="dash-filter-trigger" id="dashYearTrigger" onclick="dashToggle('year')">
                <span id="dashYearDisplay">{{ $tahun }}</span>
                <i class="bi bi-chevron-down dash-arrow"></i>
            </button>
            <div class="dash-filter-popup" id="dashYearPopup">
                @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                    <button type="button" class="dash-filter-option {{ $tahun == $y ? 'selected' : '' }}"
                        onclick="dashSelectYear({{ $y }})">{{ $y }}</button>
                @endfor
            </div>
        </div>

        <button type="submit" class="org-btn org-btn-primary" style="padding:0.4rem 1.25rem;">
            Filter
        </button>
    </form>
</div>

{{-- ══════════════════════════════════════
     QUICK ACTIONS
══════════════════════════════════════ --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <a href="{{ route('evaluasi.index') }}" class="org-card" style="display:flex; align-items:center; gap:15px; padding:1.25rem; text-decoration:none; transition:all 0.3s ease; margin-bottom:0;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:48px; height:48px; border-radius:16px; background:rgba(193,140,93,0.15); color:#7A5230; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                <i class="bi bi-lightning-charge"></i>
            </div>
            <div>
                <div style="font-family:'Fraunces',serif; font-weight:700; font-size:1.1rem; color:var(--fg);">Proses Evaluasi</div>
                <div style="font-size:0.75rem; color:var(--muted-fg);">Jalankan sistem pakar (SP)</div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('santri.index') }}" class="org-card" style="display:flex; align-items:center; gap:15px; padding:1.25rem; text-decoration:none; transition:all 0.3s ease; margin-bottom:0;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:48px; height:48px; border-radius:16px; background:rgba(74,85,104,0.1); color:#4A5568; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div style="font-family:'Fraunces',serif; font-weight:700; font-size:1.1rem; color:var(--fg);">Data Santri</div>
                <div style="font-size:0.75rem; color:var(--muted-fg);">Kelola master santri aktif</div>
            </div>
        </a>
    </div>
</div>

{{-- ══════════════════════════════════════
     LIVE: ABSENSI HARI INI
══════════════════════════════════════ --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
    <h2 style="font-family:'Fraunces',serif; font-size:1.25rem; font-weight:700; color:var(--fg); margin:0; display:flex; align-items:center; gap:10px;">
        <span class="pulse-dot"></span>
        Live — Hari Ini
        <span style="font-family:'Nunito',sans-serif; font-size:0.8rem; font-weight:600; color:var(--muted-fg); margin-left:5px;">
            {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
        </span>
    </h2>
    <span id="refreshBadge" class="org-badge org-badge-primary"></span>
</div>

<div class="row g-3 mb-5">
    <div class="col-6 col-md">
        <div class="org-card" style="text-align:center; padding:1.5rem; margin-bottom:0;">
            <div style="width:56px; height:56px; border-radius:18px; background:rgba(74,85,104,0.1); color:#4A5568; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 10px;">
                <i class="bi bi-clipboard-data-fill"></i>
            </div>
            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Total Record</div>
            <div id="statTotal" style="font-family:'Fraunces',serif; font-size:2rem; font-weight:700; color:var(--fg); line-height:1;">{{ $totalAbsenHariIni }}</div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="org-card" style="text-align:center; padding:1.5rem; margin-bottom:0;">
            <div style="width:56px; height:56px; border-radius:18px; background:rgba(93,112,82,0.12); color:var(--positive); display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 10px;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Hadir</div>
            <div id="statHadir" style="font-family:'Fraunces',serif; font-size:2rem; font-weight:700; color:var(--positive); line-height:1;">{{ $hadirHariIni }}</div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="org-card" style="text-align:center; padding:1.5rem; margin-bottom:0;">
            <div style="width:56px; height:56px; border-radius:18px; background:rgba(193,140,93,0.15); color:#7A5230; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 10px;">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Izin</div>
            <div id="statIzin" style="font-family:'Fraunces',serif; font-size:2rem; font-weight:700; color:#7A5230; line-height:1;">{{ $izinHariIni }}</div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="org-card" style="text-align:center; padding:1.5rem; margin-bottom:0;">
            <div style="width:56px; height:56px; border-radius:18px; background:rgba(49,130,206,0.15); color:#3182CE; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 10px;">
                <i class="bi bi-thermometer-half"></i>
            </div>
            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Sakit</div>
            <div id="statSakit" style="font-family:'Fraunces',serif; font-size:2rem; font-weight:700; color:#3182CE; line-height:1;">{{ $sakitHariIni ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="org-card" style="text-align:center; padding:1.5rem; margin-bottom:0;">
            <div style="width:56px; height:56px; border-radius:18px; background:rgba(168,84,72,0.1); color:var(--negative); display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 10px;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Alpa</div>
            <div id="statAlpa" style="font-family:'Fraunces',serif; font-size:2rem; font-weight:700; color:var(--negative); line-height:1;">{{ $alpaHariIni }}</div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     SUMMARY BULANAN + LIVE FEED
══════════════════════════════════════ --}}
<div class="row g-4 mb-4">
    @if(auth()->user()->role === 'admin')
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="org-card h-100" style="margin-bottom:0; padding:1.5rem; border-radius:60% 40% 30% 70% / 60% 30% 70% 40%; border-radius:2rem;">
                    @php
                        $santriMTs = \App\Models\Santri::where('status','aktif')->where('jenjang','MTs')->count();
                        $santriMA  = \App\Models\Santri::where('status','aktif')->where('jenjang','MA')->count();
                    @endphp
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Total Santri Aktif</div>
                            <div style="font-family:'Fraunces',serif; font-size:2.5rem; font-weight:700; color:var(--fg); line-height:1;">{{ $totalSantri }}</div>
                        </div>
                        <div style="width:48px; height:48px; border-radius:50%; background:var(--primary); color:white; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <span class="org-badge" style="background:rgba(49,130,206,0.1); color:#3182CE;">MTs <strong>{{ $santriMTs }}</strong></span>
                        <span class="org-badge" style="background:rgba(107,70,193,0.1); color:#6B46C1;">MA <strong>{{ $santriMA }}</strong></span>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="org-card h-100" style="margin-bottom:0; padding:1.5rem; display:flex; flex-direction:column; justify-content:space-between;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Total Rekap ({{ $periodeTeks }})</div>
                            <div style="font-family:'Fraunces',serif; font-size:2.5rem; font-weight:700; color:var(--fg); line-height:1;">{{ $totalAbsensi }}</div>
                        </div>
                        <div style="width:48px; height:48px; border-radius:50%; background:rgba(74,85,104,0.1); color:#4A5568; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="org-card h-100" style="margin-bottom:0; padding:1.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                        <span style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px;">Rata-Rata Pengajian</span>
                        <i class="bi bi-book-fill" style="color:#805AD5; font-size:1.25rem;"></i>
                    </div>
                    <div style="font-family:'Fraunces',serif; font-size:2.2rem; font-weight:700; color:#805AD5; margin-bottom:10px; line-height:1;">{{ $avgPengajian }}%</div>
                    <div style="height:8px; border-radius:50px; background:var(--muted); overflow:hidden;">
                        <div style="height:100%; width:{{ $avgPengajian }}%; background:linear-gradient(90deg,#805AD5,#553C9A); border-radius:50px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="org-card h-100" style="margin-bottom:0; padding:1.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                        <span style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px;">Rata-Rata Sekolah</span>
                        <i class="bi bi-mortarboard-fill" style="color:#DD6B20; font-size:1.25rem;"></i>
                    </div>
                    <div style="font-family:'Fraunces',serif; font-size:2.2rem; font-weight:700; color:#DD6B20; margin-bottom:10px; line-height:1;">{{ $avgSekolah }}%</div>
                    <div style="height:8px; border-radius:50px; background:var(--muted); overflow:hidden;">
                        <div style="height:100%; width:{{ $avgSekolah }}%; background:linear-gradient(90deg,#DD6B20,#9C4221); border-radius:50px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Live Feed --}}
    <div class="{{ auth()->user()->role === 'admin' ? 'col-md-4' : 'col-md-12' }}">
        <div class="org-card h-100" style="margin-bottom:0; padding:0; display:flex; flex-direction:column;">
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:rgba(93,112,82,0.03);">
                <h3 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); margin:0; display:flex; align-items:center; gap:8px;">
                    <span class="pulse-dot"></span>
                    Aktivitas Guru
                </h3>
                <span style="font-size:0.7rem; color:var(--muted-fg);">Auto-refresh</span>
            </div>
            <div id="liveFeedContainer" style="flex:1; overflow-y:auto; max-height:400px;">
                @forelse($liveFeed as $item)
                @php
                    $isHadir = $item->status === 'Hadir';
                    $isIzin  = $item->status === 'Izin';
                    $avBg  = $isHadir ? 'rgba(93,112,82,0.15)'  : ($isIzin ? 'rgba(193,140,93,0.15)' : 'rgba(168,84,72,0.12)');
                    $avClr = $isHadir ? 'var(--positive)'       : ($isIzin ? '#7A5230'               : 'var(--negative)');
                @endphp
                <div class="feed-item" style="display:flex; align-items:center; gap:12px; padding:0.75rem 1.5rem; border-bottom:1px solid rgba(222,216,207,0.4); transition:background 0.2s;">
                    <div style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; flex-shrink:0; background:{{ $avBg }}; color:{{ $avClr }};">
                        {{ substr($item->santri->nama ?? 'S', 0, 1) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-weight:700; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--fg);">{{ $item->santri->nama ?? '-' }}</div>
                        <div style="font-size:0.72rem; color:var(--muted-fg);">{{ $item->jenis_kegiatan }} &middot; {{ $item->santri->kelas ?? '' }} &middot; {{ \Carbon\Carbon::parse($item->tanggal)->format('d M') }}</div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="org-badge" style="background:{{ $avBg }}; color:{{ $avClr }};">
                            {{ $item->status }}
                        </span>
                        @if($item->status == 'Izin' && ($item->keterangan || $item->bukti_izin))
                            <button type="button" class="btn btn-sm p-0" style="color:#C18C5D;" data-bs-toggle="modal" data-bs-target="#modalIzinAdmin_{{ $item->id }}">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                            </button>
                            
                            {{-- Modal Keterangan Admin --}}
                            <div class="modal fade" id="modalIzinAdmin_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content" style="border-radius:1.5rem; border:1px solid var(--border); box-shadow:var(--shadow-float); background:var(--bg); overflow:hidden;">
                                        <div style="padding:1.25rem 1.5rem 0.75rem; background:rgba(193,140,93,0.06); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
                                            <h6 style="font-family:'Fraunces',serif; font-weight:700; color:var(--fg); margin:0; display:flex; align-items:center; gap:8px;">
                                                <i class="bi bi-envelope-paper-fill" style="color:#C18C5D;"></i> Detail Izin
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div style="padding:1.25rem 1.5rem; text-align:center;">
                                            <div style="font-family:'Fraunces',serif; font-weight:700; font-size:1.05rem; margin-bottom:2px; color:var(--fg);">{{ $item->santri->nama ?? '-' }}</div>
                                            <div style="font-size:0.75rem; color:var(--muted-fg); margin-bottom:1rem;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                                            
                                            <div style="background:rgba(193,140,93,0.08); border-radius:14px; padding:0.9rem 1rem; text-align:left; margin-bottom:0.75rem;">
                                                <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Alasan</div>
                                                <div style="font-size:0.88rem; color:var(--fg);">{{ $item->keterangan ?: 'Tidak ada keterangan.' }}</div>
                                            </div>

                                            @if($item->bukti_izin)
                                                <div style="text-align:left;">
                                                    <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">Bukti Lampiran</div>
                                                    <a href="{{ asset('storage/' . $item->bukti_izin) }}" target="_blank" style="display:block; border-radius:14px; border:1px solid var(--border); overflow:hidden; background:var(--muted);">
                                                        @if(Str::endsWith(strtolower($item->bukti_izin), ['.jpg', '.jpeg', '.png']))
                                                            <img src="{{ asset('storage/' . $item->bukti_izin) }}" alt="Bukti" style="width:100%; max-height:200px; object-fit:contain;">
                                                        @else
                                                            <div style="padding:1.5rem; text-align:center;">
                                                                <i class="bi bi-file-earmark-pdf-fill" style="font-size:2.5rem; color:var(--negative); display:block; margin-bottom:6px;"></i>
                                                                <div style="font-size:0.82rem; font-weight:700; color:var(--fg);">Lihat Dokumen PDF</div>
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
                </div>
                @empty
                <div style="text-align:center; padding:3rem 1.5rem; color:var(--muted-fg);">
                    <i class="bi bi-inbox" style="font-size:2.5rem; opacity:0.2; display:block; margin-bottom:0.5rem;"></i>
                    <small>Belum ada absensi</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'admin')
{{-- ══════════════════════════════════════
     CHARTS
══════════════════════════════════════ --}}
<div class="row g-4 mb-4">
    <div class="col-md-5">
        <div class="org-card h-100" style="margin-bottom:0;">
            <h3 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); margin-bottom:4px; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-pie-chart-fill" style="color:var(--primary);"></i>
                Distribusi Disiplin
            </h3>
            <p style="font-size:0.75rem; color:var(--muted-fg); margin-bottom:1.5rem;">{{ $periodeTeks }}</p>
            
            @if(array_sum($distribusi) > 0)
            <div style="height:260px; display:flex; align-items:center; justify-content:center;">
                <canvas id="pieChart"></canvas>
            </div>
            <div style="display:flex; justify-content:center; gap:1.5rem; margin-top:1.5rem;">
                @foreach(['Tinggi'=>'#5D7052','Sedang'=>'#C18C5D','Rendah'=>'#A85448'] as $kat=>$clr)
                <div style="text-align:center; cursor:pointer;" onclick="showKategori('{{ $kat }}')">
                    <span class="org-badge" style="background:{{ $clr }}; color:white; padding:0.4rem 1rem; font-size:0.85rem;">{{ $distribusi[$kat] }}</span>
                    <div style="font-size:0.75rem; color:var(--muted-fg); margin-top:6px; font-weight:600;">{{ $kat }}</div>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align:center; padding:3rem 1.5rem; color:var(--muted-fg);">
                <i class="bi bi-pie-chart" style="font-size:3rem; opacity:0.2; display:block; margin-bottom:0.5rem;"></i>
                <p style="font-size:0.85rem; margin-bottom:1rem;">Belum ada data evaluasi.</p>
                <a href="{{ route('evaluasi.index') }}" class="org-btn org-btn-primary" style="padding:0.4rem 1.25rem;">Proses Evaluasi</a>
            </div>
            @endif
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="org-card h-100" style="margin-bottom:0;">
            <h3 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); margin-bottom:4px; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-bar-chart-line-fill" style="color:#C18C5D;"></i>
                Kehadiran per Kelas
            </h3>
            <p style="font-size:0.75rem; color:var(--muted-fg); margin-bottom:1.5rem;">Pengajian vs Sekolah (%)</p>
            
            @if(count($kelasLabels) > 0)
            <div style="height:280px;">
                <canvas id="barChart"></canvas>
            </div>
            @else
            <div style="text-align:center; padding:4rem 1.5rem; color:var(--muted-fg);">
                <i class="bi bi-bar-chart" style="font-size:3rem; opacity:0.2; display:block; margin-bottom:0.5rem;"></i>
                <p style="font-size:0.85rem;">Data belum tersedia.</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     FORWARD CHAINING RULES
══════════════════════════════════════ --}}
<div class="org-card">
    <h3 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); margin-bottom:1.25rem; display:flex; align-items:center; gap:8px;">
        <i class="bi bi-info-circle-fill" style="color:#4A5568;"></i>
        Kriteria & Syarat Klasifikasi Kedisiplinan
    </h3>
    <div class="row g-3">
        @foreach([
            ['Syarat Utama','Tinggi','var(--positive)','rgba(93,112,82,0.05)','Kehadiran Pengajian ≥ 85% DAN Sekolah ≥ 85%'],
            ['Syarat Menengah','Sedang','#C18C5D','rgba(193,140,93,0.05)','Kehadiran Pengajian 60-84% ATAU Sekolah 60-84%'],
            ['Syarat Kritis','Rendah','var(--negative)','rgba(168,84,72,0.05)','Kehadiran Pengajian < 60% DAN Sekolah < 60%']
        ] as [$r,$kat,$clr,$bg,$crit])
        <div class="col-md-4">
            <div style="background:{{ $bg }}; border:1px solid var(--border); border-radius:1rem; padding:1.25rem; border-left:4px solid {{ $clr }}; height:100%;">
                <h6 style="font-family:'Fraunces',serif; font-weight:700; color:{{ $clr }}; margin-bottom:8px; font-size:1rem;">Kategori Disiplin {{ $kat }}</h6>
                <p style="font-size:0.8rem; color:var(--fg); margin-bottom:0; line-height:1.5;">
                    <span style="color:var(--muted-fg);">{{ $crit }}</span><br>
                    Maka sistem menetapkan status: <strong>{{ $kat }}</strong>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Modals and Scripts --}}
<div class="modal fade" id="modalKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:2rem; border:1px solid var(--border); box-shadow:var(--shadow-float); background:var(--bg); overflow:hidden;">
            <div class="modal-header border-0" id="modalKategoriHeader" style="padding:1.5rem 2rem 1rem;">
                <div>
                    <h5 class="modal-title" id="modalKategoriTitle" style="font-family:'Fraunces',serif; font-weight:700; font-size:1.5rem; color:var(--fg);">Daftar Santri</h5>
                    <p style="font-size:0.8rem; color:var(--muted-fg); margin-bottom:0;">Periode: {{ $periodeTeks }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalKategoriBody" style="padding:0 2rem 1.5rem;"></div>
            <div class="modal-footer border-0" style="padding:1rem 2rem 1.5rem;">
                <button type="button" class="org-btn org-btn-ghost" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    const pieCtx = document.getElementById('pieChart');
    if (pieCtx) {
        new Chart(pieCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Tinggi','Sedang','Rendah'],
                datasets: [{ 
                    data: [{{ $distribusi['Tinggi'] ?? 0 }},{{ $distribusi['Sedang'] ?? 0 }},{{ $distribusi['Rendah'] ?? 0 }}], 
                    backgroundColor: ['#5D7052','#C18C5D','#A85448'], 
                    borderWidth: 2, borderColor: '#FDFCF8', hoverOffset: 8 
                }]
            },
            options: { 
                responsive: true, maintainAspectRatio: false, cutout: '70%', 
                plugins: { legend: { display: false } } 
            }
        });
    }

    // Bar Chart
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        new Chart(barCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($kelasLabels ?? []) !!},
                datasets: [
                    { label: 'Pengajian', data: {!! json_encode($kelasPengajianData ?? []) !!}, backgroundColor: 'rgba(128,90,213,0.7)', borderColor: '#805AD5', borderWidth: 1, borderRadius: {topLeft:6, topRight:6} },
                    { label: 'Sekolah',   data: {!! json_encode($kelasSekolahData ?? []) !!},   backgroundColor: 'rgba(221,107,32,0.7)',  borderColor: '#DD6B20', borderWidth: 1, borderRadius: {topLeft:6, topRight:6} }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: { 
                    y: { beginAtZero: true, max: 100, border:{display:false}, grid:{color:'rgba(222,216,207,0.4)'}, ticks: { callback: v => v+'%', font: { family: 'Nunito', size:11 }, color:'#78786C' } }, 
                    x: { border:{display:false}, grid:{display:false}, ticks: { font: { family: 'Nunito', weight: '600' }, color:'#2C2C24' } } 
                },
                plugins: { legend: { labels: { usePointStyle: true, font: { family: 'Nunito', size: 12 }, color:'#78786C' } } }
            }
        });
    }

    // Auto-refresh Live Feed
    function refreshLiveFeed() {
        fetch('{{ route("dashboard.live-feed") }}')
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('liveFeedContainer');
                if (!container) return;

                if (data.length === 0) {
                    container.innerHTML = '<div style="text-align:center; padding:3rem 1.5rem; color:var(--muted-fg);"><i class="bi bi-inbox" style="font-size:2.5rem; opacity:0.2; display:block; margin-bottom:0.5rem;"></i><small>Belum ada absensi</small></div>';
                    return;
                }

                const clrMap = { 
                    'Hadir': { bg: 'rgba(93,112,82,0.15)', txt: 'var(--positive)' }, 
                    'Izin': { bg: 'rgba(193,140,93,0.15)', txt: '#7A5230' }, 
                    'Sakit': { bg: 'rgba(49,130,206,0.15)', txt: '#3182CE' }, 
                    'Alpa': { bg: 'rgba(168,84,72,0.12)', txt: 'var(--negative)' } 
                };
                
                container.innerHTML = data.map(item => {
                    const c = clrMap[item.status] || clrMap['Alpa'];
                    return `<div class="feed-item" style="display:flex; align-items:center; gap:12px; padding:0.75rem 1.5rem; border-bottom:1px solid rgba(222,216,207,0.4); transition:background 0.2s;">
                        <div style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; flex-shrink:0; background:${c.bg}; color:${c.txt};">
                            ${item.santri.charAt(0)}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:700; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--fg);">${item.santri}</div>
                            <div style="font-size:0.72rem; color:var(--muted-fg);">${item.jenis} · ${item.kelas} · ${item.tanggal}</div>
                        </div>
                        <span class="org-badge" style="background:${c.bg}; color:${c.txt};">${item.status}</span>
                    </div>`;
                }).join('');

                const badge = document.getElementById('refreshBadge');
                if (badge) { badge.textContent = '⟳ ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'}); }
            })
            .catch(() => {});
    }

    setTimeout(refreshLiveFeed, 5000);
    setInterval(refreshLiveFeed, 30000);
});

// Kategori Modal
const santriData = { 
    'Tinggi': @json($santriPerKategori['Tinggi']->values() ?? []), 
    'Sedang': @json($santriPerKategori['Sedang']->values() ?? []), 
    'Rendah': @json($santriPerKategori['Rendah']->values() ?? []) 
};
const warnaKat = { 'Tinggi':'#5D7052', 'Sedang':'#C18C5D', 'Rendah':'#A85448' };
const bgKat = { 'Tinggi':'rgba(93,112,82,0.05)', 'Sedang':'rgba(193,140,93,0.05)', 'Rendah':'rgba(168,84,72,0.05)' };

function showKategori(kategori) {
    const list = santriData[kategori] || [];
    const clr  = warnaKat[kategori];
    const bg   = bgKat[kategori];
    
    document.getElementById('modalKategoriHeader').style.background = bg;
    document.getElementById('modalKategoriTitle').innerHTML = `Kategori <span style="color:${clr}">${kategori}</span>`;
    
    const body = document.getElementById('modalKategoriBody');
    if (!list.length) { 
        body.innerHTML = `<div style="text-align:center; padding:4rem 2rem; color:var(--muted-fg);"><i class="bi bi-inbox" style="font-size:3rem; opacity:0.2; display:block; margin-bottom:1rem;"></i><p>Tidak ada santri.</p></div>`; 
    } else {
        body.innerHTML = `<div style="margin:1rem 0;"><span class="org-badge" style="background:${clr}; color:white; padding:0.4rem 1rem;">${list.length} Santri</span></div>
        <div style="border:1px solid var(--border); border-radius:1rem; overflow:hidden;">
            <table class="org-table">
                <thead style="background:${bg};"><tr><th>#</th><th>Nama</th><th>Kelas</th><th>Kamar</th></tr></thead>
                <tbody>${list.map((s,i)=>`<tr>
                    <td style="color:var(--muted-fg);">${i+1}</td>
                    <td style="font-weight:700;">${s.nama}</td>
                    <td><span class="org-badge org-badge-muted">${s.kelas}</span></td>
                    <td style="color:var(--muted-fg);">${s.kamar||'-'}</td>
                </tr>`).join('')}</tbody>
            </table>
        </div>`;
    }
    new bootstrap.Modal(document.getElementById('modalKategori')).show();
}

// ===== CUSTOM MONTH-YEAR PICKER =====
function dashToggle(type) {
    const monthPopup = document.getElementById('dashMonthPopup');
    const yearPopup  = document.getElementById('dashYearPopup');
    const monthTrig  = document.getElementById('dashMonthTrigger');
    const yearTrig   = document.getElementById('dashYearTrigger');

    // Close the other one
    if (type === 'month') {
        yearPopup.classList.remove('show'); yearTrig.classList.remove('active');
    } else {
        monthPopup.classList.remove('show'); monthTrig.classList.remove('active');
    }

    const popup   = type === 'month' ? monthPopup  : yearPopup;
    const trigger = type === 'month' ? monthTrig   : yearTrig;

    if (popup.classList.contains('show')) {
        popup.classList.remove('show'); trigger.classList.remove('active'); return;
    }

    // Smart positioning
    const rect = trigger.getBoundingClientRect();
    const popH = 260, popW = 190, margin = 10;
    const spaceBelow = window.innerHeight - rect.bottom;
    let top = spaceBelow >= popH + margin ? rect.bottom + margin : Math.max(margin, rect.top - popH - margin);
    top = Math.max(margin, Math.min(top, window.innerHeight - popH - margin));
    let left = rect.left;
    if (left + popW > window.innerWidth - margin) left = window.innerWidth - popW - margin;
    left = Math.max(margin, left);
    popup.style.top = top + 'px'; popup.style.left = left + 'px';
    popup.classList.add('show'); trigger.classList.add('active');
}

function dashSelectMonth(num, name) {
    document.getElementById('dashBulanHidden').value = String(num).padStart(2,'0');
    document.getElementById('dashMonthDisplay').textContent = name;
    document.querySelectorAll('#dashMonthPopup .dash-filter-option').forEach(b => b.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('dashMonthPopup').classList.remove('show');
    document.getElementById('dashMonthTrigger').classList.remove('active');
}

function dashSelectYear(y) {
    document.getElementById('dashTahunHidden').value = y;
    document.getElementById('dashYearDisplay').textContent = y;
    document.querySelectorAll('#dashYearPopup .dash-filter-option').forEach(b => b.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('dashYearPopup').classList.remove('show');
    document.getElementById('dashYearTrigger').classList.remove('active');
}

document.addEventListener('click', function(e) {
    ['Month','Year'].forEach(t => {
        const popup = document.getElementById('dash'+t+'Popup');
        const trig  = document.getElementById('dash'+t+'Trigger');
        if (popup && trig && !trig.contains(e.target) && !popup.contains(e.target)) {
            popup.classList.remove('show'); trig.classList.remove('active');
        }
    });
});
</script>
@endsection
