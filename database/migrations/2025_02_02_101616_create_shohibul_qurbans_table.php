<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shohibul_qurbans', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('tahun_hijriah', 6);
            $table->string('nik', 20);
            $table->string('nama', 50);
            $table->string('hp', 25);
            $table->text('alamat');
            $table->string('jenis_hewan', 30);
            $table->string('berat', 10);
            $table->text('bagian_diminta');
            $table->string('tanggal', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shohibul_qurbans');
    }
};
