@extends('layouts.app')

@section('content')
<!-- Tombol Navigasi Kembali -->
<div class="mb-4">
    <a href="{{ route('absensi.index') }}" class="neo-btn me-3 px-3 py-2 text-decoration-none" style="font-size: 0.9rem;">&larr; Kembali</a>
</div>

<!-- Form Input Data Absensi -->
<div class="neo-card">
    <h4 class="fw-bold mb-1" style="color: var(--af-positive);">
        <i class="bi bi-plus-circle me-2"></i>Tambah Data Absensi
    </h4>
    <p class="text-muted mb-4">Input data kehadiran santri pada kegiatan Pengajian atau Sekolah</p>

    @if($errors->any())
        <div class="alert bg-danger text-white rounded-3 mb-4 border-0">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <!-- 0. Pilih Jenis Absensi -->
            <div class="col-md-12">
                <label class="form-label fw-bold">Pilih Kategori Input Absensi</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kategori_input" id="kat_sekolah" value="sekolah" checked>
                        <label class="form-check-label" for="kat_sekolah">Sekolah (Filter berdasarkan Kelas)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kategori_input" id="kat_pengajian" value="pengajian">
                        <label class="form-check-label" for="kat_pengajian">Pengajian (Filter berdasarkan Ruang Pengajian)</label>
                    </div>
                </div>
            </div>

            <!-- 1. Filter Tingkat Sekolah (Hanya tampil jika Kategori = Sekolah) -->
            <div class="col-md-4" id="wrap_sekolah">
                <label for="sekolah_filter">Tingkat Sekolah</label>
                <select id="sekolah_filter" class="form-select neo-input">
                    <option value="">-- Pilih Sekolah --</option>
                    <option value="MTs">MTs (SMP)</option>
                    <option value="MA">MA (SMA)</option>
                </select>
            </div>

            <!-- 2. Filter Kelas (Hanya tampil jika Kategori = Sekolah) -->
            <div class="col-md-4" id="wrap_kelas">
                <label for="kelas_filter">Kelas</label>
                <select id="kelas_filter" class="form-select neo-input" disabled>
                    <option value="">-- Pilih Kelas --</option>
                </select>
            </div>

            <!-- 2b. Filter Ruang Pengajian (Hanya tampil jika Kategori = Pengajian) -->
            <div class="col-md-8" id="wrap_pengajian" style="display: none;">
                <label for="ruang_filter">Ruang Pengajian</label>
                <select id="ruang_filter" class="form-select neo-input">
                    <option value="">-- Pilih Ruang Pengajian --</option>
                    {{-- Diisi JS --}}
                </select>
            </div>

            <!-- 3. Pilih Santri -->
            <div class="col-md-4">
                <label for="santri_id">Nama Santri <span class="text-danger">*</span></label>
                <select name="santri_id" id="santri_id" class="form-select neo-input" required disabled>
                    <option value="">-- Pilih Santri --</option>
                    {{-- Opsi akan diisi oleh JavaScript --}}
                </select>
            </div>

            <div class="col-md-4">
                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" id="tanggal" class="form-control neo-input" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4">
                <label for="jenis_kegiatan">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-select neo-input" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    <optgroup label="📖 Pengajian">
                        <option value="Al-Quran"         {{ old('jenis_kegiatan') == 'Al-Quran'         ? 'selected' : '' }}>📖 Al-Quran</option>
                        <option value="Fiqih"            {{ old('jenis_kegiatan') == 'Fiqih'            ? 'selected' : '' }}>📖 Fiqih</option>
                        <option value="Tafsir"           {{ old('jenis_kegiatan') == 'Tafsir'           ? 'selected' : '' }}>📖 Tafsir</option>
                        <option value="Hadits"           {{ old('jenis_kegiatan') == 'Hadits'           ? 'selected' : '' }}>📖 Hadits</option>
                        <option value="Akhlak"           {{ old('jenis_kegiatan') == 'Akhlak'           ? 'selected' : '' }}>📖 Akhlak</option>
                        <option value="Bahasa Arab"      {{ old('jenis_kegiatan') == 'Bahasa Arab'      ? 'selected' : '' }}>📖 Bahasa Arab</option>
                    </optgroup>
                    <optgroup label="🎓 Sekolah">
                        <option value="Matematika"       {{ old('jenis_kegiatan') == 'Matematika'       ? 'selected' : '' }}>🎓 Matematika</option>
                        <option value="Bahasa Indonesia" {{ old('jenis_kegiatan') == 'Bahasa Indonesia' ? 'selected' : '' }}>🎓 Bahasa Indonesia</option>
                        <option value="Bahasa Inggris"   {{ old('jenis_kegiatan') == 'Bahasa Inggris'   ? 'selected' : '' }}>🎓 Bahasa Inggris</option>
                        <option value="IPA"              {{ old('jenis_kegiatan') == 'IPA'              ? 'selected' : '' }}>🎓 IPA</option>
                        <option value="IPS"              {{ old('jenis_kegiatan') == 'IPS'              ? 'selected' : '' }}>🎓 IPS</option>
                        <option value="PKn"              {{ old('jenis_kegiatan') == 'PKn'              ? 'selected' : '' }}>🎓 PKn</option>
                    </optgroup>
                </select>
            </div>

            <div class="col-md-4">
                <label for="status">Status Kehadiran <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select neo-input" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>✅ Hadir</option>
                    <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>📝 Izin</option>
                    <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                    <option value="Alpa" {{ old('status') == 'Alpa' ? 'selected' : '' }}>❌ Alpa</option>
                </select>
            </div>
        </div>

        <!-- Tombol Aksi Simpan / Batal -->
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="neo-btn neo-btn-primary">
                <i class="bi bi-check-lg me-1"></i> Simpan Data Absensi
            </button>
            <a href="{{ route('absensi.index') }}" class="neo-btn">Batal</a>
        </div>
    </form>
