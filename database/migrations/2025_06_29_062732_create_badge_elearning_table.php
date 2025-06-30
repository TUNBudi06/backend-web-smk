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
        Schema::create('badge_elearning', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elearning_id')->constrained('tb_elearnings')->onDelete('cascade');
            $table->foreignId('badge_id')->constrained('tb_badges')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_elearning');
    }
};
