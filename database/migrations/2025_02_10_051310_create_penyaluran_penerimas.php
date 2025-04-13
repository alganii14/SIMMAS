<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyaluran_penerimas', function (Blueprint $table) {
            $table->id();
            $table->string('no_penyaluran', 15);
            $table->string('no_mustahik', 5);
            $table->integer('jumlah_terima');
            $table->string('status_penerima', 25);
            $table->timestamps();

            $table->foreign('no_penyaluran')
                  ->references('no_penyaluran')
                  ->on('penyalurans')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyaluran_penerimas');
    }
};
