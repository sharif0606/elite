<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\SubBrand;
use DB;
use Carbon\Carbon;
class SubBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SubBrand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/sub_brands.csv"), "r");
        $batches = array();
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            SubBrand::create(array(
                //"id" => trim($data['0']),
                "name" => trim($data['0']),
                "slug_name" => trim($data['1']),
                "brand_id" => trim($data['2']),
                "image" => trim($data['3']),
                "status" => trim($data['4']),
                "created_by" => (trim($data['5'])),
                "updated_by" => (trim($data['6'])),
                "created_at" => (trim($data['7'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
