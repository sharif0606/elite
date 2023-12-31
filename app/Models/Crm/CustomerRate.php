<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPost;

class CustomerRate extends Model
{
    use HasFactory;
    public function jobpost(){
        return $this->belongsTo(JobPost::class,'job_post_id','id');
    }
}
