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
        Schema::table('nasabah_qurban', function (Blueprint $table) {
            $table->char('target_hewan_id', 40)->nullable()->after('ref_id');
            $table->foreign('target_hewan_id')->references('id')->on('harga_hewan_qurban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
