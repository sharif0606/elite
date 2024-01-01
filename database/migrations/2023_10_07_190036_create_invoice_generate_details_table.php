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
            $table->integer('atm_id')->nullable();
            $table->decimal('rate',10,2)->default(0);
            $table->integer('employee_qty')->default(0);
            $table->integer('warking_day')->default(0);
            $table->decimal('total_houres',10,2)->default(0);
            $table->decimal('rate_per_houres',10,2)->default(0);
            $table->decimal('total_amounts',10,2)->default(0);
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
