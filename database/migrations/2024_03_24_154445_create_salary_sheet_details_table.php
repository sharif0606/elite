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
            $table->string('online_payment')->nullable()->comment('payment_type');
            $table->decimal('duty_rate',10,2)->nullable()->comment('basic/monthly');
            $table->decimal('duty_qty',10,2)->nullable()->comment('days');
            $table->decimal('duty_amount',10,2)->nullable()->comment('tk');
            $table->decimal('weekly_leave',10,2)->nullable();
            $table->decimal('ot_qty',10,2)->nullable()->comment('ot');
            $table->decimal('ot_rate',10,2)->nullable()->comment('ot');
            $table->decimal('ot_amount',10,2)->nullable()->comment('ot');
            $table->decimal('fixed_ot',10,2)->default(0)->nullable();
            $table->decimal('allownce',10,2)->default(0)->nullable();
            $table->decimal('leave',10,2)->default(0)->nullable();
            $table->decimal('arrear',10,2)->default(0)->nullable();
            $table->decimal('gross_salary',10,2)->default(0)->comment('wages/gross')->nullable();
            // uncommon
            $table->decimal('ht_ribon_alice',10,2)->default(0)->nullable();
            $table->decimal('gun_alice',10,2)->default(0)->nullable();
            $table->decimal('extra_alice',10,2)->default(0)->nullable();
            $table->decimal('bonus',10,2)->default(0)->nullable();
            $table->decimal('donation',10,2)->default(0)->nullable();

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
            // uncommontow
            $table->decimal('deduction_matterss_pillowCost',10,2)->default(0)->nullable();
            $table->decimal('deduction_tonic_sim',10,2)->default(0)->nullable();
            $table->decimal('deduction_over_paymentCut',10,2)->default(0)->nullable();
            $table->decimal('deduction_dress',10,2)->default(0)->nullable();
            $table->decimal('deduction_banck_charge',10,2)->default(0)->nullable();

            $table->decimal('net_salary',10,2)->default(0)->nullable();
            $table->string('sing_of_ind')->nullable();
            $table->string('sing_account')->nullable();
            $table->string('remark')->nullable();
            $table->string('zone')->nullable();
            $table->string('status')->default(0)->nullable();

            // $table->string('id_no')->nullable();
            // $table->date('joning_date')->nullable();
            // $table->string('rank_id')->nullable()->comment('designation/rank');
            // $table->string('name')->nullable();
            // $table->decimal('monthly_salary',10,2)->default(0)->comment('basic/monthly');
           // $table->string('ot_day')->nullable();
            //$table->string('ot_hrs')->nullable();
           // $table->decimal('ot_rate',10,2)->default(0)->comment('ot');
            //$table->decimal('ot_amount',10,2)->default(0)->comment('ot');
            // $table->decimal('gross_salary',10,2)->default(0)->comment('wages/gross');
            // $table->decimal('working_day',10,2)->default(0);
            // $table->decimal('fre_day',10,2)->default(0);
            // $table->decimal('absent',10,2)->default(0);
            // $table->decimal('vacant',10,2)->default(0);
            // $table->decimal('holyday',10,2)->default(0);
            // $table->decimal('festival',10,2)->default(0);
            // $table->decimal('net_salary',10,2)->default(0)->comment('wages/payble/salary');
            // $table->decimal('days',10,2)->default(0)->comment('');
            // $table->decimal('fixed_ot',10,2)->default(0);
            // $table->decimal('allownce',10,2)->default(0);
            // $table->decimal('arrear',10,2)->default(0);
            // $table->string('remarks')->nullable();
            // $table->string('zone_no')->nullable();
            // $table->decimal('ht_ribon_alice',10,2)->default(0);
            // $table->decimal('gun_alice',10,2)->default(0);
            // $table->decimal('extra_alice',10,2)->default(0);
            // $table->decimal('bonus',10,2)->default(0);
            // $table->decimal('donation',10,2)->default(0);
            // $table->decimal('house_rent',10,2)->default(0)->comment('houseRent50%');
            // $table->decimal('medical_allowance',10,2)->default(0);
            // $table->decimal('post_allow',10,2)->default(0);
            // $table->decimal('fuel_bill',10,2)->default(0);
            // $table->decimal('trans_conve',10,2)->default(0);
            // $table->decimal('leave',10,2)->default(0);
            // $table->decimal('leave_cl',10,2)->default(0);
            // $table->decimal('leave_sl',10,2)->default(0);
            // $table->decimal('leave_el',10,2)->default(0);
            // $table->string('signature')->nullable()->comment('individual');
            // $table->string('signature_accounts')->nullable()->comment('individual');

            // $table->decimal('pf_d',10,2)->default(0);
            // $table->decimal('fine_d',10,2)->default(0);
            // $table->decimal('loan_d',10,2)->default(0);
            // $table->decimal('cf_d',10,2)->default(0);
            // $table->decimal('medical_d',10,2)->default(0);
            // $table->decimal('jacket_d',10,2)->default(0);
            // $table->decimal('traning_cost_d',10,2)->default(0);
            // $table->decimal('hr_d',10,2)->default(0);
            // $table->decimal('ins_d',10,2)->default(0);
            // $table->decimal('stamp_d',10,2)->default(0);
            // $table->decimal('cloth_d',10,2)->default(0);
            // $table->decimal('long_loan_d',10,2)->default(0);
            // $table->decimal('mobile_bill_d',10,2)->default(0);
            // $table->decimal('excess_mobile_d',10,2)->default(0);
            // $table->decimal('total_d',10,2)->default(0);
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
