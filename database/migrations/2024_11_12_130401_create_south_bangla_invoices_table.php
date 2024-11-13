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
        Schema::create('south_bangla_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('customer_id');
            $table->integer('branch_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('bill_date')->nullable();
            $table->integer('vat')->nullable();
            $table->decimal('net_payment',10,2)->default(0);
            $table->decimal('net_service',10,2)->default(0);
            $table->decimal('total',10,2)->default(0);
            $table->decimal('vat_taka',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->text('footer_note')->nullable();
            $table->text('header_note')->nullable();
            $table->string('inv_subject')->nullable();
            $table->string('status')->nullable();
            $table->integer('invoice_type')->nullable()->comment('1=general, 2=wasa, 3=onetrip, 4=portlink, 5=south bangla');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('south_bangla_invoices');
    }
};
