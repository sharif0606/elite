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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('product_stock_id')->nullable();
            $table->integer('release_employee_id')->nullable();
            $table->integer('product_issue_id')->nullable();
            $table->integer('product_condem_id')->nullable();
            $table->integer('product_id');
            $table->integer('size_id')->nullable();
            $table->integer('type')->comment('1=new, 2=used')->nullable();
            $table->integer('product_qty');
            $table->date('entry_date')->nullable();
            // $table->date('issue_date')->nullable();
            $table->string('note')->nullable();
            $table->date('maxlife_time')->nullable();
            $table->string('status')->comment('0=in,1=out,2=damage')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
