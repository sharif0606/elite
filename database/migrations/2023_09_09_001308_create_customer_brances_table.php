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
            $table->unsignedBigInteger('customer_id')->nullable();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('brance_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('billing_person')->nullable();
            $table->string('billing_address')->nullable();
            $table->date('agreement_date')->nullable();
            $table->date('renew_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->decimal('vat',10,2)->default(0);
            $table->decimal('billing_rate',10,2)->default(0)->nullable();
            $table->text('attention')->nullable();
            $table->text('attention_details')->nullable();
            $table->string('take_home')->nullable();
            $table->string('royal_tea')->nullable();
            $table->string('ait')->nullable();
            $table->string('received_by_city')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('atm')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('company_branch_id')->nullable()->index()->foreign('company_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable()->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
