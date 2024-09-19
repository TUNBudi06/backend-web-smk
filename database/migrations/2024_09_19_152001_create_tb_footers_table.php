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
        Schema::create('tb_footers', function (Blueprint $table) {
            $table->bigIncrements('id_footer');
            $table->string('label');
            $table->string('url');
            $table->enum('type',[1,2,3]); // 1: unit produksi sekolah 2: aplikasi dan lauanan 3: lainnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_footers');
    }
};
