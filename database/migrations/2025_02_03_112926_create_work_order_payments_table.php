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
    Schema::create('work_order_payments', function (Blueprint $table) {
      $table->id();
      $table->string('no_pembayaran');
      $table->foreignId('work_order_id')->constrained()->onDelete('restrict');
      $table->unsignedBigInteger('user_admin_id');
      $table->foreign('user_admin_id')->references('id')->on('admins')->onDelete('restrict');
      $table->double('nominal')->default(0);
      $table->string('metode_pembayaran');
      $table->string('status_pembayaran');
      $table->dateTime('tgl_bayar')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('work_order_payments');
  }
};
