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
        Schema::table('journal_vouchers', function (Blueprint $table) {
            $table->string('vou_no')->nullable()->after('credit_sum')->comment('Voucher Number');
            $table->string('vehicle_no')->nullable()->after('vou_no')->comment('Vehicle Number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_vouchers', function (Blueprint $table) {
            $table->dropColumn(['vou_no', 'vehicle_no']);
        });
    }
};
