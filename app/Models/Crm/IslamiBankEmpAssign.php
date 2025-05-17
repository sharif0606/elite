<?php

namespace App\Models\Crm;

use App\Models\Customer;
use App\Models\Employee\Employee;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IslamiBankEmpAssign extends Model
{
    use HasFactory;

    public function details()
    {
        return $this->hasMany(IslamiBankEmpAssignDetails::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function branch()
    {
        return $this->belongsTo(CustomerBrance::class, 'company_branch_id', 'id');
    }

    public function atm()
    {
        return $this->belongsTo(Atm::class);
    }
}