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
    Schema::create('balik_nama_hibah', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('work_order_assignment_id');
      $table->string('proses')->nullable();
      $table->string('checklist')->nullable();
      $table->date('tgl_checklist')->nullable();
      $table->string('status_pembayaran')->nullable();
      $table->date('tgl_bayar')->nullable();
      $table->longText('catatan')->nullable();
      $table->string('gambar')->nullable();
      $table->timestamps();
      $table->foreign('work_order_assignment_id')->references('id')->on('work_order_assignments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('balik_nama_hibah');
  }
};
