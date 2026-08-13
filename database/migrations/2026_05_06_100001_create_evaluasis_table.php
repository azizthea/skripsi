<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel evaluasis menyimpan hasil klasifikasi bulanan santri.
     * Setiap record merepresentasikan output dari proses Forward Chaining
     * untuk satu santri pada satu bulan/tahun tertentu.
     * 
     * Kolom audit trail (total_hadir_*, total_hari_*) disimpan agar
     * penguji sidang dapat melakukan verifikasi/cross-check manual
     * terhadap hasil perhitungan persentase.
     */
    public function up(): void
    {
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('bulan');   // 1-12
            $table->unsignedSmallInteger('tahun');  // e.g. 2026

            // =====================================================
            // AUDIT TRAIL: Data mentah untuk verifikasi penguji
            // Menyimpan numerator dan denominator dari rumus persentase
            // sehingga bisa di-cross-check: Persentase = (Hadir/Total) × 100
            // =====================================================
            $table->unsignedInteger('total_hadir_pengajian')->default(0);
            $table->unsignedInteger('total_hari_pengajian')->default(0);
            $table->unsignedInteger('total_hadir_sekolah')->default(0);
            $table->unsignedInteger('total_hari_sekolah')->default(0);

            // Hasil perhitungan persentase kehadiran
            $table->decimal('persentase_pengajian', 5, 2)->default(0);
            $table->decimal('persentase_sekolah', 5, 2)->default(0);

            // Hasil klasifikasi dari Forward Chaining
            $table->enum('kategori_disiplin', ['Tinggi', 'Sedang', 'Rendah'])->nullable();

            // Audit Trail: nama rule yang terpicu (untuk traceability)
            $table->string('triggered_rule')->nullable();

            $table->timestamps();

            // Unique constraint: satu santri hanya punya satu evaluasi per periode
            $table->unique(['santri_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
