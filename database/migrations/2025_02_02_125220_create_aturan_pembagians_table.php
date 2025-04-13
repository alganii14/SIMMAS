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
        Schema::create('aturan_pembagians', function (Blueprint $table) {
            $table->id();
            $table->string('status'); // Penerima/Panitia dan jenisnya
            $table->text('produk'); // Jenis produk yang diterima (disimpan sebagai string dengan pemisah koma)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_pembagians');
    }
};
