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
    Schema::table('work_order_details', function (Blueprint $table) {
      $table->after('keterangan', function ($table) {
        $table->string('catatan_persyaratan')->nullable();
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('work_order_details', function (Blueprint $table) {
      $table->dropColumn('catatan_persyaratan');
    });
  }
};
