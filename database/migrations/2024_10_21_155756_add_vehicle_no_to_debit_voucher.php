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
        Schema::table('debit_vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_no')->nullable()->after('credit_sum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debit_vouchers', function (Blueprint $table) {
            $table->dropColumn(['vehicle_no']);
        });
    }
};
