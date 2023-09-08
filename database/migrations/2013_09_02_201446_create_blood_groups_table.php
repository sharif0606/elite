<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
        Schema::create('blood_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn');
            $table->timestamps();
        });
        DB::table('blood_groups')->insert([
            [
                'name'=>'A+',
                'name_bn'=>'এ+',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'A-',
                'name_bn'=>'এ-',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'B+',
                'name_bn'=>'বি+',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'B-',
                'name_bn'=>'বি-',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'O+',
                'name_bn'=>'ও+',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'O-',
                'name_bn'=>'ও-',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'AB+',
                'name_bn'=>'এবি+',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'AB-',
                'name_bn'=>'এবি-',
                'created_at'=>Carbon::now(),
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
        Schema::dropIfExists('blood_groups');
    }
};
