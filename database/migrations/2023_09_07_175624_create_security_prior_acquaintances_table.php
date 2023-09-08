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
        Schema::create('security_prior_acquaintances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unique();
            $table->integer('bn_in_laws_district_id')->nullable();
            $table->integer('bn_in_laws_upazilla_id')->nullable();
            $table->string('bn_in_laws_village_name')->nullable();
            $table->string('bn_in_laws_post_office')->nullable();
            $table->string('bn_husband_profession')->nullable();
            $table->string('bn_father_profession')->nullable();
            $table->string('bn_landlord_name')->nullable();
            $table->string('bn_landlord_mobile_no')->nullable();
            $table->string('bn_living_dur')->nullable();
            $table->string('bn_passport_no')->nullable();
            $table->string('bn_old_office_name')->nullable();
            $table->string('bn_old_office_address')->nullable();
            $table->string('bn_resign_reason')->nullable();
            $table->integer('bn_resign_letter_status')->nullable();
            $table->integer('bn_service_book_status')->nullable();
            $table->string('bn_service_book_no')->nullable();
            $table->string('bn_old_job_salary')->nullable();
            $table->string('bn_old_job_last_desig')->nullable();
            $table->string('bn_old_job_experience')->nullable();
            $table->string('bn_new_job_transportation')->nullable();
            $table->string('bn_current_living')->nullable();
            $table->string('bn_total_member')->nullable();
            $table->string('bn_mobile_no')->nullable();
            $table->string('bn_solvent_person')->nullable();
            $table->integer('bn_sim_card_reg_status')->nullable();
            $table->integer('bn_case_filed_status')->nullable();
            $table->string('bn_old_job_officer_name')->nullable();
            $table->string('bn_old_job_officer_mobile')->nullable();
            $table->string('bn_old_job_officer_post')->nullable();
            $table->string('bn_identifier_name1')->nullable();
            $table->string('bn_identifier_occupation1')->nullable();
            $table->string('bn_identifier_address1')->nullable();
            $table->string('bn_identifier_phone1')->nullable();
            $table->string('bn_identifier_name2')->nullable();
            $table->string('bn_identifier_occupation2')->nullable();
            $table->string('bn_identifier_address2')->nullable();
            $table->string('bn_identifier_phone2')->nullable();
            $table->string('informant_sing')->nullable();
            $table->string('data_collector_sing')->nullable();
            $table->string('executive_sing')->nullable();
            $table->string('manager_sing')->nullable();
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
        Schema::dropIfExists('security_prior_acquaintances');
    }
};
