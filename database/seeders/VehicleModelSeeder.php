<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\VehicleModel;
use DB;
use Carbon\Carbon;
class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VehicleModel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/vechicle_model.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            VehicleModel::create(array(
                //"id" => trim($data['0']),
                "name" => trim($data['0']),
                "sub_brand_id" => trim($data['1']),
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
