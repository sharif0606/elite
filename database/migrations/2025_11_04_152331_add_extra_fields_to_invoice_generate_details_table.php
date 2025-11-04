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
            $table->decimal('take_home_salary', 15, 2)->nullable()->after('job_post_id');
            $table->decimal('material_support_cost', 15, 2)->nullable()->after('take_home_salary');
            $table->decimal('reliver_cost', 15, 2)->nullable()->after('material_support_cost');
            $table->decimal('overhead_service_charge', 15, 2)->nullable()->after('reliver_cost');
            $table->tinyInteger('type')->nullable()->comment('1 = fixed, 2 = ot')->after('overhead_service_charge');
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
            $table->dropColumn([
                'take_home_salary',
                'material_support_cost',
                'reliver_cost',
                'overhead_service_charge',
                'type',
            ]);
        });
    }
};
