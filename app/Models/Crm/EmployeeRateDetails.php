<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPost;
use App\Models\Hour;
use App\Models\Employee\Employee;
class EmployeeRateDetails extends Model
{
    use HasFactory;
    public function jobpost(){
        return $this->belongsTo(JobPost::class,'job_post_id','id');
    }
    public function hour(){
        return $this->belongsTo(Hour::class,'hours','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
