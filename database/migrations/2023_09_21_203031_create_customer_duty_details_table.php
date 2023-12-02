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
            $table->unsignedBigInteger('company_id')->nullable()->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable()->index()->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable()->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
