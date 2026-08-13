@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="color: var(--af-positive);">
        <i class="bi bi-gear-fill me-2"></i>Pengaturan Sistem
    </h3>
    <p class="text-muted mb-0">Pusat kendali parameter evaluasi, identitas pesantren, dan master data</p>
</div>

{{-- ===== TAB NAVIGATION ===== --}}
<div class="neo-card p-2 mb-4">
    <div class="d-flex gap-2" style="overflow-x: auto; scrollbar-width: none; -ms-overflow-style: none;">
        <style>
            .setting-tabs-container::-webkit-scrollbar { display: none; }
        </style>
        <div class="d-flex gap-2 w-100 setting-tabs-container">
            <a href="{{ route('setting.index', ['tab' => 'sistem']) }}"
               class="neo-btn {{ $activeTab == 'sistem' ? 'neo-btn-primary' : '' }} text-nowrap px-4 flex-fill text-center"
               style="{{ $activeTab != 'sistem' ? 'color: var(--af-dark);' : '' }}">
                <i class="bi bi-sliders me-1"></i> Parameter Sistem
            </a>
            <a href="{{ route('setting.index', ['tab' => 'kelas_kamar']) }}"
               class="neo-btn {{ in_array($activeTab, ['kelas_kamar', 'kelas', 'kamar']) ? 'neo-btn-primary' : '' }} text-nowrap px-4 flex-fill text-center"
               style="{{ !in_array($activeTab, ['kelas_kamar', 'kelas', 'kamar']) ? 'color: var(--af-dark);' : '' }}">
                <i class="bi bi-door-open me-1"></i> Kelas & Kamar
                @if(($kelasList->count() + $kamarList->count()) > 0)
                    <span class="badge rounded-pill ms-1" style="background: {{ in_array($activeTab, ['kelas_kamar', 'kelas', 'kamar']) ? 'rgba(255,255,255,0.4)' : 'var(--af-positive)' }}; color: white; font-size: 0.7rem;">
                        {{ $kelasList->count() + $kamarList->count() }}
                    </span>
                @endif
            </a>
            <a href="{{ route('setting.index', ['tab' => 'pengajian']) }}"
               class="neo-btn {{ $activeTab == 'pengajian' ? 'neo-btn-primary' : '' }} text-nowrap px-4 flex-fill text-center"
               style="{{ $activeTab != 'pengajian' ? 'color: var(--af-dark);' : '' }}">
                <i class="bi bi-book me-1"></i> Wali Kelas & Pengajian
            </a>
        </div>
    </div>
</div>

{{-- ===== TAB: PARAMETER SISTEM & IDENTITAS ===== --}}
@if($activeTab == 'sistem')
<div class="row g-4">
    <div class="col-md-12">
        <div class="neo-card">
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h5 class="fw-bold mb-3 border-bottom pb-2">Kriteria & Parameter Penilaian Kedisiplinan</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ambang Batas Disiplin (%)</label>
                        <input type="number" name="fc_tinggi" class="form-control neo-input" value="{{ old('fc_tinggi', $fcTinggi) }}" min="0" max="100" required>
                        <small class="text-muted">Standar minimum persentase kategori "Disiplin" (default: 90%)</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ambang Batas Cukup Disiplin (%)</label>
                        <input type="number" name="fc_sedang" class="form-control neo-input" value="{{ old('fc_sedang', $fcSedang) }}" min="0" max="100" required>
                        <small class="text-muted">Standar minimum persentase kategori "Cukup Disiplin" (default: 75%)</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total Efektif Pertemuan</label>
                        <input type="number" name="hari_efektif" class="form-control neo-input" value="{{ old('hari_efektif', $hariEfektif ?? 30) }}" min="1" required>
                        <small class="text-muted">Total akumulasi pertemuan seluruh mata pelajaran per bulan (sebagai pembagi persentase)</small>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2">Identitas Instansi (Kop Surat Laporan)</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Nama Yayasan</label>
                        <input type="text" name="nama_yayasan_id" class="form-control neo-input" value="{{ old('nama_yayasan_id', $namaYayasanId) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Pondok (Indonesia)</label>
                        <input type="text" name="nama_pondok_id" class="form-control neo-input" value="{{ old('nama_pondok_id', $namaPondokId) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Pondok (Arab)</label>
                        <input type="text" name="nama_pondok_ar" class="form-control neo-input fs-5" dir="rtl" style="font-family: 'Amiri', 'Traditional Arabic', serif;" value="{{ old('nama_pondok_ar', $namaPondokAr) }}" required>
                        <small class="text-muted">Gunakan keyboard Arab. Teks akan tampil dari kanan-ke-kiri.</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control neo-input" rows="2" required>{{ old('alamat_lengkap', $alamatLengkap) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Telepon</label>
                        <input type="text" name="telepon" class="form-control neo-input" value="{{ old('telepon', $telepon) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control neo-input" value="{{ old('email', $email) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Logo Pondok / Yayasan</label>
                        <div class="mb-3">
                            <img id="logoPreview" src="{{ $logoPath ? asset($logoPath) . '?v=' . time() : '#' }}" alt="Logo Preview" style="height: 80px; object-fit: contain; display: {{ $logoPath ? 'block' : 'none' }}; border: 1px solid #e2e8f0; padding: 5px; border-radius: 5px; background: white;">
                        </div>
                        <input type="file" id="logoInput" name="logo_path" class="form-control neo-input" accept="image/*" onchange="previewLogo(event)">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG, PNG, max 2MB.</small>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="neo-btn neo-btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ===== TAB: MANAJEMEN KELAS & KAMAR (DISATUKAN) ===== --}}
