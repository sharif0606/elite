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
        Schema::create('advance_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advance_id')->index();
            $table->unsignedBigInteger('invoice_payment_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->decimal('used_amount', 15, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign keys
            // $table->foreign('advance_id')->references('id')->on('advances')->onDelete('cascade');
            // $table->foreign('invoice_payment_id')->references('id')->on('invoice_payments')->onDelete('cascade');
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('branch_id')->references('id')->on('customer_brances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advance_usages');
    }
};
