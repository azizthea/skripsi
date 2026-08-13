@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0" style="color: var(--af-dark);">
        <i class="bi bi-buildings me-2" style="color: var(--af-primary);"></i> Data Ruang Belajar
    </h3>
    <a href="{{ route('ruangan.atur', ['jenis_ruang' => $jenisRuang]) }}" class="btn btn-success px-4 fw-bold" style="border-radius: 12px; box-shadow: var(--neo-shadow-btn);">
        <i class="bi bi-plus-circle me-1"></i> Atur Ruangan
    </a>
</div>

@if(session('success'))
<div class="alert bg-success text-white rounded-3 mb-4 border-0 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
</div>
@endif

<div class="neo-card p-4 mb-4">
    <form action="{{ route('ruangan.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold small text-muted">Kategori Ruang</label>
            <select name="jenis_ruang" class="form-select neo-input" onchange="this.form.submit()">
                <option value="sekolah" {{ $jenisRuang == 'sekolah' ? 'selected' : '' }}>Ruang Sekolah (Kelas Formal)</option>
                <option value="pengajian" {{ $jenisRuang == 'pengajian' ? 'selected' : '' }}>Ruang Pengajian (Halaqah)</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-bold small text-muted">Gender</label>
            <select name="jenis_kelamin" class="form-select neo-input" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="Putra" {{ ($filterGender ?? '') == 'Putra' ? 'selected' : '' }}>Putra</option>
                <option value="Putri" {{ ($filterGender ?? '') == 'Putri' ? 'selected' : '' }}>Putri</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-bold small text-muted">Jenjang</label>
            <select name="jenjang" class="form-select neo-input" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="MTs" {{ ($filterJenjang ?? '') == 'MTs' ? 'selected' : '' }}>MTs</option>
                <option value="MA" {{ ($filterJenjang ?? '') == 'MA' ? 'selected' : '' }}>MA</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <label class="form-label fw-bold small text-muted">Pilih Spesifik Ruang (Opsional)</label>
            <select name="ruang" class="form-select neo-input" onchange="this.form.submit()">
                <option value="">-- Semua Ruang {{ ucfirst($jenisRuang) }} --</option>
                @foreach($ruangList as $ruang)
                    <option value="{{ $ruang }}" {{ $selectedRuang == $ruang ? 'selected' : '' }}>{{ $ruang }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="neo-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; background: rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.05);">
        <h5 class="m-0 fw-bold">
            Daftar Santri: 
            <span style="color: var(--af-primary);">
                {{ $selectedRuang ? $selectedRuang : 'Semua Ruang ' . ucfirst($jenisRuang) }}
            </span>
            <span class="badge bg-secondary ms-2">{{ $santris->count() }} Santri</span>
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless table-hover align-middle mb-0">
            <thead style="background: rgba(0,0,0,0.02);">
                <tr>
                    <th style="padding: 1rem 1.5rem;">No</th>
                    <th style="padding: 1rem 1.5rem;">NIS</th>
                    <th style="padding: 1rem 1.5rem;">Nama Santri</th>
                    <th style="padding: 1rem 1.5rem;">L/P</th>
                    <th style="padding: 1rem 1.5rem;">Jenjang</th>
                    @if($jenisRuang == 'sekolah')
                        <th style="padding: 1rem 1.5rem;">Ruang Sekolah</th>
                    @else
                        <th style="padding: 1rem 1.5rem;">Ruang Pengajian</th>
                    @endif
                    <th style="padding: 1rem 1.5rem;">Wali Kelas / Ustadz</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $index => $santri)
                    <tr>
                        <td style="padding: 0.85rem 1.5rem;" class="text-muted fw-bold">{{ $index + 1 }}</td>
                        <td style="padding: 0.85rem 1.5rem;">{{ $santri->nis ?? '-' }}</td>
                        <td style="padding: 0.85rem 1.5rem; color: var(--af-dark);" class="fw-bold">{{ $santri->nama }}</td>
                        <td style="padding: 0.85rem 1.5rem;">
                            @if($santri->jenis_kelamin == 'Putra')
                                <span class="badge" style="background:#EBF8FF;color:#2B6CB0;"><i class="bi bi-gender-male"></i> L</span>
                            @elseif($santri->jenis_kelamin == 'Putri')
                                <span class="badge" style="background:#FFF5F5;color:#C53030;"><i class="bi bi-gender-female"></i> P</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td style="padding: 0.85rem 1.5rem;">
                            <span class="badge" style="background-color: var(--af-bg); color: var(--af-dark); box-shadow: var(--neo-shadow-inner);">{{ $santri->jenjang }}</span>
                        </td>
                        @if($jenisRuang == 'sekolah')
                            <td style="padding: 0.85rem 1.5rem;">
                                <span class="badge bg-light text-dark border">{{ $santri->kelas ?: '-' }}</span>
                            </td>
                        @else
                            <td style="padding: 0.85rem 1.5rem;">
                                <span class="badge bg-light text-dark border">{{ $santri->ruang_pengajian ?: '-' }}</span>
                            </td>
                        @endif
                        <td style="padding: 0.85rem 1.5rem;">
                            <span class="badge" style="background-color: var(--af-positive); color: white;">{{ $santri->wali_kelas ?: '-' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            Tidak ada data santri ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($santris->hasPages())
    <div style="padding: 1.5rem; background: white; border-top: 1px solid rgba(0,0,0,0.05);" class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Menampilkan {{ $santris->firstItem() }}–{{ $santris->lastItem() }}
            dari <strong>{{ $santris->total() }}</strong> santri
        </div>
        <div>
            @php
                $prev = $santris->currentPage() > 1;
                $next = $santris->hasMorePages();
            @endphp
            <div class="d-flex gap-1 align-items-center">
                {{-- Prev --}}
                @if($prev)
                    <a href="{{ $santris->previousPageUrl() }}" class="neo-btn px-3 py-1" style="font-size:0.85rem;">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                @else
                    <span class="neo-btn px-3 py-1" style="font-size:0.85rem;opacity:0.4;cursor:not-allowed;">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                @endif

                {{-- Page numbers --}}
                @foreach($santris->getUrlRange(max(1, $santris->currentPage()-2), min($santris->lastPage(), $santris->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}"
                       class="neo-btn px-3 py-1 {{ $page == $santris->currentPage() ? 'neo-btn-primary' : '' }}"
                       style="font-size:0.85rem;min-width:36px;text-align:center;">
                        {{ $page }}
                    </a>
                @endforeach

                {{-- Next --}}
                @if($next)
                    <a href="{{ $santris->nextPageUrl() }}" class="neo-btn px-3 py-1" style="font-size:0.85rem;">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <span class="neo-btn px-3 py-1" style="font-size:0.85rem;opacity:0.4;cursor:not-allowed;">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
