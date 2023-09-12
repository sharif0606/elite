<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\JobPost;

class GuardAssign extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function jobpost(){
        return $this->belongsTo(JobPost::class,'job_post_id','id');
    }
}
