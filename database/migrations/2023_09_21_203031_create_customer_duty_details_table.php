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
        Schema::create('customer_duty_details', function (Blueprint $table) {
            $table->id();
            $table->integer('customerduty_id');
            $table->integer('employee_id');
            $table->integer('customer_id')->nullable();
            $table->integer('job_post_id')->nullable();
            $table->decimal('duty_rate',10,2)->default(0);
            $table->decimal('ot_rate',10,2)->default(0);
            $table->integer('duty_qty');
            $table->integer('ot_qty');
            $table->decimal('duty_amount',10,2)->default(0);
            $table->decimal('ot_amount',10,2)->default(0);
            $table->decimal('total_amount',10,2)->default(0);
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
        Schema::dropIfExists('customer_duty_details');
    }
};
