<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengubah kolom role menjadi string agar lebih fleksibel atau update ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'bk', 'pengurus') DEFAULT 'guru'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru') DEFAULT 'guru'");
    }
};
