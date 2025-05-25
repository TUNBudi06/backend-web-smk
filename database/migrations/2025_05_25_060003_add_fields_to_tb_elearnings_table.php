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
        Schema::table('tb_elearnings', function (Blueprint $table) {
            $table->string('body_thumbnail')->nullable()->after('body_desc');

            $table->string('btn_label_2')->nullable()->after('btn_label');
            $table->string('btn_icon_2')->nullable()->after('btn_icon');
            $table->string('btn_url_2')->nullable()->after('btn_url');
        });
    }

    public function down(): void
    {
        Schema::table('tb_elearnings', function (Blueprint $table) {
            $table->dropColumn([
                'body_thumbnail',
                'btn_label_2',
                'btn_icon_2',
                'btn_url_2',
            ]);
        });
    }
};
