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
        Schema::create('release_employee_details', function (Blueprint $table) {
            $table->id();
            $table->integer('release_employee_id')->nullable();
            $table->integer('issue_item_id')->nullable();
            $table->integer('issue_qty')->nullable();
            $table->integer('receive_qty')->nullable();
            $table->integer('not_receive_qty')->nullable();
            $table->decimal('not_receive_qty_amount',10,2)->default(0)->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('release_employee_details');
    }
};
