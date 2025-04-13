<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mustahiks', function (Blueprint $table) {
            $table->integer('jumlah_anak')->default(0)->after('rt');
        });
    }

    public function down()
    {
        Schema::table('mustahiks', function (Blueprint $table) {
            $table->dropColumn('jumlah_anak');
        });
    }
};
