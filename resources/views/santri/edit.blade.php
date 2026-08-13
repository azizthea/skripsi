@extends('layouts.app')

@section('content')
<!-- Header & Navigasi Kembali -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--af-positive);">
            <i class="bi bi-pencil-square me-2"></i>Edit Data Santri
        </h3>
        <p class="text-muted mb-0">Ubah profil dan status santri: <strong>{{ $santri->nama }}</strong></p>
    </div>
    <a href="{{ route('santri.index') }}" class="neo-btn">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="neo-card p-4">
            <form action="{{ route('santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Foto Profil Santri -->
                <div class="mb-4 text-center">
                    @if($santri->foto)
                        <img id="fotoPreview" src="{{ asset('storage/' . $santri->foto) }}?v={{ time() }}" alt="Foto" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--af-positive);">
                    @else
                        <img id="fotoPreview" src="https://ui-avatars.com/api/?name={{ urlencode($santri->nama) }}&background=E2E8F0&color=2D3748" alt="Avatar" class="rounded-circle mb-3" style="width: 100px; height: 100px; border: 3px solid #E2E8F0;">
                    @endif
                    <div>
                        <label class="form-label fw-bold d-block">Ubah Foto Profil</label>
                        <input type="file" name="foto" id="fotoInput" class="form-control neo-input form-control-sm mx-auto" style="max-width: 300px;" accept="image/jpeg,image/png,image/jpg" onchange="previewFoto(event)">
                        <div class="form-text mt-1">Kosongkan jika tidak ingin mengubah foto.</div>
                    </div>
                </div>

                <!-- Identitas Dasar (NIS & Nama) -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor Induk Santri (NIS) <small class="text-muted fw-normal">(Opsional)</small></label>
                        <input type="text" name="nis" class="form-control neo-input" placeholder="Contoh: 123456789" value="{{ old('nis', $santri->nis) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control neo-input" required value="{{ old('nama', $santri->nama) }}">
                    </div>
                </div>

                <!-- Gender, Jenjang, & Kelas -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select neo-input" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Putra" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'Putra' ? 'selected' : '' }}>Putra</option>
                            <option value="Putri" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'Putri' ? 'selected' : '' }}>Putri</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenjang</label>
                        <select name="jenjang" class="form-select neo-input" required>
                            <option value="MTs" {{ old('jenjang', $santri->jenjang) == 'MTs' ? 'selected' : '' }}>MTs (Menengah Pertama)</option>
                            <option value="MA" {{ old('jenjang', $santri->jenjang) == 'MA' ? 'selected' : '' }}>MA (Menengah Atas)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                        <select name="kelas" class="form-select neo-input" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->nama_kelas }}" {{ old('kelas', $santri->kelas) == $k->nama_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }} ({{ $k->jenjang }})</option>
                            @endforeach
                            {{-- Fallback: tampilkan nilai lama jika tidak ada di master --}}
                            @if($kelasList->isEmpty() || !$kelasList->contains('nama_kelas', $santri->kelas))
                                <option value="{{ $santri->kelas }}" selected>{{ $santri->kelas }} (data lama)</option>
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Kamar & Status Santri -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kamar <span class="text-danger">*</span></label>
                        <select name="kamar" class="form-select neo-input" required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($kamarList as $k)
                                @php
                                    $isSelected = (old('kamar', $santri->kamar) == $k->nama_kamar);
                                    $sisa = $k->kapasitas - $k->santris_count;
                                    $isDisabled = !$isSelected && $sisa <= 0;
                                    $label = $sisa > 0 ? "Sisa: " . $sisa : "Penuh";
                                @endphp
                                <option value="{{ $k->nama_kamar }}" {{ $isSelected ? 'selected' : '' }} {{ $isDisabled ? 'disabled' : '' }}>
                                    {{ $k->nama_kamar }} ({{ $label }})
                                </option>
                            @endforeach
                            {{-- Fallback: tampilkan nilai lama jika tidak ada di master --}}
                            @if($kamarList->isEmpty() || !$kamarList->contains('nama_kamar', $santri->kamar))
                                <option value="{{ $santri->kamar }}" selected>{{ $santri->kamar }} (data lama)</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select neo-input" required>
                            <option value="aktif" {{ old('status', $santri->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ old('status', $santri->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="keluar" {{ old('status', $santri->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="neo-btn neo-btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Update Data Santri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFoto(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('fotoPreview');
        output.src = reader.result;
    };
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
