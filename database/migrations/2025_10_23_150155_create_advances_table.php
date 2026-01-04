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
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('atm_id')->index();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('used_amount', 15, 2)->default(0)->comment('Amount already used from this advance');
            $table->decimal('remaining_amount', 15, 2)->default(0)->comment('Available balance remaining');
            $table->date('taken_date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign keys (optional — uncomment if you have related tables)
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            // $table->foreign('atm_id')->references('id')->on('atms')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advances');
    }
};
