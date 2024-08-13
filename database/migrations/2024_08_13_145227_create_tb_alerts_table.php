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
        Schema::create('tb_alerts', function (Blueprint $table) {
            $table->bigIncrements('id_alert');
            $table->string('alert_title');
            $table->string('alert_url');
            $table->string('alert_background_color')->nullable();
            $table->string('alert_button_color')->nullable();
            $table->string('alert_button_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_alerts');
    }
};
