<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muzakkis', function (Blueprint $table) {
            $table->id();
            $table->string('no_muzakki', 5)->unique();
            $table->string('nama_muzakki', 50);
            $table->string('telp_muzakki', 13);
            $table->text('alamat_muzakki');
            $table->date('tanggal_input');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('muzakkis');
    }
};