<?php

namespace App\Models\Crm;

use App\Models\Employee\Employee;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IslamiBankEmpAssignDetails extends Model
{
    use HasFactory;

    public function islamiBankEmpAssign()
    {
        return $this->belongsTo(IslamiBankEmpAssign::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function atm()
    {
        return $this->belongsTo(Atm::class, 'atm_id');
    }
}