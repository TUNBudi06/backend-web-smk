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
        Schema::create('tb_kemitraans', function (Blueprint $table) {
            $table->bigIncrements('id_kemitraan');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id_position')->on('tb_positions')->onDelete('cascade');
            $table->string('kemitraan_name');
            $table->string('kemitraan_logo')->nullable();
            $table->string('kemitraan_thumbnail')->nullable();
            $table->text('kemitraan_description')->nullable();
            $table->string('kemitraan_city');
            $table->text('kemitraan_location_detail');
            $table->string('kemitraan_available')->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kemitraans');
    }
};
