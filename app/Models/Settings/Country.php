<?php

namespace App\Models\Settings;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'name';
    }
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class,'countries_vehicles','country_id','vehicle_id');
    }
}
