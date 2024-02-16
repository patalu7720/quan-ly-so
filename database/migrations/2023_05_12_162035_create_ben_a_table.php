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
        Schema::create('ben_a', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('diachi');
            $table->string('masothue',20);
            $table->string('dienthoai',50);
            $table->string('fax',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ben_a');
    }
};
