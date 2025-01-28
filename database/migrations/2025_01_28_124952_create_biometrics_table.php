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
        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // Add employee ID as a foreign key reference
            $table->tinyInteger('hand_type'); // 1 for Left, 2 for Right
            $table->tinyInteger('finger_type'); // 1 for Thumb, 2 for Index, etc.
            $table->string('img'); // For storing image file name or path
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
        Schema::dropIfExists('biometrics');
    }
};
