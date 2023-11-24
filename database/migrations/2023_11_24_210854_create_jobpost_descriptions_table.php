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
        Schema::create('jobpost_descriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('jobpost_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('title')->nullable();
            $table->string('title_bn')->nullable();
            $table->string('description')->nullable();
            $table->string('description_bn')->nullable();
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
        Schema::dropIfExists('jobpost_descriptions');
    }
};
