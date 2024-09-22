<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->string('signature')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('company_branch_id')->nullable()->index()->foreign('company_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable()->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('invoice_settings')->insert([
            [
                'name' => 'MD. Abu Rashel',
                'designation' => 'Deputy Manager',
                'phone' => '01844-040718',
                'status' => '0',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'MD. Mayan Uddin',
                'designation' => 'Manager',
                'phone' => '01844-040714',
                'status' => '0',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Anup Kumar Mutsddi',
                'designation' => 'Senior Manager',
                'phone' => '(Accounts & Finance)',
                'status' => '0',
                'created_at' => Carbon::now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_settings');
    }
};
