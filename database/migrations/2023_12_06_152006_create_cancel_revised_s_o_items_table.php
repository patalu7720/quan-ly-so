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
        Schema::create('cancel_revised_s_o_items', function (Blueprint $table) {
            $table->id();
            $table->string('cancel_revised_so_id')->nullable();
            $table->string('old_item')->nullable();
            $table->string('new_item')->nullable();
            $table->string('description')->nullable();
            $table->string('old_qty')->nullable();
            $table->string('new_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_revised_s_o_items');
    }
};
