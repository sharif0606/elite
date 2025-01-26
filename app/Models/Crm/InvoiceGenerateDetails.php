<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPost;
use App\Models\Crm\Atm;
use App\Models\Hour;

class InvoiceGenerateDetails extends Model
{
    use HasFactory;
    public function jobpost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }
    public function atms()
    {
        return $this->belongsTo(Atm::class, 'atm_id', 'id');
    }

    public function hours()
    {
        return $this->belongsTo(Hour::class, 'type_houre', 'id');
    }
    // InvoiceGenerateDetail Model
    public function invoiceGenerate()
    {
        return $this->belongsTo(InvoiceGenerate::class, 'invoice_id', 'id');
    }

    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'id');
    }
}
