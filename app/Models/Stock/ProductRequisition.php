<?php

namespace App\Models\Stock;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\Stock\ProductRequisitionDetails;
class ProductRequisition extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
    public function details(){
        return $this->hasMany(ProductRequisitionDetails::class,'product_requisition_id','id');
    }
    public function company(){
        return $this->belongsTo(Customer::class,'company_id','id');
    }
}
