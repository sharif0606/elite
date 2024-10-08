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
        Schema::create('salary_sheet_details', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->string('online_payment')->nullable()->comment('payment_type');
            $table->decimal('duty_rate',10,2)->nullable()->comment('basic/monthly');
            $table->decimal('duty_qty',10,2)->nullable()->comment('days');
            $table->decimal('duty_amount',10,2)->nullable()->comment('tk');
            $table->decimal('weekly_leave',10,2)->nullable();
            $table->integer('divided_by')->nullable();
            $table->decimal('ot_qty',10,2)->nullable()->comment('ot');
            $table->decimal('ot_rate',10,2)->nullable()->comment('ot');
            $table->decimal('ot_amount',10,2)->nullable()->comment('ot');
            $table->decimal('fixed_ot',10,2)->default(0)->nullable();
            $table->decimal('allownce',10,2)->default(0)->nullable();
            $table->decimal('leave',10,2)->default(0)->nullable();
            $table->decimal('arrear',10,2)->default(0)->nullable();
            $table->decimal('gross_salary',10,2)->default(0)->comment('wages/gross')->nullable();
            $table->decimal('total_salary_of_salary_sheet_four',10,2)->default(0)->nullable();
            // uncommon
            $table->decimal('ht_ribon_alice',10,2)->default(0)->nullable();
            $table->decimal('gun_alice',10,2)->default(0)->nullable();
            $table->decimal('extra_alice',10,2)->default(0)->nullable();
            $table->decimal('bonus',10,2)->default(0)->nullable();
            $table->decimal('donation',10,2)->default(0)->nullable();
            $table->decimal('house_rent',10,2)->default(0)->nullable();
            $table->decimal('medical',10,2)->default(0)->nullable();
            $table->decimal('trans_conve',10,2)->default(0)->nullable();
            $table->decimal('food_allownce',10,2)->default(0)->nullable();
            $table->decimal('gross_wages',10,2)->default(0);
            $table->decimal('total_workingday',10,2)->default(0)->nullable();
            $table->decimal('present_day',10,2)->default(0)->nullable();
            $table->decimal('absent',10,2)->default(0)->nullable();
            $table->decimal('vacant',10,2)->default(0)->nullable();
            $table->decimal('holiday_festival',10,2)->default(0)->nullable();
            $table->decimal('leave_cl',10,2)->default(0)->nullable();
            $table->decimal('leave_sl',10,2)->default(0)->nullable();
            $table->decimal('leave_el',10,2)->default(0)->nullable();
            $table->decimal('total_payable',10,2)->default(0)->nullable();
            $table->decimal('fuel_bill',10,2)->default(0)->nullable();

            $table->decimal('deduction_fine',10,2)->default(0)->nullable();
            $table->decimal('deduction_mobilebill',10,2)->default(0)->nullable();
            $table->decimal('deduction_loan',10,2)->default(0)->nullable();
            $table->decimal('deduction_long_loan',10,2)->default(0)->nullable();
            $table->decimal('deduction_cloth',10,2)->default(0)->nullable();
            $table->decimal('deduction_jacket',10,2)->default(0)->nullable();
            $table->decimal('deduction_hr',10,2)->default(0)->nullable();
            $table->decimal('deduction_traningcost',10,2)->default(0)->nullable();
            $table->decimal('deduction_c_f',10,2)->default(0)->nullable();
            $table->decimal('deduction_medical',10,2)->default(0)->nullable();
            $table->decimal('deduction_ins',10,2)->default(0)->nullable();
            $table->decimal('deduction_p_f',10,2)->default(0)->nullable();
            $table->string('deduction_revenue_stamp')->nullable();
            $table->decimal('deduction_total',10,2)->default(0)->nullable();
            $table->decimal('deduction_mess',10,2)->default(0)->nullable();
            // uncommontow
            $table->decimal('deduction_matterss_pillowCost',10,2)->default(0)->nullable();
            $table->decimal('deduction_tonic_sim',10,2)->default(0)->nullable();
            $table->decimal('deduction_over_paymentCut',10,2)->default(0)->nullable();
            $table->decimal('deduction_dress',10,2)->default(0)->nullable();
            $table->decimal('deduction_banck_charge',10,2)->default(0)->nullable();
            $table->decimal('deduction_absent',10,2)->default(0)->nullable();
            $table->decimal('deduction_vacant',10,2)->default(0)->nullable();
            $table->decimal('deduction_adv',10,2)->default(0)->nullable();
            $table->decimal('ot_rate_basicDuble',10,2)->default(0)->nullable();

            $table->decimal('net_salary',10,2)->default(0)->nullable();
            $table->decimal('common_net_salary',10,2)->default(0)->nullable();
            $table->string('sing_of_ind')->nullable();
            $table->string('sing_account')->nullable();
            $table->string('remark')->nullable();
            $table->string('zone')->nullable();
            $table->string('status')->default(0)->nullable();
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
        Schema::dropIfExists('salary_sheet_details');
    }
};
