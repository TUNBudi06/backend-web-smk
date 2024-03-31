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
            $table->string('nama', 100);
            $table->string('target', 100);
            $table->string("thumbnail");
            $table->date('date');
            $table->time('time');
            $table->longText('text');
            $table->timestamp('timestamp')->useCurrent();
            $table->timestamps(); // Laravel timestamps, 'created_at' and 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pemberitahuan');
    }
};
