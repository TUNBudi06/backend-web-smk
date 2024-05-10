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
        Schema::create('tb_pemberitahuan_category', function (Blueprint $table) {
            $table->id("id_pemberitahuan_category");
            $table->string("pemberitahuan_category_name");
            $table->unsignedBigInteger("type"); // Assuming type is intended to reference id_pemberitahuan_type
            $table->foreign("type")->references("id_pemberitahuan_type")->on("tb_pemberitahuan_type")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pemberitahuan_category');
    }
};
