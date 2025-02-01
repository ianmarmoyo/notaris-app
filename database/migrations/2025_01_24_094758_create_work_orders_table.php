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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_wo');
            $table->string('nama');
            $table->string('no_telp');
            $table->longText('alamat');
            $table->date('tgl_pengajuan');
            $table->string('status_wo')->default('draft');
            $table->date('tgl_pembayaran')->nullable();
            $table->string('status_pembayaran');
            $table->unsignedBigInteger('created_user');
            $table->foreign('created_user')->references('id')->on('admins')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
