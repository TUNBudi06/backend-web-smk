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
            $table->string('pemberitahuan_nama', 100);
            $table->string('pemberitahuan_target', 100);
            $table->string("pemberitahuan_thumbnail");
            $table->date('pemberitahuan_date');
            $table->time('pemberitahuan_time');
            $table->longText('pemberitahuan_text');
            $table->timestamp('pemberitahuan_timestamp')->useCurrent();
            $table->timestamps(); // Laravel timestamps, 'created_at' and 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pemberitahuan');
    }
};
