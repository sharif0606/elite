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
        Schema::create('wasa_employee_assign_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wasa_employee_assign_id')->nullable();
			$table->foreign('wasa_employee_assign_id')->references('id')->on('wasa_employee_assigns')->onDelete('cascade');
            $table->integer('atm_id')->nullable();
            $table->integer('employee_id');
            $table->integer('job_post_id');
            $table->string('area');
            $table->string('employee_name');
            $table->decimal('duty_rate',10,2)->default(0);
            $table->integer('duty');
            $table->string('account_no');
            $table->decimal('salary_amount',10,2)->default(0)->nullable();
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
        Schema::dropIfExists('wasa_employee_assign_details');
    }
};
