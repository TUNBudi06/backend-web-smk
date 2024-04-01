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
        Schema::create('tb_user_pendings', function (Blueprint $table) {
            $table->bigIncrements("id_user")->primary();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string("NIP")->unique();
            $table->string("foto_ktp");
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean("verified_user")->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user_pendings');
    }
};
