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
            $table->decimal('absent', 10, 2)->default(0)->nullable()->after('ot_qty');
            $table->decimal('vacant', 10, 2)->default(0)->nullable()->after('absent');
            $table->decimal('holiday_festival', 10, 2)->default(0)->nullable()->after('vacant');
            $table->decimal('leave_cl', 10, 2)->default(0)->nullable()->after('holiday_festival');
            $table->decimal('leave_sl', 10, 2)->default(0)->nullable()->after('leave_cl');
            $table->decimal('leave_el', 10, 2)->default(0)->nullable()->after('leave_sl');
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
            $table->dropColumn(['absent', 'vacant', 'holiday_festival', 'leave_cl', 'leave_sl', 'leave_el']);
        });
    }
};
