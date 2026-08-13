<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRASI: Tabel Master Kamar (rooms)
 * 
 * TUJUAN AKADEMIS (SKALABILITAS SISTEM):
 * Tabel ini memisahkan data kamar dari tabel santri.
 * Kapasitas kamar dicatat untuk mendukung fitur manajemen hunian
 * di masa depan (misalnya: peringatan kamar penuh, distribusi santri).
 * Instansi dengan 10 kamar hingga 100 kamar dapat menggunakan sistem
 * yang sama hanya dengan menambah data di tabel ini.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kamar');       // Nama kamar, contoh: "Al-Fatih", "Abu Bakar"
            $table->integer('kapasitas')->default(10); // Kapasitas maksimal penghuni
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
