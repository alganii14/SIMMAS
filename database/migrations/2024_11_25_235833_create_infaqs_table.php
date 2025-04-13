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
        Schema::create('infaqs', function (Blueprint $table) {
            $table->id();
            $table->string('no_penerimaan')->unique(); // Nomor penerimaan
            $table->date('tanggal'); // Tanggal penerimaan
            $table->time('waktu'); // Waktu penerimaan
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('cascade'); // Boleh kosong
            $table->foreignId('donatur_id')->constrained('donaturs')->onDelete('cascade'); // Relasi ke tabel donaturs
            $table->string('jenis_penerimaan'); // Jenis penerimaan
            $table->decimal('jumlah', 15, 2); // Jumlah penerimaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaqs');
    }
};
