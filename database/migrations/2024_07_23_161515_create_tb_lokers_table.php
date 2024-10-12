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
        Schema::create('tb_lokers', function (Blueprint $table) {
            $table->bigIncrements('id_loker');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id_position')->on('tb_positions')->onDelete('cascade');
            $table->unsignedBigInteger('kemitraan_id');
            $table->foreign('kemitraan_id')->references('id_kemitraan')->on('tb_kemitraans')->onDelete('cascade');
            $table->string('loker_description')->nullable();
            $table->string('loker_thumbnail')->nullable();
            $table->string('loker_available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lokers');
    }
};
