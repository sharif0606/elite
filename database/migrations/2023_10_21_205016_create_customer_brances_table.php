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
        Schema::create('customer_brances', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('brance_name');
            $table->string('contact_persone');
            $table->string('contact_phone');
            $table->string('billing_person_name');
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
        Schema::dropIfExists('customer_brances');
    }
};
