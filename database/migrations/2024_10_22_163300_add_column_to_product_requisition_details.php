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
        Schema::table('product_requisition_details', function (Blueprint $table) {
            $table->integer('deposite_product_qty')->after('product_qty')->nullable();
            $table->integer('deposite_size_id')->after('deposite_product_qty')->nullable();
            $table->integer('deposite_type')->comment('1=new, 2=used')->after('deposite_size_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_requisition_details', function (Blueprint $table) {
            $table->dropColumn('deposite_size_id');
            $table->dropColumn('deposite_type');
            $table->dropColumn('deposite_product_qty');
        });
    }
};
