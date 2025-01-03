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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('profile_img')->nullable();
            $table->string('signature_img')->nullable();
            $table->string('admission_id_no')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('salary_joining_date')->nullable();

            $table->text('bn_applicants_name')->nullable();
            $table->text('bn_fathers_name')->nullable();
            $table->text('bn_mothers_name')->nullable();
            $table->integer('bn_parm_district_id')->nullable();
            $table->integer('bn_parm_upazila_id')->nullable();
            $table->integer('bn_parm_union_id')->nullable();
            $table->integer('bn_parm_ward_id')->nullable();
            $table->string('bn_parm_holding_name')->nullable();
            $table->string('bn_parm_village_name')->nullable();
            $table->text('bn_parm_post_ofc')->nullable();
            $table->text('bn_parm_phone_my')->nullable();
            $table->text('bn_parm_phone_alt')->nullable();
            $table->text('bn_pre_district_id')->nullable();
            $table->text('bn_pre_upazila_id')->nullable();
            $table->text('bn_pre_union_id')->nullable();
            $table->text('bn_pre_ward_no')->nullable();
            $table->text('bn_pre_holding_no')->nullable();
            $table->text('bn_pre_village_name')->nullable();
            $table->text('bn_pre_post_ofc')->nullable();
            $table->text('bn_identification_mark')->nullable();
            $table->text('bn_edu_qualification')->nullable();
            $table->integer('bn_blood_id')->nullable();
            $table->integer('employee_type')->nullable();
            $table->integer('designation_id')->nullable();
            $table->decimal('gross_salary',10,2)->default(0)->nullable();
            $table->decimal('ot_salary',10,2)->default(0)->nullable();
            $table->integer('salary_serial')->nullable();
            $table->date('bn_dob')->nullable();
            $table->integer('bn_age')->nullable();
            $table->string('bn_birth_certificate')->nullable();
            $table->string('bn_nid_no')->nullable();
            $table->string('bn_nationality')->nullable();
            $table->string('bn_religion')->nullable();
            $table->string('bn_height_foot')->nullable();
            $table->string('bn_height_inc')->nullable();
            $table->string('bn_weight_kg')->nullable();
            $table->string('bn_weight_pounds')->nullable();
            $table->string('bn_experience')->nullable();
            $table->string('bn_marital_status')->comment('1=unmarried,2=married')->nullable();
            $table->string('bn_legacy_name')->nullable();
            $table->string('bn_legacy_relation')->nullable();
            $table->string('bn_reference_admittee')->nullable();
            $table->string('bn_reference_adm_phone')->nullable();
            $table->string('bn_reference_adm_adress')->nullable();
            $table->string('bn_jobpost_id')->nullable();

            $table->string('bn_spouse_name')->nullable();
            $table->string('bn_song_name')->nullable();
            $table->string('bn_daughters_name')->nullable();

            $table->decimal('bn_post_allowance',10,2)->nullable();
            $table->decimal('bn_food_allowance',10,2)->default(0)->nullable();
            $table->decimal('bn_fuel_bill',10,2)->default(0)->nullable();
            $table->decimal('bn_traning_cost',14,2)->nullable();
            $table->decimal('bn_remaining_cost',14,2)->nullable();
            $table->integer('bn_traning_cost_byMonth')->comment('detaction by 6 month')->default(6);
            $table->text('bn_bank_name')->nullable();
            $table->text('bn_brance_name')->nullable();
            $table->text('bn_ac_no')->nullable();
            $table->string('bn_ac_name')->nullable();
            $table->string('second_bank_name',100)->nullable();
            $table->string('second_brance_name',100)->nullable();
            $table->string('second_ac_no',100)->nullable();
            $table->string('second_ac_name',100)->nullable();
            $table->text('bn_routing_number')->nullable();
            $table->integer('salary_prepared_type')->nullable();
            $table->tinyText('remarks')->nullable();
            $table->decimal('insurance',14,2)->default(130);
            $table->decimal('p_f',14,2)->comment('by 6 month from joining')->default(200);
/*End Of Bangla Form */

            $table->string('en_applicants_name')->nullable();
            $table->string('en_fathers_name')->nullable();
            $table->string('en_mothers_name')->nullable();
            // $table->integer('en_parm_district_id')->nullable();
            // $table->integer('en_parm_upazila_id')->nullable();
            // $table->integer('en_parm_union_id')->nullable();
            // $table->integer('en_parm_ward_id')->nullable();
            $table->string('en_parm_holding_name')->nullable();
            $table->string('en_parm_village_name')->nullable();
            $table->string('en_parm_post_ofc')->nullable();
            $table->string('en_parm_phone_my')->nullable();
            $table->string('en_parm_phone_alt')->nullable();

            // $table->integer('en_pre_district_id')->nullable();
            // $table->integer('en_pre_upazila_id')->nullable();
            // $table->integer('en_pre_union_id')->nullable();
            // $table->integer('en_pre_ward_id')->nullable();

            $table->string('en_pre_holding_no')->nullable();
            $table->string('en_pre_village_name')->nullable();
            $table->string('en_pre_post_ofc')->nullable();
            $table->string('en_identification_mark')->nullable();
            $table->string('en_edu_qualification')->nullable();
            //$table->string('en_blood_id')->nullable();
            $table->date('en_dob')->nullable();
            $table->integer('en_age')->nullable();
            $table->string('en_birth_certificate')->nullable();
            $table->string('en_nid_no')->nullable();
            $table->string('en_nationality')->nullable();
            //$table->string('en_religion')->nullable();
            $table->string('en_height_foot')->nullable();
            $table->string('en_height_inc')->nullable();
            $table->string('en_weight_kg')->nullable();
            $table->string('en_weight_pounds')->nullable();
            $table->string('en_experience')->nullable();
            $table->string('en_marital_status')->comment('1=unmarried,2=married')->nullable();
            $table->string('en_legacy_name')->nullable();
            $table->string('en_legacy_relation')->nullable();
            $table->string('en_reference_admittee')->nullable();
            $table->string('en_reference_adm_phone')->nullable();
            $table->string('en_reference_adm_adress')->nullable();
            $table->string('en_place_of_posting')->nullable();
            $table->integer('en_is_any_case')->nullable();
            $table->integer('en_is_criminal_court')->nullable();
            $table->integer('en_any_other_info')->nullable();
            //$table->string('en_jobpost_id')->nullable();

            $table->string('en_spouse_name')->nullable();
            $table->string('en_song_name')->nullable();
            $table->string('en_daughters_name')->nullable();
            $table->boolean('status')->default(1)->comment('1=>active 2=>inactive');

            $table->boolean('bn_cer_gender')->nullable()->comment('0=>male ,1=>female');
            $table->string('bn_cer_physical_ability')->nullable();
            $table->string('concerned_person_sign')->nullable();
            $table->string('bn_doctor_sign')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
