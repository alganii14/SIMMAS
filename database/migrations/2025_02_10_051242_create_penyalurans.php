<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyalurans', function (Blueprint $table) {
            $table->string('no_penyaluran', 15)->primary();
            $table->date('tanggal_penyaluran');
            $table->string('jam_penyaluran', 6);
            $table->string('petugas_penyaluran', 50);
            $table->string('jenis_zakat', 25);
            $table->integer('total_penyaluran');
            $table->string('status_penyaluran', 25);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyalurans');
    }
};
