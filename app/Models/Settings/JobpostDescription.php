<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\JobpostDescriptionDetails;

class JobpostDescription extends Model
{
    use HasFactory;
    public function details(){
        return $this->hasMany(JobpostDescriptionDetails::class,'jobpost_description_id','id');
    }
}
