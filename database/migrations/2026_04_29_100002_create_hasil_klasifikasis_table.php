<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_klasifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->string('periode'); // Format: YYYY-MM
            $table->decimal('skor_numerik', 5, 2)->nullable(); // e.g. 85.50
            $table->string('kategori_sistem');
            $table->string('kategori_pakar')->nullable();
            $table->json('triggered_rules_json')->nullable();
            $table->boolean('is_accurate')->nullable();
            $table->timestamps();
            
            $table->unique(['santri_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_klasifikasis');
    }
};
