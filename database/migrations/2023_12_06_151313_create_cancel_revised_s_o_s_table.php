<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancel_revised_s_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khach_hang')->nullable();
            $table->string('ma_khach_hang')->nullable();
            $table->string('so')->nullable();
            $table->string('date')->nullable();
            $table->string('being_processed')->nullable();
            $table->string('open')->nullable();
            $table->string('cancel_order')->nullable();
            $table->string('revised_latest_shipment_date')->nullable();
            $table->string('old_date')->nullable();
            $table->string('new_date')->nullable();
            $table->string('revised_qty')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('shipment_plan')->nullable();
            $table->string('output_tax')->nullable();
            $table->string('bill_to_party')->nullable();
            $table->string('po_number')->nullable();
            $table->string('order_reason')->nullable();
            $table->string('reason_for_reject')->nullable();
            $table->string('internal_order')->nullable();
            $table->string('tolerance')->nullable();
            $table->string('other_reason', 1000)->nullable();

            $table->string('sale_admin_approve')->nullable();
            $table->string('sale_admin_approve_at')->nullable();
            $table->string('sale_approve')->nullable();
            $table->string('sale_approve_at')->nullable();
            $table->string('sale_manager_approve')->nullable();
            $table->string('sale_manager_approve_at')->nullable();
            $table->string('khst_approve')->nullable();
            $table->string('khst_approve_at')->nullable();
            $table->string('finish')->nullable();
            $table->string('finish_at')->nullable();

            $table->string('created_user')->nullable();
            $table->string('updated_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_revised_s_o_s');
    }
};
