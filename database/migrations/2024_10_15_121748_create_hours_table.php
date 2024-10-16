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
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->integer('hour');
            $table->boolean('status')->default(true)->comment('true for Active, false for Inactive');
            $table->timestamps();
        });
        // Insert specific hour values after table creation
        DB::table('hours')->insert([
            ['hour' => 8],
            ['hour' => 12],
            ['hour' => 9],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hours');
    }
};
