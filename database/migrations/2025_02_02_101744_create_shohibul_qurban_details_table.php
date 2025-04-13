<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shohibul_qurban_details', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('sq_id', 40);
            $table->string('nama');
            $table->string('bin_or_binti');
            $table->string('bin_or_binti_value');
            $table->timestamps();

            $table->foreign('sq_id')
                  ->references('id')
                  ->on('shohibul_qurbans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shohibul_qurban_details');
    }
};
