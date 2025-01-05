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
    protected $fillable = [
        'employee_rate_id',
        'employee_id',
        'job_post_id',
        'hours',
        'duty_rate',
        'ot_rate',
        'status',
    ];
    
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
