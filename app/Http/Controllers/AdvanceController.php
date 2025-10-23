<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Advance;
use Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class AdvanceController extends Controller
{
    public function index(Request $request)
    {
        $payments = Advance::with('customer', 'invoice');
        if ($request->customer_id) {
            $payments = $payments->where('customer_id', $request->customer_id);
        }
        if ($request->branch_id) {
            $payments = $payments->where('branch_id', $request->branch_id);
        }
        if ($request->fdate && $request->tdate) {
            $startDate = $request->fdate;
            $endDate = $request->tdate;
            $payments->whereDate('taken_date', '>=', $startDate)
                ->whereDate('bill_date', '<=', $endDate);
        }

        $payments = $payments->orderBy('id', 'DESC')->paginate(15);

        $customer = Customer::all();

        return view('advance.index', compact('payments', 'customer'));
    }
    public function create()
    {
        $customer = Customer::all();
        return view('advance.create', compact('customer'));
    }
    public function store(Request $request)
    {
        try {
            $data = new Advance;
            $data->customer_id = $request->customer_id;
            $data->branch_id   = $request->branch_id;
            $data->atm_id      = $request->atm_id;
            $data->amount      = $request->amount;
            $data->taken_date  = $request->taken_date;
            $data->created_by  = 1;
            $data->save();
            \LogActivity::addToLog('Advance', $request->getContent(), 'Advance Create');
            return redirect()->route('advance.index', ['role' => currentUser(), 'customer_id' => $data->customer_id, 'branch_id' => $data->branch_id])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
}
