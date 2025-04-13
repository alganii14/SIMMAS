<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penerima_qurban', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik');
            $table->string('nama');
            $table->string('tahun_hijriah');
            $table->enum('status', ['Personal', 'Yayasan']);
            $table->text('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('role')->default('qurban');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerima_qurban');
    }
};

