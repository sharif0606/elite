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
        Schema::table('customers', function (Blueprint $table) {
            $table->decimal('medical', 10, 2)->after('customer_type')->nullable()->default(0.00);
            $table->decimal('food_allownce', 10, 2)->after('medical')->nullable()->default(0.00);
            $table->decimal('trans_conve', 10, 2)->after('food_allownce')->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['medical', 'food_allownce', 'trans_conve']);
        });
    }
};