</div>

<!-- Script Filter Dinamis & Auto Populate Santri -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data santri dari backend
        const santris = @json($santris);

        // ===================================================================
        // INTEGRASI MASTER DATA KELAS
        // Data kelas diambil langsung dari tabel 'classes' (master Pengaturan).
        // Perubahan kelas di Pengaturan Sistem langsung tercermin di sini.
        // ===================================================================
        const masterKelas = @json($kelasList);
        
        const sekolahSelect = document.getElementById('sekolah_filter');
        const kelasSelect   = document.getElementById('kelas_filter');
        const ruangSelect   = document.getElementById('ruang_filter');
        const santriSelect  = document.getElementById('santri_id');
        const jenisSelect   = document.getElementById('jenis_kegiatan');
        
        const wrapSekolah   = document.getElementById('wrap_sekolah');
        const wrapKelas     = document.getElementById('wrap_kelas');
        const wrapPengajian = document.getElementById('wrap_pengajian');
        const radios        = document.querySelectorAll('input[name="kategori_input"]');

        // Extract daftar ruang pengajian dari data santri
        const ruangSet = new Set();
        santris.forEach(s => {
            if (s.ruang_pengajian) ruangSet.add(s.ruang_pengajian);
        });
        const ruangList = Array.from(ruangSet).sort();
        ruangList.forEach(r => {
            let opt = document.createElement('option');
            opt.value = r;
            opt.textContent = r;
            ruangSelect.appendChild(opt);
        });

        // Switch Kategori Input
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                santriSelect.innerHTML = '<option value="">-- Pilih Santri --</option>';
                santriSelect.disabled = true;
                
                if (this.value === 'sekolah') {
                    wrapSekolah.style.display = 'block';
                    wrapKelas.style.display = 'block';
                    wrapPengajian.style.display = 'none';
                    sekolahSelect.value = '';
                    kelasSelect.value = '';
                    kelasSelect.disabled = true;
                } else {
                    wrapSekolah.style.display = 'none';
                    wrapKelas.style.display = 'none';
                    wrapPengajian.style.display = 'block';
                    ruangSelect.value = '';
                }
            });
        });

        // ==========================================
        // EVENT: SAAT TINGKAT SEKOLAH DIPILIH
        // ==========================================
        sekolahSelect.addEventListener('change', function() {
            kelasSelect.innerHTML  = '<option value="">-- Pilih Kelas --</option>';
            santriSelect.innerHTML = '<option value="">-- Pilih Santri --</option>';
            santriSelect.disabled  = true;

            const selectedJenjang = this.value;
            if (selectedJenjang) {
                const kelasTersedia = masterKelas.filter(k => k.jenjang === selectedJenjang);
                kelasTersedia.forEach(k => {
                    let opt = document.createElement('option');
                    opt.value       = k.nama_kelas;
                    opt.textContent = k.nama_kelas;
                    kelasSelect.appendChild(opt);
                });
                kelasSelect.disabled = (kelasTersedia.length === 0);
            } else {
                kelasSelect.disabled = true;
            }
        });

        // ==========================================
        // EVENT: SAAT KELAS DIPILIH (Sekolah)
        // ==========================================
        kelasSelect.addEventListener('change', function() {
            populateSantri(this.value, 'kelas');
        });

        // ==========================================
        // EVENT: SAAT RUANG PENGAJIAN DIPILIH
        // ==========================================
        ruangSelect.addEventListener('change', function() {
            populateSantri(this.value, 'ruang');
        });

        function populateSantri(filterValue, filterType) {
            santriSelect.innerHTML = '<option value="">-- Pilih Santri --</option>';
            if (filterValue) {
                const filteredSantri = santris.filter(s => {
                    if (filterType === 'kelas') return s.kelas === filterValue;
                    if (filterType === 'ruang') return s.ruang_pengajian === filterValue;
                    return false;
                });
                
                filteredSantri.forEach(s => {
                    let opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.nama + ' — (Kamar: ' + (s.kamar || '-') + ')';
                    santriSelect.appendChild(opt);
                });
                santriSelect.disabled = (filteredSantri.length === 0);
            } else {
                santriSelect.disabled = true;
            }
        }
        
        // ==========================================
        // MEMPERTAHANKAN PILIHAN JIKA ADA ERROR VALIDASI
        // ==========================================
        const oldSantriId = "{{ old('santri_id') }}";
        if (oldSantriId) {
            const oldSantri = santris.find(s => s.id == oldSantriId);
            if (oldSantri) {
                // Tentukan kategori mana yang aktif
                const isPengajian = document.getElementById('kat_pengajian').checked;
                
                if (isPengajian) {
                    ruangSelect.value = oldSantri.ruang_pengajian;
                    ruangSelect.dispatchEvent(new Event('change'));
                } else {
                    const masterK = masterKelas.find(k => k.nama_kelas === oldSantri.kelas);
                    const jenjang = masterK ? masterK.jenjang : '';
                    sekolahSelect.value = jenjang;
                    sekolahSelect.dispatchEvent(new Event('change'));
                    setTimeout(() => {
                        kelasSelect.value = oldSantri.kelas;
                        kelasSelect.dispatchEvent(new Event('change'));
                    }, 50);
                }
                
                setTimeout(() => {
                    santriSelect.value = oldSantriId;
                }, 100);
            }
        }
    });
</script>
@endsection
