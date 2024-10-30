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
        Schema::create('portlink_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('bill_date')->nullable();
            $table->integer('vat')->nullable();
            $table->decimal('sub_amount',10,2)->default(0);
            $table->decimal('sub_commission_amount',10,2)->default(0);
            $table->decimal('sub_total_amount',10,2)->default(0);
            $table->decimal('net_amount',10,2)->default(0);
            $table->decimal('net_commission',10,2)->default(0);
            $table->decimal('net_total_tk',10,2)->default(0);
            $table->decimal('vat_taka',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->text('footer_note')->nullable();
            $table->text('header_note')->nullable();
            $table->string('inv_subject')->nullable();
            $table->string('status')->nullable();
            $table->integer('invoice_type')->nullable()->comment('1=general, 2=wasa, 3=onetrip, 4=portlink');
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
        Schema::dropIfExists('portlink_invoices');
    }
};
