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
        Schema::table('employee_assign_details', function (Blueprint $table) {
            $table->decimal('agency_com', 15, 2)
                ->nullable()
                ->after('type'); // add after the "type" column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_assign_details', function (Blueprint $table) {
            $table->dropColumn('agency_com');
        });
    }
};
