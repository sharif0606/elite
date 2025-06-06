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
        Schema::create('islami_bank_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('branch_id')->nullable();
            $table->decimal('sub_total_salary', 10, 2)->default(0);
            $table->decimal('add_commission', 10, 2)->default(0);
            $table->decimal('add_commission_tk', 10, 2)->default(0);
            $table->decimal('vat_on_commission', 10, 2)->default(0);
            $table->decimal('vat_on_commission_tk', 10, 2)->default(0);
            $table->decimal('ait_on_commission', 10, 2)->default(0);
            $table->decimal('ait_on_commission_tk', 10, 2)->default(0);
            $table->decimal('vat_ait_on_commission', 10, 2)->default(0);
            $table->decimal('vat_ait_on_commission_tk', 10, 2)->default(0);
            $table->decimal('vat_on_subtotal', 10, 2)->default(0);
            $table->decimal('vat_on_subtotal_tk', 10, 2)->default(0);
            $table->decimal('ait_on_subtotal', 10, 2)->default(0);
            $table->decimal('ait_on_subtotal_tk', 10, 2)->default(0);
            $table->decimal('grand_total_tk', 10, 2)->default(0);
            $table->string('footer_note')->nullable();
            $table->date('bill_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('atm_id')->nullable();
            $table->foreign('atm_id')->references('id')->on('atms')->onDelete('cascade');
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
        Schema::dropIfExists('islami_bank_invoices');
    }
};