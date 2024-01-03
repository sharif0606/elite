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
        Schema::create('onetrip_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ontrip_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('service')->nullable();
            $table->decimal('rate',10,2)->default(0);
            $table->date('period')->nullable();
            $table->string('trip')->nullable();
            $table->decimal('amount',10,2)->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('onetrip_invoice_details');
    }
};
