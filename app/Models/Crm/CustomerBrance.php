<?php

namespace App\Models\Crm;
use App\Models\Crm\Atm;
use App\Models\Hrm\SalarySheetDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBrance extends Model
{
    use HasFactory;
    public function atms(){
        return $this->hasMany(Atm::class,'branch_id','id');
    }
}
