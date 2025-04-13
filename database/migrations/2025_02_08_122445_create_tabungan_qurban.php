<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tabungan_qurban', function (Blueprint $table) {
            $table->char('id', 40)->primary();
            $table->char('nasabah_id', 40);
            $table->char('harga_hewan_id', 40);
            $table->decimal('jumlah_setoran', 12, 2);
            $table->date('tanggal_setor');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabah_qurban');
            $table->foreign('harga_hewan_id')->references('id')->on('harga_hewan_qurban');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabungan_qurban');
    }
};
