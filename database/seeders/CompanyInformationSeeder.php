<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyAccountInfo;
use DB;
use Carbon\Carbon;
class CompanyInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CompanyAccountInfo::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/company_info.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            CompanyAccountInfo::create(array(
                //"id" => trim($data['0']),
                "c_name" => trim($data['0']),
                "c_address" => trim($data['1']),
                "bank_name" => trim($data['2']),
                "account_name" => trim($data['3']),
                "branch_name" => trim($data['4']),
                "account_number" => trim($data['5']),
                "swift_code" => trim($data['6']),
                "bank_address" => trim($data['7']),
                "tel" => trim($data['8']),
                "fax" => trim($data['9']),
                "whatsup" => trim($data['10']),
                "email" => trim($data['11']),
                "website" => trim($data['12']),
                "created_by" => (trim($data['13'])),
                "updated_by" => (trim($data['14'])),
                "created_at" => (trim($data['15'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
