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
        Schema::table('deductions', function (Blueprint $table) {
            $table->string('fine_rmk')->nullable()->after('fine');
            $table->string('mobilebill_rmk')->nullable()->after('mobilebill');
            $table->string('loan_rmk')->nullable()->after('loan');
            $table->string('cloth_rmk')->nullable()->after('cloth');
            $table->string('jacket_rmk')->nullable()->after('jacket');
            $table->string('hr_rmk')->nullable()->after('hr');
            $table->string('c_f_rmk')->nullable()->after('c_f');
            $table->string('medical_rmk')->nullable()->after('medical');
            $table->string('matterss_pillowCost_rmk')->nullable()->after('matterss_pillowCost');
            $table->string('tonic_sim_rmk')->nullable()->after('tonic_sim');
            $table->string('over_paymentCut_rmk')->nullable()->after('over_paymentCut');
            $table->string('bank_charge_exc_rmk')->nullable()->after('bank_charge_exc');
            $table->string('dress_rmk')->nullable()->after('dress');
            $table->string('excess_mobile_rmk')->nullable()->after('excess_mobile');
            $table->string('mess_rmk')->nullable()->after('mess');
            $table->string('absent_rmk')->nullable()->after('absent');
            $table->string('vacant_rmk')->nullable()->after('vacant');
            $table->string('adv_rmk')->nullable()->after('adv');
            $table->string('stmp_rmk')->nullable()->after('stmp');
            $table->decimal('fuel_bill',10,2)->default(0)->nullable()->after('stmp_rmk');
            $table->string('fuel_bill_rmk')->nullable()->after('fuel_bill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->dropColumn('fine_rmk');
            $table->dropColumn('mobilebill_rmk');
            $table->dropColumn('loan_rmk');
            $table->dropColumn('cloth_rmk');
            $table->dropColumn('jacket_rmk');
            $table->dropColumn('hr_rmk');
            $table->dropColumn('c_f_rmk');
            $table->dropColumn('medical_rmk');
            $table->dropColumn('matterss_pillowCost_rmk');
            $table->dropColumn('tonic_sim_rmk');
            $table->dropColumn('over_paymentCut_rmk');
            $table->dropColumn('bank_charge_exc_rmk');
            $table->dropColumn('dress_rmk');
            $table->dropColumn('excess_mobile_rmk');
            $table->dropColumn('mess_rmk');
            $table->dropColumn('absent_rmk');
            $table->dropColumn('vacant_rmk');
            $table->dropColumn('adv_rmk');
            $table->dropColumn('stmp_rmk');
            $table->dropColumn('fuel_bill');
            $table->dropColumn('fuel_bill_rmk');
        });
    }
};
