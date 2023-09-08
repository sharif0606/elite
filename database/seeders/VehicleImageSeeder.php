<?php

namespace Database\Seeders;

use App\Models\Vehicle\VehicleImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;
class VehicleImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VehicleImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/vehicle_images.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            VehicleImage::create(array(
                //"id" => trim($data['0']),
                "vehicle_id" => trim($data['0']),
                "image" => trim($data['1']),

                "created_by" => (trim($data['2'])),
                "updated_by" => (trim($data['3'])),
                "created_at" => (trim($data['4'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
