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
        Schema::table('donaturs', function (Blueprint $table) {
            // Tambahkan kolom anonim jika belum ada
            if (!Schema::hasColumn('donaturs', 'anonim')) {
                $table->enum('anonim', ['ya', 'tidak'])->default('tidak')->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donaturs', function (Blueprint $table) {
            // Hapus kolom anonim jika ada
            if (Schema::hasColumn('donaturs', 'anonim')) {
                $table->dropColumn('anonim');
            }
        });
    }
};