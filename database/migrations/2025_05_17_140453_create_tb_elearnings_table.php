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
        Schema::create('tb_elearnings', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable();
            $table->string('title');
            $table->text('desc')->nullable();
            $table->string('btn_label')->nullable();
            $table->string('btn_icon')->nullable();
            $table->string('btn_url')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body_desc')->nullable();
            $table->string('body_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_elearnings');
    }
};
