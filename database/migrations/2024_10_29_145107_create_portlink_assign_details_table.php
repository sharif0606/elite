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
        Schema::create('portlink_assign_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portlink_assign_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->integer('job_post_id');
            $table->integer('qty');
            $table->decimal('rate',10,2);
            $table->decimal('commission',10,2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('hours')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('portlink_assign_details');
    }
};
