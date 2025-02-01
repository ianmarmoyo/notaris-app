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
    Schema::create('work_order_attachments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('work_order_detail_id')->constrained()->onDelete('cascade');
      $table->string('nama_lampiran');
      $table->enum('jenis_berkas', ['syarat', 'pelengkap'])->default('syarat');
      $table->string('checklist')->default('no');
      $table->string('file')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('work_order_attachments');
  }
};
