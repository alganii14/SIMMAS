<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('harga_hewan_qurban', function (Blueprint $table) {
            $table->char('id', 40)->primary();
            $table->string('jenis_hewan');
            $table->decimal('harga', 12, 2);
            $table->integer('tahun_hijriah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('harga_hewan_qurban');
    }
};
