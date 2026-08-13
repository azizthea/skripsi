<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel absensis menyimpan data kehadiran harian santri.
     * Setiap record merepresentasikan kehadiran santri pada satu jenis kegiatan
     * (Pengajian atau Sekolah) di satu tanggal tertentu.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            // Guru yang mengabsen
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // Jenis kegiatan: nama mata pelajaran atau kategori umum
            $table->string('jenis_kegiatan');
            $table->date('tanggal');
            // Status kehadiran: Hadir, Izin (dengan keterangan), Sakit (dengan keterangan), atau Alpa (tanpa keterangan)
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->timestamps();

            // Unique constraint: mencegah data absensi ganda
            // Satu santri hanya boleh punya satu record per jenis_kegiatan per tanggal
            $table->unique(['santri_id', 'jenis_kegiatan', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
