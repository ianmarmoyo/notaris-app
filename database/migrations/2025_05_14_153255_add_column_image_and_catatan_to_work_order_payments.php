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
        Schema::table('work_order_payments', function (Blueprint $table) {
            $table->after('tgl_bayar', function ($table) {
                $table->string('catatan')->nullable();
                $table->string('image')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_payments', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'image']);
        });
    }
};
