<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Settings\Zone;
use Illuminate\Http\Request;
use App\Models\Crm\InvoicePayment;

class ReportController extends Controller
{
    public function invoicePayment()
    {
        $zones=Zone::with('customer')->orderBy('name','ASC')->paginate(2);
        return view('report.invoice-payment',compact('zones'));
    }
}
