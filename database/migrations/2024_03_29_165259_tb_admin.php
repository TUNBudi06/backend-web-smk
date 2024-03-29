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
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->bigIncrements('id')->primary(true);
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password'); // Assuming password will be stored as a string
            $table->string('token')->nullable();
            $table->string("remember_token");
            $table->timestamps(); // Creates 'created_at' and 'updated_at' columns unless overridden
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tb_admin");
    }
};
