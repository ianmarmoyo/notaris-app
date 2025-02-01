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
        Schema::create('work_order_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('work_order_detail_id');
            $table->unsignedBigInteger('user_admin_id');
            $table->date('tgl_penugasan')->nullable();
            $table->string('status_penugasan')->nullable();
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('restrict');
            $table->foreign('work_order_detail_id')->references('id')->on('work_order_details')->onDelete('restrict');
            $table->foreign('user_admin_id')->references('id')->on('admins')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_assignments');
    }
};
