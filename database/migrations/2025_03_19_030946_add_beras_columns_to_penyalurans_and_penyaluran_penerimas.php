<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penyalurans', function (Blueprint $table) {
            $table->decimal('beras_disalurkan', 10, 2)->default(0)->after('status_penyaluran');
        });

        Schema::table('penyaluran_penerimas', function (Blueprint $table) {
            $table->decimal('beras_terima', 10, 2)->default(0)->after('status_penerima');
        });
    }

    public function down()
    {
        Schema::table('penyalurans', function (Blueprint $table) {
            $table->dropColumn('beras_disalurkan');
        });

        Schema::table('penyaluran_penerimas', function (Blueprint $table) {
            $table->dropColumn('beras_terima');
        });
    }
};
