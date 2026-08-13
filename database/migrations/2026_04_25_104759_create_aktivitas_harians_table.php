<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aktivitas_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('sholat_berjamaah', ['hadir', 'tidak', 'terlambat'])->default('hadir');
            $table->enum('mengaji', ['hadir', 'tidak', 'terlambat'])->default('hadir');
            $table->enum('sekolah', ['hadir', 'tidak', 'terlambat'])->default('hadir');
            $table->integer('jumlah_pelanggaran')->default(0);
            $table->timestamps();
            
            $table->unique(['santri_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_harians');
    }
};
