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
        Schema::create('tb_logo_mitras', function (Blueprint $table) {
            $table->bigIncrements('id_logo_mitra')->primary();
            $table->string('nama_mitra');
            $table->string('logo_mitra');
            $table->integer('width')->default(128);
            $table->integer('height')->default(128);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_logo_mitras');
    }
};
