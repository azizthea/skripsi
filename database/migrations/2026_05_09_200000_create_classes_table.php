<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRASI: Tabel Master Kelas (classes)
 * 
 * TUJUAN AKADEMIS (SKALABILITAS SISTEM):
 * Tabel ini memisahkan data kelas dari tabel santri (Separation of Concerns).
 * Dengan demikian, pengurus dapat menambah, mengubah, atau menghapus kelas
 * kapan saja melalui antarmuka admin tanpa menyentuh kode program.
 * Sistem ini mendukung skalabilitas horizontal: pesantren dengan 5 kelas
 * maupun 50 kelas dapat menggunakan sistem yang sama tanpa modifikasi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');       // Nama kelas, contoh: "VII A MTs", "X MA"
            $table->enum('jenjang', ['MTs', 'MA']); // Jenjang untuk pengelompokan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
