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
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('sohd');

            $table->string('quycach1');
            $table->string('soluong1',20);
            $table->string('dongia1',20);

            $table->string('quycach2')->nullable();
            $table->string('soluong2',20)->nullable();
            $table->string('dongia2',20)->nullable();

            $table->string('quycach3')->nullable();
            $table->string('soluong3',20)->nullable();
            $table->string('dongia3',20)->nullable();

            $table->string('quycach4')->nullable();
            $table->string('soluong4',20)->nullable();
            $table->string('dongia4',20)->nullable();

            $table->string('quycach5')->nullable();
            $table->string('soluong5',20)->nullable();
            $table->string('dongia5',20)->nullable();

            $table->string('quycach6')->nullable();
            $table->string('soluong6',20)->nullable();
            $table->string('dongia6',20)->nullable();

            $table->string('quycach7')->nullable();
            $table->string('soluong7',20)->nullable();
            $table->string('dongia7',20)->nullable();

            $table->string('quycach8')->nullable();
            $table->string('soluong8',20)->nullable();
            $table->string('dongia8',20)->nullable();

            $table->string('quycach9')->nullable();
            $table->string('soluong9',20)->nullable();
            $table->string('dongia9',20)->nullable();

            $table->string('quycach10')->nullable();
            $table->string('soluong10',20)->nullable();
            $table->string('dongia10',20)->nullable();

            $table->string('quycach11')->nullable();
            $table->string('soluong11',20)->nullable();
            $table->string('dongia11',20)->nullable();

            $table->string('quycach12')->nullable();
            $table->string('soluong12',20)->nullable();
            $table->string('dongia12',20)->nullable();

            $table->string('quycach13')->nullable();
            $table->string('soluong13',20)->nullable();
            $table->string('dongia13',20)->nullable();

            $table->string('quycach14')->nullable();
            $table->string('soluong14',20)->nullable();
            $table->string('dongia14',20)->nullable();

            $table->string('quycach15')->nullable();
            $table->string('soluong15',20)->nullable();
            $table->string('dongia15',20)->nullable();

            $table->string('username',50);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
