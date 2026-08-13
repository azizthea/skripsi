@extends('layouts.app')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 style="color: var(--neo-dark); font-weight: 700; margin-bottom: 0;">Rekam Jejak Harian Santri</h3>
        <p class="text-muted mb-0">Pilih profil santri untuk melihat riwayat aktivitas harian (Kehadiran & Pelanggaran).</p>
    </div>
    <div class="col-md-6 d-flex justify-content-md-end gap-3 mt-3 mt-md-0">
        <form action="{{ route('aktivitas.index') }}" method="GET" class="d-flex gap-2 w-100" style="max-width: 300px;">
            <input type="text" name="search" class="form-control neo-input" placeholder="Cari nama santri..." value="{{ $search }}">
            <button type="submit" class="neo-btn neo-btn-primary px-3 d-flex align-items-center justify-content-center" title="Cari">
                <i class="bi bi-search" style="font-weight: bold;"></i>
            </button>
        </form>
        <a href="{{ route('aktivitas.create') }}" class="neo-btn neo-btn-primary d-flex align-items-center text-nowrap">+ Input Aktivitas</a>
    </div>
</div>

<div class="row g-4">
    @forelse($santris as $santri)
    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <div class="neo-card p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onclick="window.location.href='{{ route('aktivitas.show', $santri->id) }}'">
            <!-- Avatar -->
            <div class="mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($santri->nama) }}&background=E2E8F0&color=2D3748&size=80&rounded=true&bold=true" alt="Avatar {{ $santri->nama }}" class="rounded-circle shadow-sm" style="border: 3px solid white;">
            </div>
            
            <!-- Info -->
            <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem; line-height: 1.2;">{{ $santri->nama }}</h5>
            <div class="text-muted small mb-3">NIS: {{ $santri->nis }}</div>
            
            <!-- Badges -->
            <div class="d-flex gap-2 mb-4 justify-content-center flex-wrap">
                <span class="badge bg-light text-dark border"><i class="bi bi-bookmark-fill text-primary me-1"></i> Kelas {{ $santri->kelas }}</span>
                <span class="badge bg-light text-dark border"><i class="bi bi-house-door-fill text-success me-1"></i> Kamar {{ $santri->kamar }}</span>
                @if($santri->jenis_kelamin == 'Putra')
                    <span class="badge" style="background:#EBF8FF;color:#2B6CB0;border:1px solid #BEE3F8;"><i class="bi bi-gender-male me-1"></i> Putra</span>
                @elseif($santri->jenis_kelamin == 'Putri')
                    <span class="badge" style="background:#FFF5F5;color:#C53030;border:1px solid #FED7D7;"><i class="bi bi-gender-female me-1"></i> Putri</span>
                @endif
            </div>
            
            <!-- Action -->
            <a href="{{ route('aktivitas.show', $santri->id) }}" class="neo-btn neo-btn-primary w-100 mt-auto text-decoration-none">
                Lihat Riwayat <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center border-0 shadow-sm" style="background: rgba(49, 130, 206, 0.1); color: #2B6CB0;">
            <i class="bi bi-info-circle-fill me-2"></i> Belum ada data santri aktif atau tidak ditemukan.
        </div>
    </div>
    @endforelse
</div>

<style>
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
</style>
@endsection
