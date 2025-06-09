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
            $table->string('description')->nullable()->after('route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sub_navbars', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
