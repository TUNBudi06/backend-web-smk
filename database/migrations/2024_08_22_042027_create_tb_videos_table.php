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
        Schema::create('tb_other', function (Blueprint $table) {
            $table->bigIncrements('id_link');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_used')->default(false);
            $table->enum('type', ['file', 'url', 'text'])->default('url');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_other');
    }
};
