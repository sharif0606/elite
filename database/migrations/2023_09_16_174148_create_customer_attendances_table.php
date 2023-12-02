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
        Schema::create('customer_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('employee_id');
            $table->integer('customer_duty_id');
            $table->integer('post_id');
            $table->decimal('ot_rate',10,2)->default(0);
            $table->decimal('duty_rate',10,2)->default(0);
            $table->string('duty_qty');
            $table->string('ot_qty')->nullable();
            $table->decimal('duty_amount',10,2)->default(0);
            $table->decimal('ot_amount',10,2)->nullable();
            $table->decimal('total_amount',10,2)->default(0);
            $table->date('start_date');
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
        Schema::dropIfExists('customer_attendances');
    }
};
