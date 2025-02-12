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
    Schema::table('balik_nama_hibah', function (Blueprint $table) {
      $table->string('cek_sertifikat')->nullable();
      $table->date('tgl_cek_sertifikat')->nullable();
      $table->string('no_berkas')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('balik_nama_hibah', function (Blueprint $table) {
      $table->dropColumn('cek_sertifikat');
      $table->dropColumn('tgl_cek_sertifikat');
      $table->dropColumn('no_berkas');
    });
  }
};
