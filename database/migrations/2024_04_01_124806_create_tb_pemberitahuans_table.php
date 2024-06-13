<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pemberitahuan', function (Blueprint $table) {
            $table->bigIncrements('id_pemberitahuan');
            $table->string('nama',)->nullable();
            $table->string('target')->nullable();
            $table->string("thumbnail")->nullable();
            $table->string("banner")->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->longText('text');
            $table->boolean("level")->default(false);
            $table->string("location")->nullable();
            $table->unsignedBigInteger("type")->nullable();
            $table->foreign("type","jenis")->references("id_pemberitahuan_type")->on("tb_pemberitahuan_type")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("category")->nullable();
            $table->foreign("category","kategori")->references("id_pemberitahuan_category")->on("tb_pemberitahuan_category")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("viewer");
            $table->string("created_by")->nullable();
            $table->boolean("approved")->default(false);
            $table->unsignedBigInteger("Approved_by")->nullable();
            $table->foreign("approved_by")->references("id_admin")->on("tb_admins")->onUpdate("cascade")->onDelete("set null");
            $table->timestamps(); // Laravel timestamps, 'created_at' and 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pemberitahuan');
    }
};
