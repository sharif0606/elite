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
            $table->string('insurance')->nullable()->after('customer_type');
            $table->string('pf')->nullable()->after('insurance');
            $table->string('stamp')->nullable()->after('pf');
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
            $table->dropColumn('insurance');
            $table->dropColumn('pf');
            $table->dropColumn('stamp');
        });
    }
};
