<?php

namespace App\Models\Crm;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortlinkInvoiceDetails extends Model
{
    use HasFactory;
    public function jobpost(){
        return $this->belongsTo(JobPost::class,'job_post_id','id');
    }
}
