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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('product_id');
            $table->integer('size_id')->nullable();
            $table->integer('type')->comment('1=new, 2=used')->nullable();
            $table->integer('product_qty');
            $table->date('entry_date')->nullable();
            // $table->date('issue_date')->nullable();
            $table->string('note')->nullable();
            $table->date('maxlife_time')->nullable();
            $table->string('status')->comment('0=in,1=out,2=damage')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
