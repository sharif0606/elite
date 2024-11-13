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
        Schema::create('south_bangla_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('south_bangla_invoice_id');
            $table->integer('employee_id');
            $table->integer('job_post_id');
            $table->decimal('rate',10,2)->default(0)->nullable();
            $table->decimal('service',10,2)->default(0)->nullable();
            $table->integer('divide_by')->nullable();
            $table->decimal('duty_day',10,2)->default(0)->nullable();
            $table->decimal('net_payment_amount',14,2)->default(0);
            $table->decimal('net_service_amount',14,2)->default(0);
            $table->decimal('total_amounts',14,2)->default(0);
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('south_bangla_invoice_details');
    }
};
