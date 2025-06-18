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
        Schema::table('tb_sub_navbars', function (Blueprint $table) {
            $table->foreignId('icon_id')
                  ->nullable()
                  ->constrained('tb_badges')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sub_navbars', function (Blueprint $table) {
            $table->string('icon')->nullable();

            $table->dropForeign(['icon_id']);
            $table->dropColumn('icon_id');
        });
    }
};
