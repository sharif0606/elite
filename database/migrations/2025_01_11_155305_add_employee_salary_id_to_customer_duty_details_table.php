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
        Schema::table('customer_duty_details', function (Blueprint $table) {
            // Add the `employee_salary_id` column after `job_post_id` with a comment
            $table->unsignedBigInteger('employee_salary_id')
                ->after('job_post_id')
                ->comment('primary_key_of_employee_salary_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_duty_details', function (Blueprint $table) {
            // Drop the column if rolling back
            $table->dropColumn('employee_salary_id');
        });
    }
};
