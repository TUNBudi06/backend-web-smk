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
        Schema::create('tb_custom_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elearning_id')->constrained('tb_elearnings')->onDelete('cascade');
            $table->string('label');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_custom_badges');
    }
};
