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
            // Tambahkan kolom pesan_doa jika belum ada
            if (!Schema::hasColumn('donaturs', 'pesan_doa')) {
                $table->text('pesan_doa')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donaturs', function (Blueprint $table) {
            // Hapus kolom pesan_doa jika ada
            if (Schema::hasColumn('donaturs', 'pesan_doa')) {
                $table->dropColumn('pesan_doa');
            }
        });
    }
};