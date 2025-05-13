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
    $tables = $this->tables();
    foreach ($tables as $tableName) {
      if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'deadline')) {
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
          $table->date('deadline')->nullable();
        });
      }
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    $tables = $this->tables();
    foreach ($tables as $tableName) {
      if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deadline')) {
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
          $table->dropColumn(['deadline'])->nullable();
        });
      }
    }
  }

  public function tables()
  {
    $tables = [
      'akta_permohonan_hak',
      'balik_aphb',
      'balik_nama_hibah',
      'balik_nama_jual_belis',
      'balik_nama_sertifikat',
      'balik_nama_waris',
      'legalitas',
      'pelepasan_hak',
      'pembubaran_koperasis',
      'pemecah_sertifikat',
      'pendirian_cv',
      'pendirian_koperasis',
      'pendirian_p_t_s',
      'pendirian_perkumpulan',
      'pendirian_pt_perorangan',
      'pendirian_yayasan',
      'penggabungan_sertifikats',
      'peningkatan_hak',
      'penurunan_hak',
      'perjanjian_lainnya',
      'perubahan_koperasis',
      'sertifikat_permohonan_hak',
      'warmarking',
    ];
    return $tables;
  }
};
