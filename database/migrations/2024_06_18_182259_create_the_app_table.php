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
        Schema::create('tb_settings', function (Blueprint $table) {
            $table->id('id_settings');
            $table->string('na_setting', 60);
            $table->string('text_setting');
            $table->string('status_setting')->default(false);
            $table->string('url_setting')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_settings');
    }
};
