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
        Schema::create('guard_assign_details', function (Blueprint $table) {
            $table->id();
            $table->integer('guard_id');
            $table->integer('job_post_id');
            $table->integer('qty');
            $table->string('rate');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('hours')->nullable()->comment('1=8,2=12');
            $table->string('employee_payment')->nullable();
            $table->string('ot_rate')->nullable();
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
        Schema::dropIfExists('guard_assign_details');
    }
};
