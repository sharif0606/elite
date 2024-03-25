<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Hrm\SalarySheetDetail;

class SalarySheet extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function details(){
        return $this->hasMany(SalarySheetDetail::class,'salary_id','id');
    }
}
