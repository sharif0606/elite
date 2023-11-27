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
        Schema::create('product_stockins', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('size_id')->nullable();
            $table->date('entry_date');
            $table->integer('product_qty')->nullable();
            $table->integer('type')->comment('1=intact, 2=used')->nullable();
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
        Schema::dropIfExists('product_stockins');
    }
};
