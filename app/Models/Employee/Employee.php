<?php

namespace App\Models\Employee;

use App\Models\Crm\EmployeeRateDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\Location\District;
use App\Models\Settings\Location\Upazila;
use App\Models\Settings\Location\Union;
use App\Models\Settings\Location\Ward;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Religion;
use App\Models\JobPost;

class Employee extends Model
{
    use HasFactory;
    public function bn_district(){
        return $this->belongsTo(District::class,'bn_pre_district_id','id');
    }
    public function bn_upazilla(){
        return $this->belongsTo(Upazila::class,'bn_pre_upazila_id','id');
    }
    public function bn_union(){
        return $this->belongsTo(Union::class,'bn_pre_union_id','id');
    }
    public function bn_parm_union(){
        return $this->belongsTo(Union::class,'bn_parm_union_id','id');
    }
    public function bn_parm_district(){
        return $this->belongsTo(District::class,'bn_parm_district_id','id');
    }
    public function bn_parm_upazilla(){
        return $this->belongsTo(Upazila::class,'bn_parm_upazila_id','id');
    }
    public function bn_parm_ward(){
        return $this->belongsTo(Ward::class,'bn_parm_ward_id','id');
    }
    public function bn_pre_ward(){
        return $this->belongsTo(Ward::class,'bn_pre_ward_no','id');
    }
    public function bloodgroup(){
        return $this->belongsTo(BloodGroup::class,'bn_blood_id','id');
    }
    /**
     * The religion that the belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function religion(){
        return $this->belongsTo(Religion::class,'bn_religion','id');
    }
    /**
     * The position that the employee belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(JobPost::class,'bn_jobpost_id','id');
    }
    public function biometrics(){
        return $this->hasMany(Biometric::class, 'employee_id', 'id');
    }

    public function employeeRateDetails()
    {
        return $this->hasOne(EmployeeRateDetails::class, 'employee_id', 'id');
    }
}