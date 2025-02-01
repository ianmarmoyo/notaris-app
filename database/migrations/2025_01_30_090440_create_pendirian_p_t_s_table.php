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
    Schema::create('pendirian_p_t_s', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('work_order_assignment_id');
      $table->string('proses')->nullable();
      $table->string('checklist')->nullable();
      $table->date('tgl_checklist')->nullable();
      $table->string('formulir_pendiran')->nullable();
      $table->string('pesan_nama')->nullable();
      $table->string('draft_akta')->nullable();
      $table->string('ttd_akta')->nullable();
      $table->string('pengesahan')->nullable();
      $table->string('penyerahan')->nullable();
      $table->string('gambar')->nullable();
      $table->string('catatan')->nullable();
      $table->timestamps();

      $table->foreign('work_order_assignment_id')->references('id')->on('work_order_assignments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pendirian_p_t_s');
  }
};
