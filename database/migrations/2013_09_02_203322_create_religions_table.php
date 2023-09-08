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
        Schema::create('religions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn');
            $table->timestamps();
        });
        DB::table('religions')->insert([
            [
                'name'=>'Muslim',
                'name_bn'=>'মুসলিম',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'Hindu',
                'name_bn'=>'হিন্দু',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'Buddhist',
                'name_bn'=>'বৌদ্ধ',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'Christian',
                'name_bn'=>'খ্রিস্টান',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'Others',
                'name_bn'=>'অন্যান্য',
                'created_at'=>Carbon::now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('religions');
    }
};
