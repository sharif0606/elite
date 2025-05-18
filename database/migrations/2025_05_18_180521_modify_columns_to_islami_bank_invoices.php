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
        Schema::table('islami_bank_invoices', function (Blueprint $table) {
            $table->decimal('add_commission', 10, 2)->default(0)->nullable()->change();
            $table->decimal('add_commission_tk', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_on_commission', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_on_commission_tk', 10, 2)->default(0)->nullable()->change();
            $table->decimal('ait_on_commission', 10, 2)->default(0)->nullable()->change();
            $table->decimal('ait_on_commission_tk', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_ait_on_commission', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_ait_on_commission_tk', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_on_subtotal', 10, 2)->default(0)->nullable()->change();
            $table->decimal('vat_on_subtotal_tk', 10, 2)->default(0)->nullable()->change();
            $table->decimal('ait_on_subtotal', 10, 2)->default(0)->nullable()->change();
            $table->decimal('ait_on_subtotal_tk', 10, 2)->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('islami_bank_invoices', function (Blueprint $table) {
            //
        });
    }
};