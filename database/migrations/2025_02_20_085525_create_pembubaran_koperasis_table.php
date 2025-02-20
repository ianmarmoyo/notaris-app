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
    Schema::create('pembubaran_koperasis', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('work_order_assignment_id');
      $table->string('proses')->nullable();
      $table->string('checklist')->nullable();
      $table->date('tgl_checklist')->nullable();
      $table->string('rekomendasi')->nullable();
      $table->string('pesan_nama')->nullable();
      $table->string('draft_akta')->nullable();
      $table->string('ttd')->nullable();
      $table->string('pengesahan')->nullable();
      $table->string('penyerahan')->nullable();
      $table->string('gambar')->nullable();
      $table->string('catatan')->nullable();

      $table->foreign('work_order_assignment_id')->references('id')->on('work_order_assignments')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pembubaran_koperasis');
  }
};
