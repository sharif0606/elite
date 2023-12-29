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
        Schema::create('wasa_employee_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('branch_id')->nullable();
            $table->decimal('add_commission',10,2)->default(0);
            $table->decimal('vat_on_commission',10,2)->default(0);
            $table->decimal('ait_on_commission',10,2)->default(0);
            $table->decimal('vat_on_subtotal',10,2)->default(0);
            $table->decimal('ait_on_subtotal',10,2)->default(0);
            $table->decimal('sub_total_salary',10,2)->default(0);
            //$table->integer('atm_id')->nullable();
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
        Schema::dropIfExists('wasa_employee_assigns');
    }
};
