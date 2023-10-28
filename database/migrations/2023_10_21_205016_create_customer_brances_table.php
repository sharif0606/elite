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
            $table->string('brance_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('billing_person')->nullable();
            $table->string('billing_address')->nullable();
            $table->date('agreement_date')->nullable();
            $table->date('renew_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->decimal('vat',10,2)->default(0);
            // $table->decimal('rate',10,2)->default(0);
            $table->string('take_home')->nullable();
            $table->string('royal_tea')->nullable();
            $table->string('ait')->nullable();
            $table->string('received_by_city')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('atm')->nullable();
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
