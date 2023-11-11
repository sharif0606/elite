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
        Schema::create('invoice_generates', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('branch_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('bill_date')->nullable();
            //$table->string('vat')->nullable();
            $table->decimal('sub_total_amount',10,2)->default(0);
            $table->decimal('total_tk',10,2)->default(0);
            $table->decimal('vat_taka',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->text('footer_note')->nullable();
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
        Schema::dropIfExists('invoice_generates');
    }
};
