<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\Brand;
use DB;
use Carbon\Carbon;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/brands.csv"), "r");
        $batches = array();
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            Brand::create(array(
                //"id" => trim($data['0']),
                "name" => trim($data['0']),
                "slug_name" => trim($data['1']),
                "status" => trim($data['2']),
                "created_by" => (trim($data['3'])),
                "updated_by" => (trim($data['4'])),
                "created_at" => (trim($data['5'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
