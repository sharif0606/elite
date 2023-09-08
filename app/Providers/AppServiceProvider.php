<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Breadcrumbs\Breadcrumbs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Models\Vehicle\Vehicle;

use App\Models\Settings\BodyType;
use App\Models\Settings\DriveType;
use App\Models\Settings\InventoryLocation;
use App\Models\Settings\SubBodyType;
use App\Models\Settings\Country;

use App\Models\Vehicle\Brand;
use App\Models\Vehicle\SubBrand;
use App\Models\Vehicle\Fuel;
use App\Models\Vehicle\Color;
use App\Models\Vehicle\Transmission;
use App\Models\Vehicle\VehicleModel;

Use App\Models\CompanyAccountInfo;
use DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('breadcrumbs',function(){
            return new Breadcrumbs($this);
        });

        Paginator::useBootstrapFive();

        

        View::composer(['front.welcome','front.single','front.brand','front.search','front.page.why-choose-us','front.page.how-to-order-from-auction','front.page.how-to-buy-from-stock','front.page.shipping','front.page.inspection-services','front.page.overview','front.page.company-profile','front.page.bank-information','front.page.faq','front.page.contact-us','front.page.customer-review','front.country-vehicle','dashboard.user','settings.user.*','user.consignee.*','user.consignee.*','user.inquiry.index','user.invoice.index','user.payment.index','user.resrv_vehicle.index'], function($view)
        {
            $body_types = BodyType::withCount('vehicles')->get();
            $drive_types = DriveType::all();
            $inv_loc = InventoryLocation::all();
            $sub_body_types = SubBodyType::all();

            $brands = Brand::withCount('vehicles')->get();
            
            $sub_brands = SubBrand::all();
            $fuel= Fuel::all();
            $colors = Color::all();
            $trans = Transmission::all();
            $vehicle_models = VehicleModel::all();
            $trans = Transmission::withCount('vehicles')->get();

            $countries = Country::all();

            /*====Price====Max===Min*/
            $price_range = DB::table('vehicles')->select(\DB::raw('MIN(price) AS minprice, MAX(price) AS maxprice'))->get()->toArray();
            /*====Discount====Max===Min*/
            $discount_range = DB::table('vehicles')->select(\DB::raw('MIN(discount) AS mindis, MAX(discount) AS maxdis'))->get()->toArray();
            /*====year====Max===Min*/
            $year_range = DB::table('vehicles')->select(\DB::raw('MIN(manu_year) AS minyear, MAX(manu_year) AS maxyear'))->get()->toArray();
            /*====engine cc====Max===Min*/
            $cc_range = DB::table('vehicles')->select(\DB::raw('MIN(e_size) AS mincc, MAX(e_size) AS maxcc'))->get()->toArray();
            /*====Mileage====Max===Min*/
            $mileage_range = DB::table('vehicles')->select(\DB::raw('MIN(mileage) AS min_mileage, MAX(mileage) AS max_mileage'))->get()->toArray();
            /*====Body Length===Max===Min*/
            $b_length_range = DB::table('vehicles')->select(\DB::raw('MIN(e_info) AS b_length_min, MAX(e_info) AS b_length_max'))->get()->toArray();
            /*====Max Loading===Max===Min*/
            $max_loading_range = DB::table('vehicles')->select(\DB::raw('MIN(max_loading_capacity) AS loading_min, MAX(max_loading_capacity) AS loading_max'))->get()->toArray();

            /*==Engine Type */
            $engine_types = DB::table('vehicles')->select('e_info')->distinct()->wherenotNull('e_info')->get();
            /*====Manufacture year====Max===Min*/
            $max_manu_Year = DB::table('vehicles')->max(DB::raw('YEAR(manu_year)'));
            $min_manu_Year = DB::table('vehicles')->min(DB::raw('YEAR(manu_year)'));

            $japan_locale_data = Carbon::now('Asia/Tokyo');

        
            $location =  request()->session()->get('location');
    
            $current_locale_data = Carbon::now($location['geoplugin_timezone']);
            $countryName =  request()->session()->get('countryName');

            $com_acc_info = CompanyAccountInfo::first();
            $total_cars = Vehicle::/*whereNull('r_status')->*/count();

            $view->with(['total_cars' => $total_cars, 'com_acc_info' => $com_acc_info,'countryName' => $countryName,'location' => $location, 'current_locale_data' => $current_locale_data,'japan_locale_data' => $japan_locale_data,'max_manu_Year'=> $max_manu_Year,'min_manu_Year'=> $min_manu_Year,'engine_types'=>$engine_types,'max_loading_range'=>$max_loading_range,'b_length_range'=>$b_length_range,'mileage_range'=>$mileage_range,'cc_range'=>$cc_range,'year_range' => $year_range,'discount_range' => $discount_range,'price_range' => $price_range,'body_types' =>$body_types,'drive_types' => $drive_types,'inv_loc'=> $inv_loc,'sub_body_types' => $sub_body_types,'brands' => $brands,'sub_brands'=> $sub_brands,'fuel' =>$fuel,'colors' => $colors,'trans' => $trans,'vehicle_models' => $vehicle_models]);
           
        });
        
    }
}
