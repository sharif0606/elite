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
        Schema::create('salary_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('sl')->nullable();
            $table->string('id_no')->nullable();
            $table->date('joning_date')->nullable();
            $table->string('rank_id')->nullable()->comment('designation/rank');
            $table->string('name')->nullable();
            $table->decimal('monthly_salary',10,2)->default(0)->comment('basic/monthly');
            $table->string('ot_day')->nullable();
            $table->string('ot_hrs')->nullable();
            $table->decimal('ot_rate',10,2)->default(0)->comment('ot');
            $table->decimal('ot_amount',10,2)->default(0)->comment('ot');
            $table->decimal('gross_salary',10,2)->default(0)->comment('wages/gross');
            $table->decimal('working_day',10,2)->default(0);
            $table->decimal('fre_day',10,2)->default(0);
            $table->decimal('absent',10,2)->default(0);
            $table->decimal('vacant',10,2)->default(0);
            $table->decimal('holyday',10,2)->default(0);
            $table->decimal('festival',10,2)->default(0);
            $table->decimal('net_salary',10,2)->default(0)->comment('wages/payble/salary');
            $table->string('online_payment')->nullable();
            $table->string('payment_type')->nullable();
            $table->decimal('days',10,2)->default(0)->comment('');
            $table->decimal('fixed_ot',10,2)->default(0);
            $table->decimal('allownce',10,2)->default(0);
            $table->decimal('arrear',10,2)->default(0);
            $table->string('remarks')->nullable();
            $table->string('zone_no')->nullable();
            $table->decimal('ht_ribon_alice',10,2)->default(0);
            $table->decimal('gun_alice',10,2)->default(0);
            $table->decimal('extra_alice',10,2)->default(0);
            $table->decimal('bonus',10,2)->default(0);
            $table->decimal('donation',10,2)->default(0);
            $table->decimal('house_rent',10,2)->default(0)->comment('houseRent50%');
            $table->decimal('medical_allowance',10,2)->default(0);
            $table->decimal('post_allow',10,2)->default(0);
            $table->decimal('fuel_bill',10,2)->default(0);
            $table->decimal('trans_conve',10,2)->default(0);
            $table->decimal('leave',10,2)->default(0);
            $table->decimal('leave_cl',10,2)->default(0);
            $table->decimal('leave_sl',10,2)->default(0);
            $table->decimal('leave_el',10,2)->default(0);
            $table->string('signature')->nullable()->comment('individual');
            $table->string('signature_accounts')->nullable()->comment('individual');

            $table->decimal('pf_d',10,2)->default(0);
            $table->decimal('fine_d',10,2)->default(0);
            $table->decimal('loan_d',10,2)->default(0);
            $table->decimal('cf_d',10,2)->default(0);
            $table->decimal('medical_d',10,2)->default(0);
            $table->decimal('jacket_d',10,2)->default(0);
            $table->decimal('traning_cost_d',10,2)->default(0);
            $table->decimal('hr_d',10,2)->default(0);
            $table->decimal('ins_d',10,2)->default(0);
            $table->decimal('stamp_d',10,2)->default(0);
            $table->decimal('cloth_d',10,2)->default(0);
            $table->decimal('long_loan_d',10,2)->default(0);
            $table->decimal('mobile_bill_d',10,2)->default(0);
            $table->decimal('excess_mobile_d',10,2)->default(0);
            $table->decimal('total_d',10,2)->default(0);
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
        Schema::dropIfExists('salary_sheets');
    }
};
