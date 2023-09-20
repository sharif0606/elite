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
        Schema::create('employee_rate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_rate_id');
            $table->integer('job_post_id');
            $table->string('hours')->nullable()->comment('1=8,2=12');
            $table->decimal('duty_rate',10,2)->default(0);
            $table->decimal('ot_rate',10,2)->default(0);
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
        Schema::dropIfExists('employee_rate_details');
    }
};
