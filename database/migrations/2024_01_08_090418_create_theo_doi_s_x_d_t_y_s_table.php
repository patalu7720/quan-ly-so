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
        Schema::create('theo_doi_s_x_d_t_y_s', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hang');
            $table->datetime('ngay_sx_chinh_thuc');
            $table->datetime('ngay_kiem_tra_tskt');
            $table->string('ngay_qc_gui_tskt');
            $table->string('ket_qua');
            $table->string('created_user');
            $table->string('updated_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theo_doi_s_x_d_t_y_s');
    }
};
