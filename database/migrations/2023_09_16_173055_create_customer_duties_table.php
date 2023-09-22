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
        Schema::create('customer_duties', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('total_duty');
            $table->string('total_ot');
            $table->decimal('total_duty_amount',10,2)->default(0);
            $table->decimal('total_ot_amount',10,2)->default(0);
            $table->decimal('finall_amount',10,2)->default(0);
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
        Schema::dropIfExists('customer_duties');
    }
};
