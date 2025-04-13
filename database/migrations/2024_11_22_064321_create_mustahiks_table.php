<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mustahiks', function (Blueprint $table) {
            $table->id();
            $table->string('no_mustahik', 5)->unique();
            $table->string('no_kk', 18);
            $table->string('nama_mustahik', 50);
            $table->text('alamat_mustahik');
            $table->string('asnaf', 35);
            $table->date('tanggal_input');
            $table->string('rt', 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mustahiks');
    }
};