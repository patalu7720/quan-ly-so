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
        Schema::create('dai_dien_ben_a', function (Blueprint $table) {
            $table->id();
            $table->string('daidien',100);
            $table->string('chucvu',100);
            $table->string('uyquyen',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dai_dien_ben_a');
    }
};
