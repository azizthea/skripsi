@extends('layouts.app')

@section('content')
<!-- Header & Navigation -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--af-positive);">
            <i class="bi bi-person-plus me-2"></i>Registrasi Santri Baru
        </h3>
        <p class="text-muted mb-0">Tambahkan data santri baru ke dalam sistem.</p>
    </div>
    <a href="{{ route('santri.index') }}" class="neo-btn">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Form Registrasi Santri Baru -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="neo-card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Form Data Santri</h5>

            <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Identitas Dasar (NIS & Nama) -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor Induk Santri (NIS) <small class="text-muted fw-normal">(Opsional)</small></label>
                        <input type="text" name="nis" class="form-control neo-input" placeholder="Contoh: 123456789">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control neo-input" required placeholder="Contoh: Ahmad Fauzi">
                    </div>
                </div>

                <!-- Gender & Jenjang Pendidikan -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select neo-input" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Putra">Putra</option>
                            <option value="Putri">Putri</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenjang <span class="text-danger">*</span></label>
                        <select name="jenjang" class="form-select neo-input" required>
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="MTs">MTs (Menengah Pertama)</option>
                            <option value="MA">MA (Menengah Atas)</option>
                        </select>
                    </div>
                </div>

                <!-- Penempatan Kamar & Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kamar <small class="text-muted fw-normal">(Opsional)</small></label>
                        <select name="kamar" class="form-select neo-input">
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($kamarList as $kamar)
                                @php
                                    $sisa = $kamar->kapasitas - $kamar->santris_count;
                                @endphp
                                @if($sisa > 0)
                                    <option value="{{ $kamar->nama_kamar }}">{{ $kamar->nama_kamar }} (Sisa: {{ $sisa }})</option>
                                @else
                                    <option value="{{ $kamar->nama_kamar }}" disabled>{{ $kamar->nama_kamar }} (Penuh)</option>
                                @endif
                            @endforeach
                        </select>
                        @if($kamarList->isEmpty())
                            <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>Belum ada kamar. Tambahkan di <a href="{{ route('setting.index', ['tab'=>'kamar']) }}">Pengaturan</a>.</small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select neo-input" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="lulus">Lulus</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>
                </div>

                <!-- Upload Foto Profil -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Foto Profil <small class="text-muted">(Opsional)</small></label>
                    <input type="file" name="foto" class="form-control neo-input" accept="image/jpeg,image/png,image/jpg">
                    <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</div>
                </div>

                <!-- Tombol Submit Form -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="neo-btn neo-btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Data Santri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
