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
        Schema::table('tb_pemberitahuan', function (Blueprint $table) {
            $table->dropColumn('published_by');
            $table->unsignedBigInteger('published_by')->nullable();
            $table->foreign('published_by')->references('id_admin')->on('tb_admins')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('date');
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
