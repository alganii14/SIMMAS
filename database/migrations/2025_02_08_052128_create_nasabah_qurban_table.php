<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nasabah_qurban', function (Blueprint $table) {
            $table->char('id', 40)->primary();
            $table->string('nik', 20);
            $table->string('nama', 50);
            $table->string('hp', 20);
            $table->text('alamat');
            $table->string('ref_id', 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nasabah_qurban');
    }
};
