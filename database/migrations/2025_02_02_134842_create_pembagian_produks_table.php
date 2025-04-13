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
        Schema::create('pembagian_produks', function (Blueprint $table) {
            $table->id();
            $table->string('produk'); // Nama produk
            $table->decimal('berat', 10, 2); // Berat total dalam kg
            $table->integer('total_bungkus'); // Jumlah penerima
            $table->decimal('berat_perproduk', 10, 2); // Berat per penerima dalam kg
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembagian_produks');
    }
};
