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
        Schema::table('salary_sheet_details', function (Blueprint $table) {
            $table->integer('year')->after('customer_id')->comment('Year associated with the salary sheet');
            $table->integer('month')->after('year')->comment('Month associated with the salary sheet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_sheet_details', function (Blueprint $table) {
            $table->dropColumn(['year', 'month']);
        });
    }
};
