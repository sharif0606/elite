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
        Schema::create('portlink_invoice_lesses', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('portlink_invoice_id');
            $table->text('less_description')->nullable();
            $table->decimal('less_rate',10,2)->default(0)->nullable();
            $table->decimal('less_commission',10,2)->default(0)->nullable();
            $table->decimal('count_hour',10,2)->default(0)->nullable();
            $table->decimal('net_less',10,2)->default(0)->nullable();
            $table->decimal('commission_less',10,2)->default(0)->nullable();
            $table->decimal('total_less',10,2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portlink_invoice_lesses');
    }
};
