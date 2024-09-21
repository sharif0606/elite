<?php

namespace App\Models\Release;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseEmployee extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
