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
        Schema::table('islami_bank_emp_assigns', function (Blueprint $table) {
            $table->decimal('add_commission', 10, 2)->nullable()->default(0)->change();
            $table->decimal('vat_on_commission', 10, 2)->nullable()->default(0)->change();
            $table->decimal('ait_on_commission', 10, 2)->nullable()->default(0)->change();
            $table->decimal('vat_on_subtotal', 10, 2)->nullable()->default(0)->change();
            $table->decimal('ait_on_subtotal', 10, 2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('islami_bank_emp_assigns', function (Blueprint $table) {});
    }
};