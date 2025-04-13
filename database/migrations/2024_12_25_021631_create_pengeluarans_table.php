<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengajuan');
            $table->date('tanggal')->default(now());
            $table->string('nama_koordinator');
            $table->string('koordinator_bidang');
            $table->string('jenis_pengeluaran');
            $table->decimal('jumlah', 15, 2); // Untuk jumlah pengajuan
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('user_id'); // Menyimpan ID user yang mengajukan
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluarans');
    }
}
