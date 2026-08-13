@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--af-positive);">
            <i class="bi bi-people me-2"></i>Data Santri
        </h3>
        <p class="text-muted mb-0">Kelola data santri Pondok Pesantren Alfurqoniyah</p>
    </div>
    <div class="d-flex flex-column flex-md-row gap-2 w-100" style="max-width: max-content;">
        <button type="button" class="neo-btn flex-grow-1 d-flex align-items-center justify-content-center text-center" style="min-height: 45px; padding: 0.5rem 1rem; color: var(--af-positive);"
                data-bs-toggle="modal" data-bs-target="#modalKenaikanKelas">
            <i class="bi bi-arrow-up-circle-fill me-1"></i> Kenaikan Kelas
        </button>
        <a href="{{ route('santri.create') }}" class="neo-btn neo-btn-primary flex-grow-1 d-flex align-items-center justify-content-center text-center" style="min-height: 45px; padding: 0.5rem 1rem;">
            <i class="bi bi-plus-circle me-1"></i> Registrasi Santri
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════
     FILTER KATEGORI KELAS (DROPDOWN)
═══════════════════════════════════════ --}}
<div class="neo-card p-3 mb-3">
    <form method="GET" action="{{ route('santri.index') }}"
          class="row m-0 g-2 align-items-center" id="filterForm">

        <div class="col-12 col-md-auto">
            <span class="text-muted small fw-bold"><i class="bi bi-funnel me-1"></i>Filter:</span>
        </div>

        {{-- Dropdown Gender --}}
        <div class="col-6 col-md-2">
            <select name="jenis_kelamin" class="form-select neo-input w-100"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Gender</option>
                <option value="Putra" {{ ($filterGender ?? '') === 'Putra' ? 'selected' : '' }}>Putra</option>
                <option value="Putri" {{ ($filterGender ?? '') === 'Putri' ? 'selected' : '' }}>Putri</option>
            </select>
        </div>

        {{-- Dropdown Jenjang --}}
        <div class="col-6 col-md-3">
            <select name="jenjang" class="form-select neo-input w-100"
                    onchange="handleJenjangChange(this)">
                <option value="">Semua Jenjang</option>
                <option value="MTs" {{ $filterJenjang === 'MTs' ? 'selected' : '' }}>MTs</option>
                <option value="MA"  {{ $filterJenjang === 'MA'  ? 'selected' : '' }}>MA</option>
            </select>
        </div>

        {{-- Dropdown Kelas (difilter by jenjang via JS) --}}
        <div class="col-12 col-md-3">
            <select name="kelas" class="form-select neo-input w-100"
                    id="selectKelas" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kl)
                    <option value="{{ $kl->nama_kelas }}"
                            data-jenjang="{{ $kl->jenjang }}"
                            {{ $filterKelas === $kl->nama_kelas ? 'selected' : '' }}>
                        {{ $kl->nama_kelas }} ({{ $kl->jenjang }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md d-flex flex-wrap gap-2 align-items-center">
            <span class="text-muted small">
                <strong>{{ $santris->total() }}</strong> santri
            </span>

            @if($filterJenjang || $filterKelas || ($filterGender ?? false))
                <a href="{{ route('santri.index') }}" class="neo-btn flex-grow-1 text-center px-3 ms-md-auto text-danger" style="height: 42px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-x-lg me-1"></i>Reset
                </a>
            @endif
        </div>
    </form>
</div>

<script>
function handleJenjangChange(sel) {
    const jenjang  = sel.value;
    const kelasEl  = document.getElementById('selectKelas');
    // Reset pilihan kelas saat jenjang berubah
    kelasEl.value = '';
    // Sembunyikan/tampilkan opsi kelas sesuai jenjang
    Array.from(kelasEl.options).forEach(opt => {
        if (!opt.value) return; // skip "Semua Kelas"
        opt.hidden = jenjang ? opt.dataset.jenjang !== jenjang : false;
    });
    document.getElementById('filterForm').submit();
}
// Saat halaman load, sembunyikan opsi kelas yang tidak sesuai jenjang aktif
document.addEventListener('DOMContentLoaded', () => {
    const jenjang  = '{{ $filterJenjang }}';
    const kelasEl  = document.getElementById('selectKelas');
    if (jenjang) {
        Array.from(kelasEl.options).forEach(opt => {
            if (!opt.value) return;
            opt.hidden = opt.dataset.jenjang !== jenjang;
        });
    }
});
</script>

{{-- ═══════════════════════════════════════
     TABEL SANTRI
═══════════════════════════════════════ --}}
<div class="neo-card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="table table-borderless table-hover align-middle" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.25rem;">No</th>
                    <th style="padding: 1rem 1.25rem;">NIS</th>
                    <th style="padding: 1rem 1.25rem;">Nama Santri</th>
                    <th style="padding: 1rem 1.25rem;">L/P</th>
                    <th style="padding: 1rem 1.25rem;">Jenjang</th>
                    <th style="padding: 1rem 1.25rem;">Kelas</th>
                    <th style="padding: 1rem 1.25rem;">Kamar</th>
                    <th style="padding: 1rem 1.25rem;">Status</th>
                    <th class="text-end" style="padding: 1rem 1.25rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $index => $s)
                <tr>
                    <td style="padding: 0.85rem 1.25rem;" class="fw-bold text-muted">
                        {{ ($santris->currentPage() - 1) * $santris->perPage() + $index + 1 }}
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="text-muted">{{ $s->nis ?? '-' }}</span>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="fw-bold" style="color: var(--af-positive);">{{ $s->nama }}</span>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        @if($s->jenis_kelamin == 'Putra')
                            <span class="badge" style="background:#EBF8FF;color:#2B6CB0;"><i class="bi bi-gender-male me-1"></i>Putra</span>
                        @elseif($s->jenis_kelamin == 'Putri')
                            <span class="badge" style="background:#FFF5F5;color:#C53030;"><i class="bi bi-gender-female me-1"></i>Putri</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        @if($s->jenjang === 'MTs')
                            <span class="badge rounded-pill px-2" style="background:#EBF8FF;color:#2B6CB0;font-size:0.72rem;">MTs</span>
                        @else
                            <span class="badge rounded-pill px-2" style="background:#FAF5FF;color:#6B46C1;font-size:0.72rem;">MA</span>
                        @endif
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="badge" style="background:#E2E8F0; color:#2D3748; font-weight:700; font-size:0.75rem; border-radius:50px; padding:0.35rem 0.75rem;">
                            {{ $s->kelas }}
                        </span>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        <span class="badge" style="background:#E2E8F0; color:#2D3748; font-weight:700; font-size:0.75rem; border-radius:50px; padding:0.35rem 0.75rem;">
                            {{ $s->kamar ?? '-' }}
                        </span>
                    </td>
                    <td style="padding: 0.85rem 1.25rem;">
                        @if($s->status == 'aktif')
                            <span class="badge" style="background:rgba(93,112,82,0.15); color:#5D7052; font-weight:700; font-size:0.72rem; border-radius:50px; padding:0.35rem 0.75rem; border:1px solid rgba(93,112,82,0.3);">AKTIF</span>
                        @else
                            <span class="badge" style="background:rgba(168,84,72,0.15); color:#A85448; font-weight:700; font-size:0.72rem; border-radius:50px; padding:0.35rem 0.75rem; border:1px solid rgba(168,84,72,0.3);">{{ strtoupper($s->status) }}</span>
                        @endif
                    </td>
                    <td class="text-end" style="padding: 0.85rem 1.25rem;">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('santri.edit', $s->id) }}" class="neo-btn px-2 py-1"
                               style="font-size:0.75rem;" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('santri.destroy', $s->id) }}" method="POST"
                                  class="form-delete-santri">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="neo-btn px-2 py-1"
                                        style="font-size:0.75rem;color:var(--af-negative);" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                        Tidak ada santri
                        @if($filterKelas) di kelas <strong>{{ $filterKelas }}</strong>
                        @elseif($filterJenjang) di jenjang <strong>{{ $filterJenjang }}</strong>
                        @endif
                        @if($filterGender ?? false) ({{ $filterGender }}) @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($santris->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3"
         style="border-top: 1px solid var(--neo-border, #dde4ed);">
        <div class="text-muted small">
            Menampilkan {{ $santris->firstItem() }}–{{ $santris->lastItem() }}
            dari <strong>{{ $santris->total() }}</strong> santri
        </div>
        <div>
            {{-- Custom styled pagination --}}
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

{{-- ═══════════════════════════════════════
     MODAL KENAIKAN KELAS
═══════════════════════════════════════ --}}
<div class="modal fade" id="modalKenaikanKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content neo-card border-0" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-arrow-up-circle-fill me-2" style="color:var(--af-positive);"></i>
                        Proses Kenaikan Kelas
                    </h5>
                    <p class="text-muted small mb-0">Pilih kelas yang akan diproses, lalu tentukan aksinya</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- STEP 1: Pilih Kelas --}}
                <div id="step1">
                    <p class="fw-bold mb-3">Langkah 1 — Pilih Kelas yang Akan Diproses:</p>
                    <div class="alert alert-warning border-0 rounded-3 mb-4" style="background:#FFFBEB; color:#92400E; font-size: 0.85rem;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                            <div>
                                <strong>SOP Kenaikan Kelas:</strong><br>
                                Selalu proses <strong>kelas paling tinggi/akhir terlebih dahulu</strong> (contoh: Luluskan kelas 12, lalu naikkan kelas 11 ke 12, dst).<br>
                                Jika Anda menaikkan kelas bawah lebih dulu, data santri baru akan tercampur dengan santri lama di kelas atas, sehingga berpotensi salah lulus/salah pindah!
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small fw-bold mb-2">
                                <i class="bi bi-mortarboard me-1"></i>Jenjang MTs
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($kelasList->where('jenjang','MTs') as $kelas)
                                    @php $jumlah = $semuaSantriAktif->where('kelas',$kelas->nama_kelas)->count(); @endphp
                                    <button type="button" class="neo-btn btn-pilih-kelas px-4"
                                            data-kelas="{{ $kelas->nama_kelas }}"
                                            data-jenjang="{{ $kelas->jenjang }}"
                                            {{ $jumlah == 0 ? 'disabled' : '' }}
                                            style="{{ $jumlah == 0 ? 'opacity:0.4;' : '' }}">
                                        {{ $kelas->nama_kelas }}
                                        <span class="badge rounded-pill ms-1"
                                              style="background:var(--af-positive);color:white;font-size:0.65rem;">
                                            {{ $jumlah }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <p class="text-muted small fw-bold mb-2">
                                <i class="bi bi-mortarboard-fill me-1"></i>Jenjang MA
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($kelasList->where('jenjang','MA') as $kelas)
                                    @php $jumlah = $semuaSantriAktif->where('kelas',$kelas->nama_kelas)->count(); @endphp
                                    <button type="button" class="neo-btn btn-pilih-kelas px-4"
                                            data-kelas="{{ $kelas->nama_kelas }}"
                                            data-jenjang="{{ $kelas->jenjang }}"
                                            {{ $jumlah == 0 ? 'disabled' : '' }}
                                            style="{{ $jumlah == 0 ? 'opacity:0.4;' : '' }}">
                                        {{ $kelas->nama_kelas }}
                                        <span class="badge rounded-pill ms-1"
                                              style="background:#805AD5;color:white;font-size:0.65rem;">
                                            {{ $jumlah }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Konfirmasi & Aksi --}}
                <div id="step2" class="d-none">
                    <button type="button" class="btn btn-sm btn-link text-muted ps-0 mb-3" id="btnKembali">
                        <i class="bi bi-arrow-left me-1"></i> Pilih kelas lain
                    </button>
                    <div class="neo-card p-3 mb-4" id="infoKelasAsal"></div>
                    <form action="{{ route('santri.naik-kelas') }}" method="POST" id="formKenaikan">
                        @csrf
                        <input type="hidden" name="kelas_asal"   id="inputKelasAsal">
                        <input type="hidden" name="aksi"          id="inputAksi">
                        <input type="hidden" name="kelas_tujuan"  id="inputKelasTujuan">
                        <div id="santriCheckboxContainer"></div>
                        <div id="containerPilihAksi" class="mt-4"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const semuaSantri = @json($semuaSantriAktif->values());
