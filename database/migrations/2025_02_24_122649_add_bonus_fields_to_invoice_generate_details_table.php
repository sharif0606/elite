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
        Schema::table('invoice_generate_details', function (Blueprint $table) {
             $table->string('bonus_type')->nullable()->after('employee_qty'); // e.g., 'fixed' or 'percentage'
             $table->decimal('bonus_amount', 10, 2)->nullable()->after('bonus_type'); // Store bonus amount
             $table->tinyInteger('bonus_for')->nullable()->comment('1=>Eid Ul FITR, 2=>EID UL AZHA')->after('bonus_amount'); // Store bonus amount
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_generate_details', function (Blueprint $table) {
            $table->dropColumn(['bonus_type', 'bonus_amount','bonus_for']);
        });
    }
};
