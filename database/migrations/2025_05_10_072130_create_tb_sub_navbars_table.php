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
        Schema::create('tb_sub_navbars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('navbar_id')->constrained('tb_navbars')->onDelete('cascade');
            $table->string('title');
            $table->string('route');
            $table->string('icon')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sub_navbars');
    }
};
