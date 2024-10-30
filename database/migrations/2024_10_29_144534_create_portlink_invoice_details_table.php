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
        Schema::create('portlink_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('portlink_invoice_id');
            $table->integer('job_post_id');
            $table->decimal('rate',10,2)->default(0)->nullable();
            $table->decimal('commission',10,2)->default(0)->nullable();
            $table->integer('employee_qty')->default(0)->nullable();
            $table->integer('divide_by')->nullable();
            $table->decimal('duty_day',10,2)->default(0)->nullable();
            $table->decimal('type_houre',14,2)->nullable();
            $table->decimal('net_salary_amount',14,2)->default(0);
            $table->decimal('net_commission_amount',14,2)->default(0);
            $table->decimal('total_amounts',14,2)->default(0);
            $table->date('st_date')->nullable();
            $table->date('ed_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('portlink_invoice_details');
    }
};
