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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->decimal('fine',10,2)->default(0);
            $table->decimal('mobilebill',10,2)->default(0);
            $table->decimal('loan',10,2)->default(0);
            $table->decimal('cloth',10,2)->default(0);
            $table->decimal('jacket',10,2)->default(0);
            $table->decimal('hr',10,2)->default(0);
            $table->decimal('c_f',10,2)->default(0);
            $table->decimal('medical',10,2)->default(0);
            // uncommontow
            $table->decimal('matterss_pillowCost',10,2)->default(0);
            $table->decimal('tonic_sim',10,2)->default(0);
            $table->decimal('over_paymentCut',10,2)->default(0);
            $table->decimal('bank_charge_exc',10,2)->default(0);
            $table->decimal('dress',10,2)->default(0);
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
        Schema::dropIfExists('deductions');
    }
};