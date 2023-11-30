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
        Schema::create('jobpost_description_details', function (Blueprint $table) {
            $table->id();
            $table->integer('jobpost_description_id')->nullable();
            //$table->integer('jobpost_id')->nullable();
            $table->integer('type')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('jobpost_description_details');
    }
};
