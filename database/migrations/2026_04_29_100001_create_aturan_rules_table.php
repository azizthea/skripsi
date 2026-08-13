<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aturan_rules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rule');
            $table->integer('prioritas');
            $table->json('kondisi_json');
            $table->string('hasil_kategori');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_rules');
    }
};
