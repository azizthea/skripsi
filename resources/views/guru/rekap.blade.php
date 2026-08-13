@extends('layouts.guru')

@section('extra-styles')
<style>
    .rekap-header {
        background: linear-gradient(135deg, var(--af-guru), var(--af-guru-dark));
        color: white;
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(47, 133, 90, 0.3);
    }
    .pct-bar { height: 6px; border-radius: 50px; background: rgba(163,177,198,0.3); margin-top: 4px; }
    .pct-fill { height: 6px; border-radius: 50px; transition: width 0.8s ease; }
    .kategori-tinggi { background: rgba(56,161,105,0.15); color: #38A169; font-weight: 700; padding: 4px 14px; border-radius: 50px; font-size: 0.8rem; }
    .kategori-sedang { background: rgba(214,158,46,0.15); color: #B7791F; font-weight: 700; padding: 4px 14px; border-radius: 50px; font-size: 0.8rem; }
    .kategori-rendah { background: rgba(229,62,62,0.15); color: #E53E3E; font-weight: 700; padding: 4px 14px; border-radius: 50px; font-size: 0.8rem; }
    .kategori-belum { background: rgba(160,174,192,0.2); color: #718096; font-weight: 700; padding: 4px 14px; border-radius: 50px; font-size: 0.8rem; }
    .table-rekap th { background: rgba(47, 133, 90, 0.06) !important; font-size: 0.75rem; }
    .export-btn {
        background: linear-gradient(135deg, #38A169, #2F6F4A);
        color: white; border: none; border-radius: 50px;
        padding: 8px 20px; font-weight: 600; font-size: 0.85rem;
        cursor: pointer; box-shadow: 0 4px 12px rgba(56,161,105,0.3);
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid pb-5">

    <!-- Header -->
    <div class="rekap-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="bi bi-table me-2"></i>Rekap Absensi Bulanan</h3>
                <p class="mb-0" style="opacity: 0.85; font-size: 0.9rem;">Periode: <strong>{{ $periodeTeks }}</strong></p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="neo-btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="neo-card p-3 mb-4">
        <form method="GET" action="{{ route('guru.rekap') }}" class="row m-0 g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Kelas</label>
                <select name="kelas" class="form-select neo-input">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->nama_kelas }}" {{ $kelasFilter == $kelas->nama_kelas ? 'selected' : '' }}>
                            {{ $kelas->jenjang }} – {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Bulan</label>
                <select name="bulan" class="form-select neo-input">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Tahun</label>
                <select name="tahun" class="form-select neo-input">
                    @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="neo-btn neo-btn-primary w-100" style="padding: 10px;">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
            </div>
            <div class="col-md-3 text-end">
                <small class="text-muted">Total efektif pertemuan: <strong>{{ $hariEfektif }}</strong></small>
            </div>
        </form>
    </div>

    <!-- Rekap Table -->
    <div class="neo-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(163,177,198,0.2); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h6 class="fw-bold mb-0" style="color: var(--af-guru)">
                    <i class="bi bi-table me-2"></i>Rekap Kehadiran — {{ $periodeTeks }}
                </h6>
                <small class="text-muted">{{ $rekap->count() }} santri</small>
            </div>
            <div class="d-flex gap-2">
                <span class="text-muted small me-2 align-self-center">Legenda:</span>
                <span style="background:rgba(56,161,105,0.12);color:#38A169;padding:3px 10px;border-radius:50px;font-size:0.75rem;font-weight:600;">H=Hadir</span>
                <span style="background:rgba(214,158,46,0.12);color:#B7791F;padding:3px 10px;border-radius:50px;font-size:0.75rem;font-weight:600;">I=Izin</span>
                <span style="background:rgba(229,62,62,0.12);color:#E53E3E;padding:3px 10px;border-radius:50px;font-size:0.75rem;font-weight:600;">A=Alpa</span>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="table table-borderless align-middle table-rekap" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="padding: 0.85rem 1rem; width: 40px;">#</th>
                        <th style="padding: 0.85rem 1rem;">NIS</th>
                        <th style="padding: 0.85rem 1rem;">Nama Santri</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;">Kelas</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;" colspan="2">Pengajian</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;" colspan="2">Sekolah</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;">% Pengajian</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;">% Sekolah</th>
                        <th class="text-center" style="padding: 0.85rem 1rem;">Kategori</th>
                    </tr>
                    <tr style="background: rgba(47,133,90,0.04);">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center" style="font-size: 0.7rem; color: #38A169; padding: 0.4rem 1rem;">H</th>
                        <th class="text-center" style="font-size: 0.7rem; color: #D69E2E; padding: 0.4rem 1rem;">I/A</th>
                        <th class="text-center" style="font-size: 0.7rem; color: #38A169; padding: 0.4rem 1rem;">H</th>
                        <th class="text-center" style="font-size: 0.7rem; color: #D69E2E; padding: 0.4rem 1rem;">I/A</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $index => $data)
                    <tr>
                        <td style="padding: 0.8rem 1rem;" class="fw-bold text-muted">{{ $index + 1 }}</td>
                        <td style="padding: 0.8rem 1rem;" class="text-muted">{{ $data->santri->nis ?? '-' }}</td>
                        <td style="padding: 0.8rem 1rem;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(47, 133, 90, 0.12); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: var(--af-guru); flex-shrink: 0;">
                                    {{ substr($data->santri->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size: 0.9rem;">{{ $data->santri->nama }}</div>
                                    <small class="text-muted">{{ $data->santri->kamar ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            <span style="background: rgba(47, 133, 90, 0.12); color: var(--af-guru); padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                                {{ $data->santri->kelas }}
                            </span>
                        </td>
                        <!-- Pengajian -->
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            <span class="fw-bold" style="color: #38A169;">{{ $data->hadir_pengajian }}</span>
                        </td>
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            <span class="text-muted" style="font-size: 0.85rem;">{{ $data->izin_pengajian }}/<span style="color:#E53E3E;">{{ $data->alpa_pengajian }}</span></span>
                        </td>
                        <!-- Sekolah -->
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            <span class="fw-bold" style="color: #38A169;">{{ $data->hadir_sekolah }}</span>
                        </td>
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            <span class="text-muted" style="font-size: 0.85rem;">{{ $data->izin_sekolah }}/<span style="color:#E53E3E;">{{ $data->alpa_sekolah }}</span></span>
                        </td>
                        <!-- % Pengajian -->
                        <td style="padding: 0.8rem 1rem; min-width: 110px;">
                            <div class="text-center fw-bold" style="color: #805AD5; font-size: 0.9rem;">{{ $data->pct_pengajian }}%</div>
                            <div class="pct-bar">
                                <div class="pct-fill" style="width: {{ $data->pct_pengajian }}%; background: linear-gradient(90deg, #805AD5, #6B46C1);"></div>
                            </div>
                        </td>
                        <!-- % Sekolah -->
                        <td style="padding: 0.8rem 1rem; min-width: 110px;">
                            <div class="text-center fw-bold" style="color: #DD6B20; font-size: 0.9rem;">{{ $data->pct_sekolah }}%</div>
                            <div class="pct-bar">
                                <div class="pct-fill" style="width: {{ $data->pct_sekolah }}%; background: linear-gradient(90deg, #DD6B20, #C05621);"></div>
                            </div>
                        </td>
                        <!-- Kategori -->
                        <td class="text-center" style="padding: 0.8rem 1rem;">
                            @if($data->kategori === 'Tinggi')
                                <span class="kategori-tinggi"><i class="bi bi-award-fill me-1"></i>Tinggi</span>
                            @elseif($data->kategori === 'Sedang')
                                <span class="kategori-sedang"><i class="bi bi-dash-circle-fill me-1"></i>Sedang</span>
                            @elseif($data->kategori === 'Rendah')
                                <span class="kategori-rendah"><i class="bi bi-exclamation-circle-fill me-1"></i>Rendah</span>
                            @else
                                <span class="kategori-belum">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            <div class="text-muted">Tidak ada data santri untuk filter yang dipilih.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
