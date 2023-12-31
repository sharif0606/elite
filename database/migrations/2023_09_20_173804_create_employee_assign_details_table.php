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
        Schema::create('employee_assign_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_assign_id')->nullable();
			$table->foreign('employee_assign_id')->references('id')->on('employee_assigns')->onDelete('cascade');
            $table->integer('atm_id')->nullable();
            $table->integer('job_post_id');
            $table->integer('qty');
            $table->string('rate');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('hours')->nullable()->comment('1=8,2=12');
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
        Schema::dropIfExists('employee_assign_details');
    }
};
