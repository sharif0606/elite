<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Advance;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\Atm;
use App\Models\Settings\DepositBank;
use Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class AdvanceController extends Controller
{
    public function index(Request $request)
    {
        // Load relationships for customer, branch, and atm
        $payments = Advance::with(['customer', 'branch', 'atm']);
        
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
                ->whereDate('taken_date', '<=', $endDate);
        }

        $payments = $payments->orderBy('id', 'DESC')->paginate(15);

        $customer = Customer::all();

        return view('advance.index', compact('payments', 'customer'));
    }
    public function create()
    {
        $customer = Customer::all();
        $deposit_bank = DepositBank::get();
        return view('advance.create', compact('customer', 'deposit_bank'));
    }
    public function store(Request $request)
    {
        // Validate required fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'taken_date' => 'required|date',
        ], [
            'customer_id.required' => 'Customer Name is required',
            'customer_id.exists' => 'Selected customer is invalid',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a valid number',
            'amount.min' => 'Amount must be greater than 0',
            'taken_date.required' => 'Taken Date is required',
            'taken_date.date' => 'Taken Date must be a valid date',
        ]);

        try {
            // Prepare data for mass assignment
            $advanceData = [
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id ? $request->branch_id : 0,
                'atm_id' => $request->atm_id ? $request->atm_id : 0,
                'amount' => $request->amount,
                'taken_date' => $request->taken_date,
                'payment_type' => $request->payment_type ?? 1, // Default to Cash
                'deposit_bank' => $request->deposit_bank ?? null,
                'bank_name' => $request->bank_name ?? null,
                'used_amount' => 0.00, // Initialize used_amount for new advance
                'remaining_amount' => $request->amount, // Initialize remaining_amount with full amount
                'created_by' => auth()->id() ?? 1,
            ];
            
            // Create advance using mass assignment
            $data = Advance::create($advanceData);
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
        $deposit_bank = DepositBank::get();

        // Load only branches that belong to the selected customer
        $branches = CustomerBrance::where('customer_id', $advance->customer_id)->get();

        // Load only ATMs that belong to the selected branch
        $atms = Atm::where('branch_id', $advance->branch_id)->get();

        return view('advance.edit', compact('advance', 'customer', 'branches', 'atms', 'deposit_bank'));
    }

    public function update(Request $request, $id)
    {
        // Validate required fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'taken_date' => 'required|date',
        ], [
            'customer_id.required' => 'Customer Name is required',
            'customer_id.exists' => 'Selected customer is invalid',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a valid number',
            'amount.min' => 'Amount must be greater than 0',
            'taken_date.required' => 'Taken Date is required',
            'taken_date.date' => 'Taken Date must be a valid date',
        ]);

        try {
            $data = Advance::findOrFail($id);
            
            // Check if advance has been used - if so, prevent amount reduction below used amount
            if ($data->used_amount > 0 && $request->amount < $data->used_amount) {
                return redirect()->back()->withInput()
                    ->with(Toastr::error('Amount cannot be less than used amount (' . number_format($data->used_amount, 2) . ')', 'Validation Error', ["positionClass" => "toast-top-right"]));
            }
            
            $data->customer_id = $request->customer_id;
            $data->branch_id   = $request->branch_id ? $request->branch_id : 0;
            $data->atm_id      = $request->atm_id ? $request->atm_id : 0;
            $data->amount      = $request->amount;
            $data->taken_date  = $request->taken_date;
            $data->payment_type = $request->payment_type ?? 1;
            $data->deposit_bank = $request->deposit_bank ?? null;
            $data->bank_name = $request->bank_name ?? null;
            // Recalculate remaining_amount when amount is updated
            $data->remaining_amount = $data->amount - $data->used_amount;
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
