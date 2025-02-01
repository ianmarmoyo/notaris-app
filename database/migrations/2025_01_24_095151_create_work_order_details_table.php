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
        Schema::create('work_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('master_work_order_id');
            $table->foreign('master_work_order_id')->references('id')->on('master_work_orders')->onDelete('restrict');
            $table->string('keperluan')->nullable();
            $table->double('harga');
            $table->string('keterangan')->nullable();
            $table->enum('status',['pending','proses','selesai'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_details');
    }
};
