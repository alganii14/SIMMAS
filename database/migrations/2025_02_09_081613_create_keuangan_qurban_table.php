<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keuangan_qurban', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_transaksi');
            $table->date('tanggal');
            $table->enum('jenis', ['Masuk', 'Keluar']);
            $table->decimal('jumlah', 12, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangan_qurban');
    }
};
