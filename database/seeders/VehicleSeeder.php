<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\Vehicle;
use DB;
use Carbon\Carbon;
class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vehicle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/vehicles.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            Vehicle::create(array(
                //"id" => trim($data['0']),
                "stock_id" => trim($data['0']),
                "name" => trim($data['1']),
                "description" => trim($data['2']),
                "option" => trim($data['3']),
                "fullName" => trim($data['4']),
                "brand_id" => trim($data['5']),
                "sub_brand_id" => trim($data['6']),
                "v_model_id" => trim($data['7']),
                "v_model" => trim($data['8']),
                "steering" => trim($data['9']),
                "body_type_id" => trim($data['10']),
                "drive_id" => trim($data['11']),
                "mileage" => trim($data['12']),
                "price" => trim($data['13']),
                "discount" => trim($data['14']),
                "fuel_id" => trim($data['15']),
                "color_id" => trim($data['16']),
                "e_code" => trim($data['17']),
                "year" => trim($data['18']),
                "manu_year" => trim($data['19']),
                "inv_locatin_id" => trim($data['20']),
                "air_bag" => trim($data['21']),
                "anti_lock_brake_system" => trim($data['22']),
                "air_con" => trim($data['23']),
                "back_tire" => trim($data['24']),
                "fog_lights" => trim($data['25']),
                "grill_guard" => trim($data['26']),
                "leather_seats" => trim($data['27']),
                "navigation" => trim($data['28']),
                "power_steering" => trim($data['29']),
                "power_windows" => trim($data['30']),
                "rear_spoiler" => trim($data['31']),
                "sun_roof" => trim($data['32']),
                "tv" => trim($data['33']),
                "dual_air_bags" => trim($data['34']),
                "status" => trim($data['35']),
                "v_model_id" => 1,

                "created_by" => (trim($data['36'])),
                "updated_by" => (trim($data['37'])),
                "created_at" => (trim($data['38'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
