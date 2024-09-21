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
        Schema::create('tb_perangkat_ajars', function (Blueprint $table) {
            $table->bigIncrements('id_pa')->primary();
            $table->string('title');
            $table->string('description');
            $table->enum('type', ['url', 'file']);
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_perangkat_ajars');
    }
};
