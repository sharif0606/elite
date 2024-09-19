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
        Schema::create('release_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('resign_date')->nullable();
            $table->text('others_note')->nullable();
            $table->string('issue_submiter_mobile')->nullable();
            $table->string('cus_authority_comment')->nullable();
            $table->string('zone_commander_comment')->nullable();
            $table->decimal('amount_deducted',10,2)->default(0)->nullable();
            $table->text('due_salary')->nullable();
            $table->decimal('due_salary_amount',10,2)->default(0)->nullable();
            $table->text('due_salary_comment')->nullable();
            $table->text('pf_a')->nullable();
            $table->decimal('pf_a_amount',10,2)->default(0)->nullable();
            $table->text('pf_a_comment')->nullable();
            $table->text('pf_b')->nullable();
            $table->decimal('pf_b_amount',10,2)->default(0)->nullable();
            $table->text('pf_b_comment')->nullable();
            $table->text('pf_c')->nullable();
            $table->decimal('pf_c_amount',10,2)->default(0)->nullable();
            $table->text('pf_c_comment')->nullable();
            $table->text('leave')->nullable();
            $table->decimal('leave_amount',10,2)->default(0)->nullable();
            $table->text('leave_comment')->nullable();
            $table->text('addmission')->nullable();
            $table->decimal('addmission_amount',10,2)->default(0)->nullable();
            $table->text('addmission_comment')->nullable();
            $table->text('others')->nullable();
            $table->decimal('others_amount',10,2)->default(0)->nullable();
            $table->text('others_comment')->nullable();
            $table->decimal('subtotal',10,2)->default(0)->nullable();
            $table->decimal('final_deducted',10,2)->default(0)->nullable();
            $table->decimal('final_total',10,2)->default(0)->nullable();
            $table->string('wash_cost')->nullable();
            $table->decimal('wash_cost_amount',10,2)->default(0)->nullable();
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
        Schema::dropIfExists('release_employees');
    }
};
