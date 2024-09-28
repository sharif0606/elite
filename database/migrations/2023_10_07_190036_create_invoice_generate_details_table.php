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
        Schema::create('invoice_generate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('job_post_id');
            $table->integer('atm_id')->nullable(); //real atm id
            $table->decimal('rate',10,2)->default(0)->nullable();
            $table->integer('employee_qty')->default(0)->nullable();
            $table->decimal('warking_day',10,2)->default(0)->nullable();
            $table->decimal('actual_warking_day',10,2)->default(0)->nullable();
            $table->decimal('duty_day',10,2)->default(0)->nullable();
            $table->decimal('total_houres',14,2)->default(0)->nullable();
            $table->decimal('type_houre',14,2)->comment('type=8 or 12')->nullable();
            $table->decimal('rate_per_houres',14,2)->default(0)->nullable();
            $table->decimal('total_amounts',14,2)->default(0);
            $table->date('st_date')->nullable();
            $table->date('ed_date')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('company_branch_id')->nullable()->index()->foreign('company_branch_id')->references('id')->on('branches')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_generate_details');
    }
};
