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
        Schema::create('hop_dong_log', function (Blueprint $table) {

            $table->id();
            $table->string('sohd',50);
            $table->string('loaihopdong',2);
            $table->string('ngaylaphd',15);

            $table->string('bena',5);
            $table->string('daidienbena',2);

            $table->string('benb',5);
            $table->string('daidienbenb',100);
            $table->string('chucvubenb',100);
            $table->string('uyquyenbenb',100)->nullable();

            $table->string('chatluong',20);

            $table->string('thoigianthanhtoan');
            $table->string('phuongthucthanhtoan',1000);
            $table->string('diadiemgiaohang');
            $table->string('thoigiangiaohang');
            $table->string('phuongthucgiaohang');
            $table->string('giaohangtungphan')->nullable();
            $table->string('phivanchuyen');

            $table->string('soluonginbena',1);
            $table->string('soluonginbenb',1);

            $table->string('username',50);
            
            $table->string('trangthai',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hop_dong_log');
    }
};
