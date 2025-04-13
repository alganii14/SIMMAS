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
            // Tambahkan kolom email jika belum ada
            if (!Schema::hasColumn('donaturs', 'email')) {
                $table->string('email')->nullable()->after('no_telepon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donaturs', function (Blueprint $table) {
            // Hapus kolom email jika ada
            if (Schema::hasColumn('donaturs', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};