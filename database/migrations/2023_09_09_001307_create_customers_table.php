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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('bin')->nullable();
            $table->string('invoice_number')->nullable();
            $table->integer('customer_type')->nullable();
            $table->string('inv_vat_note')->nullable();
            // $table->integer('district_id')->nullable();
            // $table->integer('upazila_id')->nullable();
            // $table->integer('union_id')->nullable();
            // $table->integer('ward_id')->nullable();
            $table->string('file_upload_name')->nullable();
            $table->string('file_upload')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('company_branch_id')->nullable()->index()->foreign('company_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable()->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->text('header_note')->nullable();
            $table->text('footer_note')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
