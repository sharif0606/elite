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
        Schema::create('invoice_generates', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('branch_id')->nullable();
            $table->string('atm_id')->comment('a=all,n=out,id=realId,0=no')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('bill_date')->nullable();
            $table->integer('vat')->nullable();
            $table->decimal('net_salary_rate',10,2)->default(0)->nullable();
            $table->decimal('sub_total_amount',10,2)->default(0);
            $table->decimal('total_tk',10,2)->default(0);
            $table->decimal('vat_taka',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->text('footer_note')->nullable();
            $table->text('header_note')->nullable();
            $table->string('inv_subject')->nullable();
            $table->string('status')->nullable();
            $table->integer('invoice_type')->nullable()->comment('1=general, 2=wasa, 3=onetrip');
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
        Schema::dropIfExists('invoice_generates');
    }
};
