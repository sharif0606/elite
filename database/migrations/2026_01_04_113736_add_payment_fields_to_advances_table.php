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
        Schema::table('advances', function (Blueprint $table) {
            $table->integer('payment_type')->nullable()->comment('1=Cash, 2=Pay Order, 3=Fund Transfer, 4=Online Pay')->after('taken_date');
            $table->unsignedBigInteger('deposit_bank')->nullable()->after('payment_type');
            $table->string('bank_name')->nullable()->after('deposit_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advances', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'deposit_bank', 'bank_name']);
        });
    }
};
