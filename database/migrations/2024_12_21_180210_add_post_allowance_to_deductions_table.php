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
        Schema::table('deductions', function (Blueprint $table) {
            $table->decimal('post_allowance', 10, 2)->nullable()->after('fuel_bill_rmk'); // Replace 'column_name' with the column after which you want to add 'post_allowance'
            $table->text('post_allowance_rmk')->nullable()->after('post_allowance'); // Add after 'post_allowance'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->dropColumn('post_allowance');
            $table->dropColumn('post_allowance_rmk');
        });
    }
};