const semuaKelas  = @json($kelasList->values());

const KELAS_LULUS_MTS = @json($kelasList->where('jenjang','MTs')->sortByDesc('nama_kelas')->first()?->nama_kelas ?? '');
const KELAS_LULUS_MA  = @json($kelasList->where('jenjang','MA')->sortByDesc('nama_kelas')->first()?->nama_kelas ?? '');

document.querySelectorAll('.btn-pilih-kelas').forEach(btn => {
    btn.addEventListener('click', function () {
        const kelasAsal = this.dataset.kelas;
        const jenjang   = this.dataset.jenjang;

        const santriDiKelas = semuaSantri.filter(s => s.kelas === kelasAsal);
        const isKelasAkhir  = (jenjang === 'MTs' && kelasAsal === KELAS_LULUS_MTS) ||
                              (jenjang === 'MA'  && kelasAsal === KELAS_LULUS_MA);

        const kelasSeJenjang = semuaKelas
            .filter(k => k.jenjang === jenjang)
            .sort((a, b) => a.nama_kelas.localeCompare(b.nama_kelas, undefined, { numeric: true }));

        const idxAsal = kelasSeJenjang.findIndex(k => k.nama_kelas === kelasAsal);
        const kelasTujuanObj = kelasSeJenjang[idxAsal + 1] ?? null;

        const warnaBadge = jenjang === 'MTs' ? '#3182CE' : '#805AD5';

        // Info card
        document.getElementById('infoKelasAsal').innerHTML = `
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-mortarboard-fill" style="font-size:1.8rem;color:${warnaBadge};"></i>
                <div>
                    <div class="fw-bold fs-5">${kelasAsal}
                        <span class="badge rounded-pill ms-1" style="background:${warnaBadge};color:white;font-size:0.7rem;">${jenjang}</span>
                    </div>
                    <div class="text-muted small">${santriDiKelas.length} santri aktif</div>
                </div>
            </div>`;

        document.getElementById('inputKelasAsal').value = kelasAsal;

        // Checkbox santri
        let checkboxHtml = `
            <p class="fw-bold small mb-2">Pilih santri yang diproses:</p>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="checkAll" onchange="toggleAll(this)">
                <label class="form-check-label fw-bold" for="checkAll">Pilih Semua (${santriDiKelas.length})</label>
            </div>
            <div class="border rounded p-2" style="max-height:200px;overflow-y:auto;background:#f8fafc;">`;

        let optionsHtml = '';
        kelasSeJenjang.forEach(k => {
            optionsHtml += `<option value="${k.nama_kelas}">${k.nama_kelas}</option>`;
        });

        santriDiKelas.forEach(s => {
            checkboxHtml += `
                <div class="form-check py-2 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <input class="form-check-input santri-check" type="checkbox"
                               name="santri_ids[]" value="${s.id}" id="sc_${s.id}" checked>
                        <label class="form-check-label" for="sc_${s.id}">
                            <span class="fw-bold">${s.nama}</span>
                            <span class="text-muted small ms-1">${s.kamar}</span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="btn_override_${s.id}" class="btn btn-sm btn-light text-muted p-1 px-2" onclick="toggleOverride(${s.id})" title="Bedakan Kelas Tujuan">
                            <i class="bi bi-shuffle"></i>
                        </button>
                        <div id="container_override_${s.id}" style="display:none;" class="d-flex align-items-center gap-1">
                            <select name="target_kelas[${s.id}]" id="override_select_${s.id}" class="form-select form-select-sm" style="width: 120px;" disabled>
                                ${optionsHtml}
                            </select>
                            <button type="button" class="btn btn-sm btn-outline-danger p-1 px-2" onclick="cancelOverride(${s.id})" title="Batal (Kembali ke teman lama)">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
        });
        checkboxHtml += `</div>`;
        document.getElementById('santriCheckboxContainer').innerHTML = checkboxHtml;

        let aksiHtml = `<p class="fw-bold small mb-3">Pilih Aksi Masal:</p><div class="d-flex flex-wrap gap-3">`;

        if (!isKelasAkhir && kelasTujuanObj) {
            // Dropdown untuk mengubah target kelas masal
            let mainOptionsHtml = '';
            kelasSeJenjang.forEach(k => {
                let isSelected = (k.nama_kelas === kelasTujuanObj.nama_kelas) ? 'selected' : '';
                mainOptionsHtml += `<option value="${k.nama_kelas}" ${isSelected}>${k.nama_kelas}</option>`;
            });

            aksiHtml += `
                <div class="d-flex align-items-center gap-2 bg-light p-2 rounded border border-light">
                    <span class="text-muted small fw-bold">Naik/Pindah Masal ke:</span>
                    <select id="main_target_kelas" class="form-select form-select-sm" style="width: 130px;">
                        ${mainOptionsHtml}
                    </select>
                    <button type="button" class="neo-btn neo-btn-primary px-3 py-1 m-0"
                            onclick="submitAksi('naik', document.getElementById('main_target_kelas').value)">
                        <i class="bi bi-arrow-up-circle-fill me-1"></i> Proses
                    </button>
                </div>`;
        }

        aksiHtml += `
            <button type="button" class="neo-btn px-4" style="color:#E53E3E;"
                    onclick="submitAksi('lulus','')">
                <i class="bi bi-patch-check-fill me-2"></i>
                Nyatakan <strong>Lulus</strong>
            </button></div>`;

        if (isKelasAkhir) {
            aksiHtml = `
                <div class="alert border-0 rounded-3 mb-3" style="background:#FFF5F5;color:#742A2A;">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Kelas ${kelasAsal}</strong> adalah kelas akhir jenjang ${jenjang}.
                    ${ jenjang === 'MTs'
                        ? 'Santri lulus <strong>tidak otomatis masuk MA</strong> — harus mendaftar ulang sebagai santri baru.'
                        : 'Santri yang lulus dinyatakan selesai dari pesantren.' }
                </div>` + aksiHtml;
        }

        document.getElementById('containerPilihAksi').innerHTML = aksiHtml;
        document.getElementById('step1').classList.add('d-none');
        document.getElementById('step2').classList.remove('d-none');
    });
});

document.getElementById('btnKembali').addEventListener('click', () => {
    document.getElementById('step2').classList.add('d-none');
    document.getElementById('step1').classList.remove('d-none');
});

function toggleAll(el) {
    document.querySelectorAll('.santri-check').forEach(c => c.checked = el.checked);
}

function toggleOverride(id) {
    const btn = document.getElementById('btn_override_' + id);
    const container = document.getElementById('container_override_' + id);
    const sel = document.getElementById('override_select_' + id);
    
    btn.style.display = 'none';
    container.style.display = 'flex';
    sel.disabled = false;
    
    // Set default value-nya ke dropdown target masal jika ada
    const mainTarget = document.getElementById('main_target_kelas');
    if(mainTarget && mainTarget.value) {
        sel.value = mainTarget.value;
    } else {
        const inputTujuan = document.getElementById('inputKelasTujuan').value;
        if(inputTujuan) sel.value = inputTujuan;
    }
}

function cancelOverride(id) {
    const btn = document.getElementById('btn_override_' + id);
    const container = document.getElementById('container_override_' + id);
    const sel = document.getElementById('override_select_' + id);
    
    container.style.display = 'none';
    btn.style.display = 'block';
    sel.disabled = true;
    sel.value = ''; // Reset nilai
}

function submitAksi(aksi, kelasTujuan) {
    const checked = document.querySelectorAll('.santri-check:checked');
    if (checked.length === 0) { 
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Pilih minimal 1 santri!',
            background: 'var(--bg)',
            color: 'var(--fg)',
            customClass: { confirmButton: 'neo-btn neo-btn-primary px-4' },
            buttonsStyling: false
        });
        return; 
    }
    const msg = aksi === 'lulus'
        ? `Nyatakan ${checked.length} santri sebagai LULUS?`
        : `Naikkan ${checked.length} santri ke kelas ${kelasTujuan}?`;
        
    Swal.fire({
        title: 'Konfirmasi Aksi',
        text: msg,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal',
        background: 'var(--bg)',
        color: 'var(--fg)',
        customClass: {
            popup: 'neo-card',
            confirmButton: 'neo-btn neo-btn-primary px-4',
            cancelButton: 'neo-btn px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('inputAksi').value = aksi;
            document.getElementById('inputKelasTujuan').value = kelasTujuan;
            
            // Sinkronkan default kelas tujuan ke dropdown yang terlihat (tapi belum diset value-nya)
            document.querySelectorAll('select[name^="target_kelas"]').forEach(sel => {
                if (!sel.disabled && (!sel.value || sel.value === '')) {
                    sel.value = kelasTujuan;
                }
            });

            document.getElementById('formKenaikan').submit();
        }
    });
}

// SweetAlert2 for Delete Confirmation
document.querySelectorAll('.form-delete-santri').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Santri?',
            text: "Data santri yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: 'var(--bg)',
            color: 'var(--fg)',
            customClass: {
                popup: 'neo-card border-0',
                confirmButton: 'neo-btn neo-btn-danger px-4',
                cancelButton: 'neo-btn px-4'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
