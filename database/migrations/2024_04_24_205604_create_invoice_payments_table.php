<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->decimal('received_amount',10,2)->default(0)->nullable();
            $table->decimal('vat',10,2)->default(0)->nullable();
            $table->decimal('vat_amount',10,2)->default(0)->nullable();
            $table->decimal('ait',10,2)->default(0)->nullable();
            $table->decimal('ait_amount',10,2)->default(0)->nullable();
            $table->decimal('fine_deduction',10,2)->default(0)->nullable();
            $table->decimal('paid_by_client',10,2)->default(0)->nullable();
            $table->decimal('less_paid_honor',10,2)->default(0)->nullable();
            $table->decimal('less_paid',10,2)->default(0)->nullable();
            $table->string('deposit_bank')->nullable();
            $table->integer('payment_type')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->date('deposit_date')->nullable();
            $table->date('rcv_date')->nullable();
            $table->date('pay_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_payments');
    }
};
