<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('infaqs', function (Blueprint $table) {
            $table->string('status')->default('success')->after('jumlah');
            $table->string('snap_token')->nullable()->after('status');
            $table->string('payment_type')->nullable()->after('snap_token');
            $table->string('transaction_id')->nullable()->after('payment_type');
            $table->string('transaction_time')->nullable()->after('transaction_id');
            $table->string('transaction_status')->nullable()->after('transaction_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infaqs', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'snap_token',
                'payment_type',
                'transaction_id',
                'transaction_time',
                'transaction_status'
            ]);
        });
    }
};
