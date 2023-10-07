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
        Schema::create('invoice_generate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('job_post_id');
            $table->decimal('rate',10,2)->default(0);
            $table->integer('employee_qty')->default(0);
            $table->integer('warking_day')->default(0);
            $table->decimal('total_houres',10,2)->default(0);
            $table->decimal('rate_per_houres',10,2)->default(0);
            $table->decimal('total_amounts',10,2)->default(0);
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
        Schema::dropIfExists('invoice_generate_details');
    }
};
