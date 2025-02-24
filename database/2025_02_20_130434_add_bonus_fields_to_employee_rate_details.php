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
            $table->string('bonus_type')->nullable()->after('ot_rate'); // e.g., 'fixed' or 'percentage'
            $table->decimal('bonus_amount', 10, 2)->nullable()->after('bonus_type'); // Store bonus amount
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
            $table->dropColumn(['bonus_type', 'bonus_amount']);
        });
    }
};
