<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\JobPost;

class WasaInvoiceDetails extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
    public function jobpost(){
        return $this->belongsTo(JobPost::class,'job_post_id','id');
    }
    public function atms(){
        return $this->belongsTo(Atm::class,'atm_id','id');
    }
}
