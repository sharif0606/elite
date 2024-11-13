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
        Schema::create('south_bangla_assign_details', function (Blueprint $table) {
            $table->id();
            $table->integer('south_bangla_assigns_id');
            $table->integer('customer_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('atm_id')->nullable();
            $table->integer('job_post_id');
            $table->decimal('duty_rate',10,2)->default(0);
            $table->decimal('service_rate',10,2)->default(0);
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
        Schema::dropIfExists('south_bangla_assign_details');
    }
};
