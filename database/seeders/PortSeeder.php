<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings\Port;
use DB;
use Carbon\Carbon;
class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Port::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/ports.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            $inv_loc_id = DB::table('countries')->where('name','like','%'.preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data['0']).'%')->first();
            if(!empty($inv_loc_id->id)){
            Port::create(array(
                "inv_loc_id" => $inv_loc_id->id,
                "code" => trim($data['1']),
                "name" => trim($data['2']),
                "created_by" => (trim($data['3'])),
                "updated_by" => (trim($data['4'])),
                "created_at" => (trim($data['5'])),
                "updated_at" => Carbon::now()
            ));
        }
        }
        fclose($csvFile);
    }
}
