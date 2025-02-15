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
    Schema::create('warmarking', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('work_order_assignment_id');
      $table->string('proses')->nullable();
      $table->string('checklist')->nullable();
      $table->date('tgl_checklist')->nullable();
      $table->string('ttd_penghadap')->nullable();
      $table->string('pengesahan')->nullable();
      $table->string('penyerahan')->nullable();
      $table->string('gambar')->nullable();
      $table->string('catatan')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('warmarking');
  }
};
