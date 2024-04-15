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
        Schema::create('long_loans', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->decimal('loan_amount',10,2)->default(0);
            $table->date('purchase_date')->nullable();
            $table->date('installment_date')->nullable();
            $table->integer('number_of_installment')->nullable();
            $table->decimal('perinstallment_amount',10,2)->default(0);
            $table->date('end_date')->nullable();
            $table->decimal('loan_balance',10,2)->default(0);
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('long_loans');
    }
};
