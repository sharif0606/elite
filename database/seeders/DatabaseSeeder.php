<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Settings\BodyType;
use App\Models\Settings\SubBodyType;
use App\Models\Settings\DriveType;
use App\Models\Settings\InventoryLocation;

use App\Models\Vehicle\Brand;
use App\Models\Vehicle\Fuel;
use App\Models\Vehicle\Color;
use App\Models\Vehicle\Transmission;
use App\Models\UserDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            UnionSeeder::class,


            // BrandSeeder::class,
            // SubBrandSeeder::class,
            // CountrySeeder::class,
            // PortSeeder::class,
            // CompanyInformationSeeder::class,
            /*VehicleModelSeeder::class,
            VehicleSeeder::class,
            VehicleImageSeeder::class,
            VehicleNewArivalSeeder::class,
            VehicleCountriesSeeder::class,
            VehicleMostViewdSeeder::class*/
        ]);
        // UserDetail::factory(3)->create();

        // // creating Body Type
        // foreach(body_types() as $body_type) {
        //     $bt = new BodyType();
        //     $bt->name = $body_type['name'];
        //     $bt->created_by =1;
        //     $bt->save();
        // }

        // // creating Sub Body Type
        // foreach(sub_body_types() as $sub_body_type) {
        //     $sbt = new SubBodyType();
        //     $sbt->name = $sub_body_type['name'];
        //     $sbt->created_by =1;
        //     $sbt->save();
        // }

        // // creating Drive Type
        // foreach(drive() as $d) {
        //     $dv = new DriveType();
        //     $dv->name = $d['name'];
        //     $dv->created_by =1;
        //     $dv->save();
        // }

        // // creating Inventory Location
        // foreach(inventory_location() as $in) {
        //     $inv = new InventoryLocation();
        //     $inv->country_id = $in['country_id'];
        //     $inv->created_by =1;
        //     $inv->save();
        // }

        // // creating Fuel
        // foreach(fuel() as $fu) {
        //     $f = new Fuel();
        //     $f->name = $fu['name'];
        //     $f->created_by =1;
        //     $f->save();
        // }
        // // creating Color
        // foreach(color() as $co) {
        //     $c = new Color();
        //     $c->name = $co['name'];
        //     $c->created_by =1;
        //     $c->save();
        // }
        // // creating Color
        // foreach(transmission() as $ts) {
        //     $t = new Transmission();
        //     $t->name = $ts['name'];
        //     $t->created_by =1;
        //     $t->save();
        // }
    }
}