@if(in_array($activeTab, ['kelas_kamar', 'kelas', 'kamar']))
<div class="row g-4">

    {{-- KANAN / KIRI 1: MANAJEMEN KELAS --}}
    <div class="col-md-6">
        <div class="neo-card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-mortarboard-fill me-2" style="color: var(--af-positive);"></i>Manajemen Kelas ({{ $kelasList->count() }})</h6>
            
            {{-- Form Tambah Kelas --}}
            <form action="{{ route('kelas.store') }}" method="POST" class="p-3 mb-4 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px dashed var(--border);">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-7">
                        <input type="text" name="nama_kelas" class="form-control neo-input" placeholder="Nama Kelas (cth: VII A)..." required>
                    </div>
                    <div class="col-5">
                        <select name="jenjang" class="form-select neo-input" required>
                            <option value="MTs">MTs</option>
                            <option value="MA">MA</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="neo-btn neo-btn-primary w-100 py-1" style="font-size: 0.82rem;">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Kelas
                        </button>
                    </div>
                </div>
            </form>

            {{-- Table Kelas --}}
            @if($kelasList->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                    <small>Belum ada kelas terdaftar.</small>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                        <thead style="background: rgba(0,0,0,0.02);">
                            <tr>
                                <th class="ps-3">Nama Kelas</th>
                                <th class="text-center">Jenjang</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelasList as $kelas)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $kelas->nama_kelas }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-2 py-1" style="background: {{ $kelas->jenjang == 'MTs' ? '#3182ce' : '#9f7aea' }}; color: white; font-size: 0.7rem;">
                                        {{ $kelas->jenjang }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning border-0 p-1 me-1" onclick="editKelas({{ $kelas->id }}, '{{ addslashes($kelas->nama_kelas) }}', '{{ $kelas->jenjang }}')" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" class="d-inline form-delete-setting" data-confirm-msg="Hapus kelas '{{ addslashes($kelas->nama_kelas) }}'?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- KANAN / KIRI 2: MANAJEMEN KAMAR --}}
    <div class="col-md-6">
        <div class="neo-card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-door-open-fill me-2" style="color: var(--af-positive);"></i>Manajemen Kamar ({{ $kamarList->count() }})</h6>
            
            {{-- Form Tambah Kamar --}}
            <form action="{{ route('kamar.store') }}" method="POST" class="p-3 mb-4 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px dashed var(--border);">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-7">
                        <input type="text" name="nama_kamar" class="form-control neo-input" placeholder="Nama Kamar (cth: Al-Fatih)..." required>
                    </div>
                    <div class="col-5">
                        <input type="number" name="kapasitas" class="form-control neo-input" placeholder="Kapasitas..." min="1" max="999" required>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="neo-btn neo-btn-primary w-100 py-1" style="font-size: 0.82rem;">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Kamar
                        </button>
                    </div>
                </div>
            </form>

            {{-- Table Kamar --}}
            @if($kamarList->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                    <small>Belum ada kamar terdaftar.</small>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                        <thead style="background: rgba(0,0,0,0.02);">
                            <tr>
                                <th class="ps-3">Nama Kamar</th>
                                <th class="text-center">Kapasitas</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kamarList as $kamar)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $kamar->nama_kamar }}</td>
                                <td class="text-center">
                                    @php
                                        $sisa = $kamar->kapasitas - $kamar->santris_count;
                                        $isFull = $sisa <= 0;
                                    @endphp
                                    @if($isFull)
                                        <span class="badge rounded-pill px-2 py-1" style="background: var(--af-danger, #e53e3e); color: white; font-size: 0.7rem;" title="Kapasitas penuh ({{ $kamar->kapasitas }} org)">
                                            <i class="bi bi-x-circle-fill me-1"></i>Max
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-2 py-1" style="background: #718096; color: white; font-size: 0.7rem;" title="Terisi {{ $kamar->santris_count }} dari {{ $kamar->kapasitas }} org">
                                            <i class="bi bi-people-fill me-1"></i>Sisa {{ $sisa }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning border-0 p-1 me-1" onclick="editKamar({{ $kamar->id }}, '{{ addslashes($kamar->nama_kamar) }}', {{ $kamar->kapasitas }})" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="d-inline form-delete-setting" data-confirm-msg="Hapus kamar '{{ addslashes($kamar->nama_kamar) }}'?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Modal Edit Kelas --}}
