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
            $table->decimal('agency_com', 15, 2)
                ->nullable()
                ->after('type');  // position after type
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
            $table->dropColumn('agency_com');
        });
    }
};
