@extends('layouts.guru')

@section('content')
<div style="max-width: 1100px;">

    {{-- ══════════════════════════════════════
         HEADER
    ══════════════════════════════════════ --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem; margin-bottom:2rem;">
        <div>
            <p style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--muted-fg); margin-bottom:0.25rem;">
                Portal Absensi Digital
            </p>
            <h1 style="font-family:'Fraunces',serif; font-weight:700; font-size:2rem; color:var(--fg); line-height:1.2; margin-bottom:0.25rem;">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p style="color:var(--muted-fg); font-size:0.88rem;">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        {{-- Date badge --}}
        <div style="background:var(--primary); color:white; border-radius:50px; padding:0.6rem 1.25rem; display:flex; align-items:center; gap:8px; font-size:0.85rem; font-weight:700; box-shadow:var(--shadow-soft); align-self:flex-start;">
            <i class="bi bi-calendar3"></i>
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- ══════════════════════════════════════
         KARTU ABSENSI HARI INI
    ══════════════════════════════════════ --}}
    <div style="margin-bottom:0.75rem;">
        <h2 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); display:flex; align-items:center; gap:8px; margin-bottom:1.25rem;">
            <i class="bi bi-lightning-charge-fill" style="color:var(--primary);"></i>
            Absensi Hari Ini
        </h2>
    </div>
    <div class="row g-3 mb-4">
        {{-- Pengajian --}}
        <div class="col-md-6">
            <a href="{{ route('guru.input-absensi', ['jenis_kegiatan'=>'Al-Quran', 'tanggal'=>$today]) }}"
               class="org-action-card">
                <div class="org-action-icon" style="background:rgba(128,90,213,0.1); color:#805AD5;">
                    <i class="bi bi-book-fill"></i>
                </div>
                <div style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; margin-bottom:0.3rem;">
                    Absen Pengajian
                </div>
                <div style="font-size:0.8rem; color:var(--muted-fg); margin-bottom:0.5rem;">Al-Quran · Fiqih · Tafsir · dll</div>
                @if($sudahAbsenPengajian)
                    <div class="pill-done">
                        <i class="bi bi-check-circle-fill"></i> Sudah diisi hari ini
                    </div>
                @else
                    <div class="pill-todo">
                        <i class="bi bi-clock-fill"></i> Belum diisi
                    </div>
                @endif
            </a>
        </div>
        {{-- Sekolah --}}
        <div class="col-md-6">
            <a href="{{ route('guru.input-absensi', ['jenis_kegiatan'=>'Matematika', 'tanggal'=>$today]) }}"
               class="org-action-card">
                <div class="org-action-icon" style="background:rgba(221,107,32,0.1); color:#DD6B20;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; margin-bottom:0.3rem;">
                    Absen Sekolah
                </div>
                <div style="font-size:0.8rem; color:var(--muted-fg); margin-bottom:0.5rem;">Matematika · B.Indonesia · IPA · dll</div>
                @if($sudahAbsenSekolah)
                    <div class="pill-done">
                        <i class="bi bi-check-circle-fill"></i> Sudah diisi hari ini
                    </div>
                @else
                    <div class="pill-todo">
                        <i class="bi bi-clock-fill"></i> Belum diisi
                    </div>
                @endif
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         STATISTIK HARI INI
    ══════════════════════════════════════ --}}
    <h2 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); display:flex; align-items:center; gap:8px; margin-bottom:1.25rem;">
        <i class="bi bi-bar-chart-fill" style="color:var(--primary);"></i>
        Rekap Hari Ini
    </h2>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md">
            <div class="org-stat-card">
                <div class="org-stat-icon" style="background:rgba(74,85,104,0.1); color:var(--primary);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div style="font-size:0.72rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:0.5px;">Total</div>
                    <div style="font-family:'Fraunces',serif; font-size:1.8rem; font-weight:700; color:var(--primary); line-height:1.1;">{{ $totalSantri }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="org-stat-card">
                <div class="org-stat-icon" style="background:rgba(93,112,82,0.12); color:var(--positive);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div style="font-size:0.72rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:0.5px;">Hadir</div>
                    <div style="font-family:'Fraunces',serif; font-size:1.8rem; font-weight:700; color:var(--positive); line-height:1.1;">{{ $hadirHariIni }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="org-stat-card">
                <div class="org-stat-icon" style="background:rgba(193,140,93,0.12); color:#7A5230;">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div>
                    <div style="font-size:0.72rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:0.5px;">Izin</div>
                    <div style="font-family:'Fraunces',serif; font-size:1.8rem; font-weight:700; color:#7A5230; line-height:1.1;">{{ $izinHariIni }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="org-stat-card">
                <div class="org-stat-icon" style="background:rgba(49,130,206,0.15); color:#3182CE;">
                    <i class="bi bi-thermometer-half"></i>
                </div>
                <div>
                    <div style="font-size:0.72rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:0.5px;">Sakit</div>
                    <div style="font-family:'Fraunces',serif; font-size:1.8rem; font-weight:700; color:#3182CE; line-height:1.1;">{{ $sakitHariIni ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="org-stat-card">
                <div class="org-stat-icon" style="background:rgba(168,84,72,0.1); color:var(--negative);">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div>
                    <div style="font-size:0.72rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:0.5px;">Alpa</div>
                    <div style="font-family:'Fraunces',serif; font-size:1.8rem; font-weight:700; color:var(--negative); line-height:1.1;">{{ $alpaHariIni }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BARIS BAWAH: Progres + Riwayat
    ══════════════════════════════════════ --}}
    @php
        $totalAbsen = $hadirHariIni + $izinHariIni + $sakitHariIni + $alpaHariIni;
        $pctHadir   = $totalAbsen > 0 ? round(($hadirHariIni / $totalAbsen) * 100) : 0;
        $pctIzin    = $totalAbsen > 0 ? round(($izinHariIni  / $totalAbsen) * 100) : 0;
        $pctSakit   = $totalAbsen > 0 ? round(($sakitHariIni / $totalAbsen) * 100) : 0;
        $pctAlpa    = $totalAbsen > 0 ? round(($alpaHariIni  / $totalAbsen) * 100) : 0;
    @endphp

    <div class="row g-4">

        {{-- Progres Kehadiran --}}
        <div class="col-md-5">
            <div class="org-card h-100">
                <div class="org-card-pad">
                    <h2 style="font-family:'Fraunces',serif; font-size:1rem; font-weight:700; color:var(--fg); margin-bottom:4px; display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-pie-chart-fill" style="color:var(--primary);"></i>
                        Persentase Kehadiran
                    </h2>
                    <p style="font-size:0.75rem; color:var(--muted-fg); margin-bottom:1.5rem;">
                        Dari {{ $totalSantri }} santri yang diabsen hari ini
                    </p>

                    @if($totalAbsen === 0)
                        <div style="text-align:center; padding:2rem 0; color:var(--muted-fg);">
                            <i class="bi bi-clipboard-x" style="font-size:3rem; opacity:0.2; display:block; margin-bottom:0.75rem;"></i>
                            <p style="font-size:0.85rem;">Belum ada absensi hari ini.<br>Gunakan kartu di atas untuk mulai.</p>
                        </div>
                    @else
                        <div style="margin-bottom:1.25rem;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span style="font-size:0.82rem; font-weight:700; display:flex; align-items:center; gap:5px;">
                                    <i class="bi bi-check-circle-fill" style="color:var(--positive);"></i> Hadir
                                </span>
                                <span style="font-size:0.82rem; font-weight:700; color:var(--positive);">{{ $pctHadir }}%</span>
                            </div>
                            <div class="org-progress">
                                <div class="org-progress-fill" style="width:{{ $pctHadir }}%; background:linear-gradient(90deg,var(--positive),#4a5e42);"></div>
                            </div>
                        </div>
                        <div style="margin-bottom:1.25rem;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span style="font-size:0.82rem; font-weight:700; display:flex; align-items:center; gap:5px;">
                                    <i class="bi bi-envelope-fill" style="color:#7A5230;"></i> Izin
                                </span>
                                <span style="font-size:0.82rem; font-weight:700; color:#7A5230;">{{ $pctIzin }}%</span>
                            </div>
                            <div class="org-progress">
                                <div class="org-progress-fill" style="width:{{ $pctIzin }}%; background:linear-gradient(90deg,#C18C5D,#8B6035);"></div>
                            </div>
                        </div>
                        <div style="margin-bottom:1.25rem;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span style="font-size:0.82rem; font-weight:700; display:flex; align-items:center; gap:5px;">
                                    <i class="bi bi-thermometer-half" style="color:#3182CE;"></i> Sakit
                                </span>
                                <span style="font-size:0.82rem; font-weight:700; color:#3182CE;">{{ $pctSakit }}%</span>
                            </div>
                            <div class="org-progress">
                                <div class="org-progress-fill" style="width:{{ $pctSakit }}%; background:linear-gradient(90deg,#3182CE,#2B6CB0);"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span style="font-size:0.82rem; font-weight:700; display:flex; align-items:center; gap:5px;">
                                    <i class="bi bi-x-circle-fill" style="color:var(--negative);"></i> Alpa
                                </span>
                                <span style="font-size:0.82rem; font-weight:700; color:var(--negative);">{{ $pctAlpa }}%</span>
                            </div>
                            <div class="org-progress">
                                <div class="org-progress-fill" style="width:{{ $pctAlpa }}%; background:linear-gradient(90deg,var(--negative),#8B3D31);"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Riwayat Absensi Terakhir --}}
        <div class="col-md-7">
            <div class="org-card h-100">
                {{-- Header feed --}}
                <div style="padding:1.25rem 1.5rem; border-bottom:1px solid rgba(222,216,207,0.5); display:flex; align-items:center; gap:10px;">
                    <h2 style="font-family:'Fraunces',serif; font-size:1rem; font-weight:700; color:var(--fg); margin:0; display:flex; align-items:center; gap:8px;">
                        <span class="pulse-dot"></span>
                        Absensi Terakhir Diinput
                    </h2>
                    <span style="margin-left:auto; font-size:0.72rem; color:var(--muted-fg);">Data terbaru semua guru</span>
                </div>

                {{-- Feed items --}}
                <div style="max-height:340px; overflow-y:auto;">
                    @forelse($riwayat as $item)
                    @php
                        $isHadir = $item->status === 'Hadir';
                        $isIzin  = $item->status === 'Izin';
                        $isSakit = $item->status === 'Sakit';
                        $avBg  = $isHadir ? 'rgba(93,112,82,0.15)'  : ($isIzin ? 'rgba(193,140,93,0.15)' : ($isSakit ? 'rgba(49,130,206,0.15)' : 'rgba(168,84,72,0.12)'));
                        $avClr = $isHadir ? 'var(--positive)'       : ($isIzin ? '#7A5230'               : ($isSakit ? '#3182CE' : 'var(--negative)'));
                    @endphp
                    <div class="org-feed-item">
                        <div class="org-feed-avatar" style="background:{{ $avBg }}; color:{{ $avClr }};">
                            {{ substr($item->santri->nama ?? 'S', 0, 1) }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:700; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $item->santri->nama ?? '-' }}
                            </div>
                            <div style="font-size:0.72rem; color:var(--muted-fg);">
                                {{ $item->jenis_kegiatan }} &middot; {{ $item->santri->kelas ?? '' }} &middot; {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="{{ $isHadir ? 'pill-hadir' : ($isIzin ? 'pill-izin' : ($isSakit ? 'pill-sakit' : 'pill-alpa')) }}" style="{{ $isSakit ? 'background:rgba(49,130,206,0.15); color:#3182CE;' : '' }}">
                                {{ $item->status }}
                            </span>

                            @if(in_array($item->status, ['Izin', 'Sakit']) && ($item->keterangan || $item->bukti_izin))
                                <button type="button" class="btn btn-sm p-0"
                                        style="color:#C18C5D;"
                                        data-bs-toggle="modal" data-bs-target="#modalIzin_{{ $item->id }}"
                                        title="Lihat Keterangan">
                                    <i class="bi bi-info-circle-fill fs-5"></i>
                                </button>

                                {{-- Modal Keterangan --}}
                                <div class="modal fade" id="modalIzin_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content" style="border-radius:1.5rem; border:1px solid var(--border); box-shadow:var(--shadow-float); background:var(--bg); overflow:hidden;">
                                            <div style="padding:1.25rem 1.5rem 0.75rem; background:rgba(193,140,93,0.06); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
                                                <h6 style="font-family:'Fraunces',serif; font-weight:700; color:var(--fg); margin:0; display:flex; align-items:center; gap:8px;">
                                                    <i class="bi bi-envelope-paper-fill" style="color:#C18C5D;"></i> Detail {{ $item->status }}
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div style="padding:1.25rem 1.5rem; text-align:center;">
                                                <div style="font-family:'Fraunces',serif; font-weight:700; font-size:1.05rem; margin-bottom:2px;">{{ $item->santri->nama ?? '-' }}</div>
                                                <div style="font-size:0.75rem; color:var(--muted-fg); margin-bottom:1rem;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                                                <div style="background:rgba(193,140,93,0.08); border-radius:14px; padding:0.9rem 1rem; text-align:left; margin-bottom:0.75rem;">
                                                    <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Alasan</div>
                                                    <div style="font-size:0.88rem;">{{ $item->keterangan ?: 'Tidak ada keterangan.' }}</div>
                                                </div>
                                                @if($item->bukti_izin)
                                                <div style="text-align:left;">
                                                    <div style="font-size:0.7rem; font-weight:700; color:var(--muted-fg); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">Bukti Lampiran</div>
                                                    <a href="{{ asset('storage/'.$item->bukti_izin) }}" target="_blank" style="display:block; border-radius:14px; border:1px solid var(--border); overflow:hidden; background:var(--muted);">
                                                        @if(Str::endsWith(strtolower($item->bukti_izin), ['.jpg','.jpeg','.png']))
                                                            <img src="{{ asset('storage/'.$item->bukti_izin) }}" alt="Bukti" style="width:100%; max-height:200px; object-fit:contain;">
                                                        @else
                                                            <div style="padding:1.5rem; text-align:center;">
                                                                <i class="bi bi-file-earmark-pdf-fill" style="font-size:2.5rem; color:var(--negative); display:block; margin-bottom:6px;"></i>
                                                                <div style="font-size:0.82rem; font-weight:700;">Lihat Dokumen PDF</div>
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
                        <small>Belum ada riwayat absensi hari ini.</small>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
