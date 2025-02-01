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
    Schema::create('employees', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->date('tgl_lahir')->nullable();
      $table->string('tempat_lahir')->nullable();
      $table->string('jk')->nullable();
      $table->string('no_telp')->nullable();
      $table->string('agama')->nullable();
      $table->string('alamat')->nullable();
      $table->string('foto')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employees');
  }
};
