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
        // Add columns to advances table
        Schema::table('advances', function (Blueprint $table) {
            $table->decimal('used_amount', 15, 2)->default(0)->after('amount');
            $table->decimal('remaining_amount', 15, 2)->default(0)->after('used_amount');
        });

        // Add columns to invoice_payments table
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->decimal('advance_adjusted', 15, 2)->default(0)->after('received_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove columns from advances table
        Schema::table('advances', function (Blueprint $table) {
            $table->dropColumn(['used_amount', 'remaining_amount']);
        });

        // Remove columns from invoice_payments table
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->dropColumn('advance_adjusted');
        });
    }
};
