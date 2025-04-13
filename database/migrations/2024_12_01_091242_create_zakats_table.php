<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zakats', function (Blueprint $table) {
            $table->id();
            $table->string('no_zakat', 13)->unique();
            $table->date('tanggal_zakat');
            $table->string('jam_zakat', 6);
            $table->string('petugas_penerima', 50);
            $table->string('no_muzakki', 5);
            $table->foreign('no_muzakki')->references('no_muzakki')->on('muzakkis');
            $table->string('jenis_zakat', 25);
            $table->integer('jumlah_zakat');
            $table->decimal('berat_beras', 10, 2)->nullable();
            $table->string('jenis_bayar', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zakats');
    }
};
