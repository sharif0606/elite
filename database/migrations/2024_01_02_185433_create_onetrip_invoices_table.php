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
        Schema::create('onetrip_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('invoice_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->decimal('vat',10,2)->default(0);
            $table->decimal('vat_taka',10,2)->default(0);
            $table->decimal('sub_total_amount',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->string('footer_note')->nullable();
            $table->date('bill_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('onetrip_invoices');
    }
};
