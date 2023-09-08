<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;
class VehicleMostViewdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('most_views')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/most_views.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            $data = array(
                //"id" => trim($data['0']),
                "country_id" => trim($data['0']),
                "vehicle_id" => trim($data['1']),
                "view_count" => trim($data['2']),
                /*"created_by" => (trim($data['3'])),
                "updated_by" => (trim($data['4'])),*/
                "created_at" => (trim($data['3'])),
                "updated_at" => Carbon::now()
            );
            DB::table('most_views')->insert($data);
        }
        fclose($csvFile);
    }
}
