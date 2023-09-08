<?php 
namespace App\Services;

use Illuminate\Http\Request;
use GeoIP;
use App\Models\Settings\Country;
class GeoLocationService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getCountry()
    {
        //$location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        $location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=122.152.55.168')); //210.138.184.59//122.152.55.168
        $countryName = Country::where('code', $location['geoplugin_countryCode'])->first();

        return $countryName;
    }
}
