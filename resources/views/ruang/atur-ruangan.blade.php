@extends('layouts.app')

@section('content')
<style>
    .atur-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .atur-header h3 {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--af-dark);
        margin: 0;
    }
    .atur-header h3 i { color: var(--af-primary); }

    /* Custom Checkbox Visibility */
    .form-check-input {
        border: 2px solid #94a3b8 !important;
        background-color: #f8fafc;
        cursor: pointer;
        opacity: 1 !important;
        box-shadow: none !important;
    }
    .form-check-input:checked {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
    .form-check-input:focus {
        border-color: #86b7fe !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }

    .config-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .config-card .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
        margin-bottom: 1rem;
    }

    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .filter-bar .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
    }

    .data-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .data-card .data-header {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .data-card .data-header h6 {
        font-weight: 700;
        color: var(--af-dark);
        margin: 0;
    }

    .santri-table {
        width: 100%;
        border-collapse: collapse;
    }
    .santri-table thead th {
        padding: 0.9rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .santri-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }
    .santri-table tbody tr:hover { background: #f8fafc; }
    .santri-table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        color: #334155;
    }
    .santri-table .nama-cell {
        font-weight: 600;
        color: var(--af-dark);
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    .santri-table .jenjang-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .santri-table .jenjang-mts {
        background: #dbeafe;
        color: #1e40af;
    }
    .santri-table .jenjang-ma {
        background: #f3e8ff;
        color: #6b21a8;
    }
    .santri-table .check-col { width: 50px; text-align: center; }

    .submit-bar {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.04);
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .btn-simpan {
        background: var(--af-positive);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .btn-simpan:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 12px -2px rgba(0,0,0,0.15);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 3rem;
        display: block;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .select-clean {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-weight: 500;
        color: #334155;
        background: white;
        transition: border-color 0.2s;
    }
    .select-clean:focus {
        border-color: var(--af-positive);
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    .counter-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #f1f5f9;
        color: #475569;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

{{-- Header --}}
<div class="atur-header">
    <h3>
        <i class="bi bi-person-lines-fill me-2"></i>Atur Ruangan Santri
    </h3>
    <a href="{{ route('ruangan.index', ['jenis_ruang' => $jenisRuang]) }}" class="btn btn-light px-4 fw-bold" style="border-radius: 12px;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="alert bg-success text-white rounded-3 mb-4 border-0 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
</div>
@endif

{{-- Bagian Atas: Config Dropdowns (di luar form POST, tapi select terhubung via form="formPenempatan") --}}
<div class="config-card">
    <div class="section-label">Konfigurasi Penempatan</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-bold" style="font-size: 0.85rem; color: #334155;">Wali Kelas / Ustadz</label>
            <select name="wali_kelas" class="form-select select-clean" required form="formPenempatan">
                <option value="">-- Pilih Wali Kelas --</option>
                @foreach($listWaliKelas as $wk)
                    <option value="{{ $wk }}">{{ $wk }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold" style="font-size: 0.85rem; color: #334155;">Nama Ruang / Kelas</label>
            <select name="nama_ruang" class="form-select select-clean" required form="formPenempatan">
                <option value="">-- Pilih Ruangan --</option>
                @if($jenisRuang === 'sekolah')
                    @foreach($listKelasSekolah as $ks)
                        <option value="{{ $ks }}">{{ $ks }}</option>
                    @endforeach
                @else
                    @foreach($listRuangPengajian as $rp)
                        <option value="{{ $rp }}">{{ $rp }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold" style="font-size: 0.85rem; color: #334155;">Kategori Ruang</label>
            <select class="form-select select-clean" onchange="window.location.href='{{ route('ruangan.atur') }}?jenis_ruang=' + this.value + '{{ $filterJenjang ? '&jenjang='.$filterJenjang : '' }}'">
                <option value="sekolah" {{ $jenisRuang == 'sekolah' ? 'selected' : '' }}>Sekolah (Kelas Formal)</option>
                <option value="pengajian" {{ $jenisRuang == 'pengajian' ? 'selected' : '' }}>Pengajian (Halaqah)</option>
            </select>
        </div>
    </div>
</div>

{{-- Bagian Tengah: Filter Jenjang (standalone GET form) --}}
<form action="{{ route('ruangan.atur') }}" method="GET" class="filter-bar">
    <input type="hidden" name="jenis_ruang" value="{{ $jenisRuang }}">
    
    <div class="d-flex align-items-center gap-2">
        <span class="filter-label"><i class="bi bi-funnel me-1"></i>Jenjang</span>
        <select name="jenjang" class="form-select select-clean" style="width: 130px;">
            <option value="">Semua</option>
            <option value="MTs" {{ $filterJenjang == 'MTs' ? 'selected' : '' }}>MTs</option>
            <option value="MA" {{ $filterJenjang == 'MA' ? 'selected' : '' }}>MA</option>
        </select>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="filter-label">Gender</span>
        <select name="jenis_kelamin" class="form-select select-clean" style="width: 130px;">
            <option value="">Semua</option>
            <option value="Putra" {{ ($filterGender ?? '') == 'Putra' ? 'selected' : '' }}>Putra</option>
            <option value="Putri" {{ ($filterGender ?? '') == 'Putri' ? 'selected' : '' }}>Putri</option>
        </select>
    </div>

    <button type="submit" class="btn px-3" style="background: #f1f5f9; border-radius: 10px; font-weight: 600; color: #475569; border: 1px solid #e2e8f0;">
        <i class="bi bi-search me-1"></i> Filter
    </button>
</form>

{{-- Form POST Penempatan (tabel + submit) --}}
<form action="{{ route('ruangan.simpan') }}" method="POST" id="formPenempatan">
    @csrf
    <input type="hidden" name="jenis_ruang" value="{{ $jenisRuang }}">

    {{-- Bagian Bawah: Tabel Data --}}
    <div class="data-card">
        <div class="data-header">
            <h6>
                <i class="bi bi-people me-2" style="color: var(--af-primary);"></i>
                Santri Belum Memiliki {{ $jenisRuang == 'sekolah' ? 'Kelas' : 'Ruang Pengajian' }}
            </h6>
            <div class="counter-badge">
                <i class="bi bi-person"></i> {{ $unassignedSantris->count() }} santri
            </div>
        </div>

        @if($unassignedSantris->isEmpty())
            <div class="empty-state">
                <i class="bi bi-check-circle text-success"></i>
                <h6 class="fw-bold text-muted">Semua Santri Sudah Terdaftar</h6>
                <p class="small">Tidak ada santri aktif yang belum memiliki {{ $jenisRuang == 'sekolah' ? 'kelas' : 'ruang pengajian' }}{{ $filterJenjang ? ' pada jenjang ' . $filterJenjang : '' }}.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="santri-table">
                    <thead>
                        <tr>
                            <th class="check-col">
                                <input class="form-check-input" type="checkbox" id="checkAll" style="transform: scale(1.2);" title="Pilih Semua">
                            </th>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>L/P</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unassignedSantris as $index => $s)
                        <tr>
                            <td class="check-col">
                                <input class="form-check-input santri-check" type="checkbox" name="santri_ids[]" value="{{ $s->id }}" style="transform: scale(1.15);">
                            </td>
                            <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                            <td>{{ $s->nis ?? '-' }}</td>
                            <td class="nama-cell">{{ $s->nama }}</td>
                            <td>
                                @if($s->jenis_kelamin == 'Putra')
                                    <span class="badge" style="background:#EBF8FF;color:#2B6CB0;"><i class="bi bi-gender-male"></i> L</span>
                                @elseif($s->jenis_kelamin == 'Putri')
                                    <span class="badge" style="background:#FFF5F5;color:#C53030;"><i class="bi bi-gender-female"></i> P</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="jenjang-badge {{ $s->jenjang == 'MTs' ? 'jenjang-mts' : 'jenjang-ma' }}">{{ $s->jenjang }}</span>
                            </td>
                            <td>
                                <span style="color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Belum ditempatkan</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Submit Bar --}}
            <div class="submit-bar">
                <div style="font-size: 0.85rem; color: #64748b;">
                    <span id="selectedCount" class="fw-bold" style="color: var(--af-positive);">0</span> santri dipilih
                </div>
                <button type="submit" class="btn btn-simpan">
                    <i class="bi bi-save me-2"></i>Simpan Penempatan
                </button>
            </div>
        @endif
    </div>
</form>
@endsection

@section('extra-scripts')
<script>
    // Check All toggle
    document.getElementById('checkAll')?.addEventListener('change', function() {
        document.querySelectorAll('.santri-check').forEach(cb => {
            cb.checked = this.checked;
        });
        updateCount();
    });

    // Update selected count on each checkbox change
    document.querySelectorAll('.santri-check').forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    function updateCount() {
        const count = document.querySelectorAll('.santri-check:checked').length;
        const el = document.getElementById('selectedCount');
        if (el) el.textContent = count;
    }

    // Validate before submit
    document.getElementById('formPenempatan')?.addEventListener('submit', function(e) {
        const checked = document.querySelectorAll('.santri-check:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Silakan centang minimal 1 santri untuk ditempatkan.');
        }
    });
</script>
@endsection