<div class="modal fade" id="editKelasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 1.25rem; background: white; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKelasForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="editNamaKelas" class="form-control neo-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenjang</label>
                        <select name="jenjang" id="editJenjangKelas" class="form-select neo-input" required>
                            <option value="MTs">MTs</option>
                            <option value="MA">MA</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="neo-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="neo-btn neo-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Kamar --}}
<div class="modal fade" id="editKamarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 1.25rem; background: white; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKamarForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kamar</label>
                        <input type="text" name="nama_kamar" id="editNamaKamar" class="form-control neo-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kapasitas (orang)</label>
                        <input type="number" name="kapasitas" id="editKapasitasKamar" class="form-control neo-input" min="1" max="999" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="neo-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="neo-btn neo-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ===== TAB: MANAJEMEN WALI KELAS & PENGAJIAN ===== --}}
@if($activeTab == 'pengajian')
@php
    $listWali = array_filter(array_map('trim', explode(',', $listWaliKelas)));
    $listPengajian = array_filter(array_map('trim', explode(',', $listRuangPengajian)));
@endphp
<div class="row g-4">
    {{-- Manajemen Wali Kelas --}}
    <div class="col-md-6">
        <div class="neo-card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2" style="color: var(--af-positive);"></i>Manajemen Wali Kelas</h6>
            <form action="{{ route('setting.list.store') }}" method="POST" class="mb-4 d-flex gap-2">
                @csrf
                <input type="hidden" name="key" value="list_wali_kelas">
                <input type="text" name="value" class="form-control neo-input" placeholder="Nama Wali Kelas Baru..." required>
                <button type="submit" class="btn btn-sm text-white" style="background: var(--af-positive); min-width: 90px;">Tambah</button>
            </form>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead style="background: rgba(0,0,0,0.02);">
                        <tr>
                            <th class="ps-3">Nama Wali Kelas</th>
                            <th class="text-center" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listWali as $w)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $w }}</td>
                            <td class="text-center">
                                <form action="{{ route('setting.list.destroy') }}" method="POST" class="form-delete-setting" data-confirm-msg="Hapus Wali Kelas '{{ $w }}'?">
                                    @csrf
                                    <input type="hidden" name="key" value="list_wali_kelas">
                                    <input type="hidden" name="value" value="{{ $w }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted">Belum ada Wali Kelas terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Manajemen Ruang Pengajian --}}
    <div class="col-md-6">
        <div class="neo-card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-book-half me-2" style="color: var(--af-positive);"></i>Daftar Ruang Pengajian</h6>
            <form action="{{ route('setting.list.store') }}" method="POST" class="mb-4 d-flex gap-2">
                @csrf
                <input type="hidden" name="key" value="list_ruang_pengajian">
                <input type="text" name="value" class="form-control neo-input" placeholder="Nama Ruang Pengajian Baru..." required>
                <button type="submit" class="btn btn-sm text-white" style="background: var(--af-positive); min-width: 90px;">Tambah</button>
            </form>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead style="background: rgba(0,0,0,0.02);">
                        <tr>
                            <th class="ps-3">Nama Ruang Pengajian</th>
                            <th class="text-center" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listPengajian as $p)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $p }}</td>
                            <td class="text-center">
                                <form action="{{ route('setting.list.destroy') }}" method="POST" class="form-delete-setting" data-confirm-msg="Hapus Ruang Pengajian '{{ $p }}'?">
                                    @csrf
                                    <input type="hidden" name="key" value="list_ruang_pengajian">
                                    <input type="hidden" name="value" value="{{ $p }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted">Belum ada Ruang Pengajian terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<script>
function previewLogo(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('logoPreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

function editKelas(id, namaKelas, jenjang) {
    document.getElementById('editNamaKelas').value = namaKelas;
    document.getElementById('editJenjangKelas').value = jenjang;
    document.getElementById('editKelasForm').action = '/kelas/' + id;
    var modal = new bootstrap.Modal(document.getElementById('editKelasModal'));
    modal.show();
}

function editKamar(id, namaKamar, kapasitas) {
    document.getElementById('editNamaKamar').value = namaKamar;
    document.getElementById('editKapasitasKamar').value = kapasitas;
    document.getElementById('editKamarForm').action = '/kamar/' + id;
    var modal = new bootstrap.Modal(document.getElementById('editKamarModal'));
    modal.show();
}

document.querySelectorAll('.form-delete-setting').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = this.getAttribute('data-confirm-msg');
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: msg,
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
