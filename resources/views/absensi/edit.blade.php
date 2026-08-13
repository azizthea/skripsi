@extends('layouts.app')

@section('content')
<!-- Tombol Navigasi Kembali -->
<div class="mb-4">
    <a href="{{ route('absensi.index') }}" class="neo-btn me-3 px-3 py-2 text-decoration-none" style="font-size: 0.9rem;">&larr; Kembali</a>
</div>

<!-- Form Edit Data Absensi -->
<div class="neo-card">
    <h4 class="fw-bold mb-1" style="color: var(--af-positive);">
        <i class="bi bi-pencil-square me-2"></i>Edit Data Absensi
    </h4>
    <p class="text-muted mb-4">Ubah data kehadiran santri</p>

    @if($errors->any())
        <div class="alert bg-danger text-white rounded-3 mb-4 border-0">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="santri_id">Santri</label>
                <select name="santri_id" id="santri_id" class="form-select neo-input" required>
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santris as $santri)
                        <option value="{{ $santri->id }}" {{ (old('santri_id', $absensi->santri_id)) == $santri->id ? 'selected' : '' }}>
                            {{ $santri->nama }} — {{ $santri->kelas }} ({{ $santri->kamar }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control neo-input" value="{{ old('tanggal', $absensi->tanggal->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-6">
                <label for="jenis_kegiatan">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-select neo-input" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    <optgroup label="📖 Pengajian">
                        <option value="Al-Quran"         {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Al-Quran'         ? 'selected' : '' }}>📖 Al-Quran</option>
                        <option value="Fiqih"            {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Fiqih'            ? 'selected' : '' }}>📖 Fiqih</option>
                        <option value="Tafsir"           {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Tafsir'           ? 'selected' : '' }}>📖 Tafsir</option>
                        <option value="Hadits"           {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Hadits'           ? 'selected' : '' }}>📖 Hadits</option>
                        <option value="Akhlak"           {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Akhlak'           ? 'selected' : '' }}>📖 Akhlak</option>
                        <option value="Bahasa Arab"      {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Bahasa Arab'      ? 'selected' : '' }}>📖 Bahasa Arab</option>
                    </optgroup>
                    <optgroup label="🎓 Sekolah">
                        <option value="Matematika"       {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Matematika'       ? 'selected' : '' }}>🎓 Matematika</option>
                        <option value="Bahasa Indonesia" {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Bahasa Indonesia' ? 'selected' : '' }}>🎓 Bahasa Indonesia</option>
                        <option value="Bahasa Inggris"   {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'Bahasa Inggris'   ? 'selected' : '' }}>🎓 Bahasa Inggris</option>
                        <option value="IPA"              {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'IPA'              ? 'selected' : '' }}>🎓 IPA</option>
                        <option value="IPS"              {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'IPS'              ? 'selected' : '' }}>🎓 IPS</option>
                        <option value="PKn"              {{ old('jenis_kegiatan', $absensi->jenis_kegiatan) == 'PKn'              ? 'selected' : '' }}>🎓 PKn</option>
                    </optgroup>
                </select>
            </div>

            <div class="col-md-6">
                <label for="status">Status Kehadiran</label>
                <select name="status" id="status" class="form-select neo-input" required>
                    <option value="Hadir" {{ old('status', $absensi->status) == 'Hadir' ? 'selected' : '' }}>✅ Hadir</option>
                    <option value="Izin" {{ old('status', $absensi->status) == 'Izin' ? 'selected' : '' }}>📝 Izin</option>
                    <option value="Sakit" {{ old('status', $absensi->status) == 'Sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                    <option value="Alpa" {{ old('status', $absensi->status) == 'Alpa' ? 'selected' : '' }}>❌ Alpa</option>
                </select>
            </div>
        </div>

        <!-- Tombol Update / Batal -->
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="neo-btn neo-btn-primary">
                <i class="bi bi-check-lg me-1"></i> Update Data Absensi
            </button>
            <a href="{{ route('absensi.index') }}" class="neo-btn">Batal</a>
        </div>
    </form>
</div>
@endsection
