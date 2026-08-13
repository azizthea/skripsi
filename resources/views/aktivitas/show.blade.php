@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('aktivitas.index') }}" class="neo-btn me-3 px-3 py-2 text-decoration-none" style="font-size: 0.9rem;">&larr; Kembali ke Daftar Santri</a>
</div>

<!-- Profil Header -->
<div class="neo-card p-4 mb-4">
    <div class="d-flex align-items-center flex-wrap gap-4">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($santri->nama) }}&background=E2E8F0&color=2D3748&size=100&rounded=true&bold=true" alt="Avatar" class="rounded-circle shadow-sm" style="border: 4px solid white;">
        
        <div>
            <h2 class="fw-bold mb-1 text-dark">{{ $santri->nama }}</h2>
            <p class="text-muted mb-2" style="font-size: 1.1rem;">Nomor Induk Santri: {{ $santri->nis }}</p>
            <div class="d-flex gap-2">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill"><i class="bi bi-bookmark-fill me-1"></i> Kelas {{ $santri->kelas }}</span>
                <span class="badge bg-success text-white px-3 py-2 rounded-pill"><i class="bi bi-house-door-fill me-1"></i> Kamar {{ $santri->kamar }}</span>
                @if($santri->jenis_kelamin == 'Putra')
                    <span class="badge" style="background:#EBF8FF;color:#2B6CB0;border:1px solid #BEE3F8;padding:0.5rem 1rem;border-radius:50rem;"><i class="bi bi-gender-male me-1"></i> Putra</span>
                @elseif($santri->jenis_kelamin == 'Putri')
                    <span class="badge" style="background:#FFF5F5;color:#C53030;border:1px solid #FED7D7;padding:0.5rem 1rem;border-radius:50rem;"><i class="bi bi-gender-female me-1"></i> Putri</span>
                @endif
            </div>
        </div>
        
        <div class="ms-md-auto mt-3 mt-md-0 text-md-end border-start ps-md-4">
            <p class="text-muted mb-1 small fw-bold">Total Rekam Jejak Tercatat</p>
            <h1 class="fw-bold text-primary mb-0">{{ $aktivitas->count() }} <span style="font-size: 1rem; color: #888;">Hari</span></h1>
            <a href="{{ route('aktivitas.create') }}" class="neo-btn neo-btn-primary mt-3 btn-sm">+ Tambah Rekam Baru</a>
        </div>
    </div>
</div>

<!-- Tabel Riwayat -->
<div class="neo-card p-0">
    <div class="p-4 border-bottom">
        <h5 class="fw-bold mb-0" style="color: var(--neo-dark);"><i class="bi bi-journal-text text-primary me-2"></i>Tabel Riwayat Aktivitas Harian</h5>
        <p class="text-muted small mb-0 mt-1">Hanya menampilkan riwayat Aktivitas Kehadiran Sekolah dan Aktivitas Pelanggaran sesuai batasan sistem.</p>
    </div>
    
    <div class="table-responsive m-3">
        <table class="table table-borderless table-hover align-middle">
            <thead style="border-bottom: 2px solid rgba(0,0,0,0.05);">
                <tr class="text-muted small">
                    <th>TANGGAL INPUT</th>
                    <th class="text-center">AKTIVITAS KEHADIRAN (SEKOLAH)</th>
                    <th class="text-center">AKTIVITAS PELANGGARAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitas as $a)
                <tr>
                    <td style="font-weight: 600; color: #4A5568;">
                        <i class="bi bi-calendar-event me-2 text-primary opacity-50"></i>
                        {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l, d F Y') }}
                    </td>
                    
                    <!-- Aktivitas Kehadiran (Sekolah) -->
                    <td class="text-center">
                        @if($a->sekolah == 'hadir') 
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Hadir</span>
                        @elseif($a->sekolah == 'terlambat') 
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="bi bi-clock-history me-1"></i> Terlambat</span>
                        @else 
                            <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Tidak Hadir</span> 
                        @endif
                    </td>

                    <!-- Aktivitas Pelanggaran -->
                    <td class="text-center">
                        @if($a->jumlah_pelanggaran == 0)
                            <span class="badge bg-light text-success border border-success rounded-pill px-3 py-2"><i class="bi bi-shield-check me-1"></i> Bersih (0)</span>
                        @else
                            <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $a->jumlah_pelanggaran }} Pelanggaran</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            Belum ada riwayat aktivitas yang tercatat untuk santri ini.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
