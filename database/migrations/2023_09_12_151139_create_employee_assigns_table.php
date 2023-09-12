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
        Schema::create('employee_assigns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('generate_unique_id')->nullable();
            $table->integer('employee_id');
            $table->integer('customer_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('employee_assigns');
    }
};
