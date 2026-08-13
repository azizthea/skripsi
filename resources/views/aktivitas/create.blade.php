@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex align-items-center">
    <a href="{{ route('aktivitas.index') }}" class="neo-btn me-3" style="padding: 8px 16px;">&larr; Kembali</a>
    <h3 style="color: var(--af-positive); font-weight: 700; margin:0;">Formulir Input Keputusan</h3>
</div>

<div class="neo-card mt-3">
    <form action="{{ route('aktivitas.store') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6">
                <label>Identitas Subjek (Santri)</label>
                <select name="santri_id" class="neo-input mt-1" required>
                    <option value="">-- Pilih Target Evaluasi --</option>
                    @foreach($santris as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Timeline Evaluasi (Tanggal)</label>
                <input type="date" name="tanggal" class="neo-input mt-1" required value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <hr style="border-color: rgba(163,177,198,0.2); margin: 30px 0;">
        <h5 style="color: var(--af-dark);">Parameter Kepatuhan</h5>

        <div class="row mb-4 mt-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label>Aktivitas Kehadiran (Sekolah)</label>
                <select name="sekolah" class="neo-input mt-2">
                    <option value="hadir">Memenuhi Standar (Hadir)</option>
                    <option value="terlambat">Toleransi Minor (Terlambat)</option>
                    <option value="tidak">Pelanggaran (Tidak Hadir)</option>
                </select>
            </div>
                </select>
            </div>
            <div class="col-md-6 mb-3 mb-md-0">
                <!-- Fallback hidden inputs to prevent database errors since columns might still exist in DB schema -->
                <input type="hidden" name="sholat_berjamaah" value="hadir">
                <input type="hidden" name="mengaji" value="hadir">
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <label>Aktivitas Pelanggaran (Angka)</label>
                <input type="number" name="jumlah_pelanggaran" class="neo-input mt-2 w-50" value="0" min="0" required>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="neo-btn neo-btn-primary">Kunci Data & Simpan</button>
        </div>
    </form>
</div>
@endsection
