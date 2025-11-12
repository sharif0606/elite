<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Advance;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class AdvanceController extends Controller
{
    public function index(Request $request)
    {
        $payments = Advance::with('customer');
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
        //dd($request->all());
        try {
            $data = new Advance;
            $data->customer_id = $request->customer_id;
            $data->branch_id   = $request->branch_id ? $request->branch_id : 0;
            $data->atm_id      = $request->atm_id ? $request->atm_id : 0;
            $data->amount      = $request->amount;
            $data->taken_date  = $request->taken_date;
            $data->created_by  = 1;
            $data->save();
            \LogActivity::addToLog('Advance', $request->getContent(), 'Advance Create');
            return redirect()->route('advance.index', ['role' => currentUser(), 'customer_id' => $data->customer_id, 'branch_id' => $data->branch_id])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function edit($id)
    {
        $advance = Advance::findOrFail($id);
        $customer = Customer::all();

        // Load only branches that belong to the selected customer
        $branches = CustomerBrance::where('customer_id', $advance->customer_id)->get();

        // Load only ATMs that belong to the selected branch
        $atms = Atm::where('branch_id', $advance->branch_id)->get();

        return view('advance.edit', compact('advance', 'customer', 'branches', 'atms'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Advance::findOrFail($id);
            $data->customer_id = $request->customer_id;
            $data->branch_id   = $request->branch_id ? $request->branch_id : 0;
            $data->atm_id      = $request->atm_id ? $request->atm_id : 0;
            $data->amount      = $request->amount;
            $data->taken_date  = $request->taken_date;
            $data->updated_by  = auth()->id() ?? 1;
            $data->save();

            \LogActivity::addToLog('Advance', $request->getContent(), 'Advance Update');

            return redirect()->route('advance.index', ['role' => currentUser()])
                ->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()
                ->with(Toastr::error('Update failed!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
    public function destroy($id)
    {
        try {
            $advance = Advance::findOrFail($id);
            $advance->delete();

            return redirect()->route('advance.index')
                ->with(Toastr::success('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            return redirect()->back()
                ->with(Toastr::error('Delete failed!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
}
