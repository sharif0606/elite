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
        Schema::table('employee_rate_details', function (Blueprint $table) {
            // Adding branch_id and atm_id columns
            $table->unsignedBigInteger('branch_id')->nullable()->after('employee_rate_id');
            $table->unsignedBigInteger('atm_id')->nullable()->after('branch_id');

            // Optional: You can add foreign key constraints if needed
            // $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            // $table->foreign('atm_id')->references('id')->on('atms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_rate_details', function (Blueprint $table) {
            // Dropping the added columns if migration is rolled back
            $table->dropColumn(['branch_id', 'atm_id']);
        });
    }
};
