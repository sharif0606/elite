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
        Schema::create('islami_bank_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('islami_bank_invoice_id')->nullable();
            $table->foreign('islami_bank_invoice_id')->references('id')->on('islami_bank_invoices')->onDelete('cascade');
            $table->integer('invoice_id')->nullable();
            $table->unsignedBigInteger('atm_id')->nullable();
            $table->foreign('atm_id')->references('id')->on('atms')->onDelete('cascade');
            $table->integer('employee_id');
            $table->integer('job_post_id');
            $table->string('area')->nullable();
            // $table->string('account_no')->nullable();
            // $table->decimal('duty_rate', 10, 2)->default(0)->nullable();
            $table->decimal('duty', 10, 2)->default(0)->nullable();
            $table->decimal('salary_amount', 10, 2)->default(0)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('shift')->comment('1=A-Shift, 2=B-Shift, 3=C-Shift')->nullable();
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
        Schema::dropIfExists('islami_bank_invoice_details');
    }
};