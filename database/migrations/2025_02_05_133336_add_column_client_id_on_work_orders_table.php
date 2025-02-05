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
    Schema::table('work_orders', function (Blueprint $table) {
      $table->after('no_wo', function ($table) {
        $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('work_orders', function (Blueprint $table) {
      //
    });
  }
};
