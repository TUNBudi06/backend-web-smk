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
        Schema::create('tb_admins', function (Blueprint $table) {
            $table->bigIncrements("id_admin")->primary();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string("token")->nullable();
            $table->unsignedBigInteger("role")->nullable();
            $table->foreign("role")->references("id_role")->on("tb_user_roles")->onDelete("set null")->onUpdate("set null");
            $table->string("created_by");
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
        Schema::dropIfExists('tb_admins');
    }
};
