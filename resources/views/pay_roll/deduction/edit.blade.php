@extends('layout.app')

@section('pageTitle',trans('Update'))
@section('pageSubTitle',trans('User Wise Deduction'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                    <a class="float-start btn btn-sm bg-danger text-white" href="{{route('deduction_asign.index')}}">Return Index</a>
                </div>
                @if(Session::has('response'))
                {!!Session::get('response')['message']!!}
                @endif
                <form class="form" method="post" enctype="multipart/form-data" action="{{route('deduction_asign.update',[encryptor('encrypt',$c->id)])}}">
                    @csrf
                    @method('PATCH')
                    {{--$c--}}
                    <div class="row">
                        <div class="col-lg-4 mt-2">
                            <label for=""><b>Salary Year</b></label>
                            <select required class="form-control form-select year" name="year" disabled>
                                <option value="">Select Year</option>
                                @for($i=2023;$i<= date('Y');$i++)
                                    <option value="{{ $i }}" @if(request()->get('year') == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <label for=""><b>Salary Month</b></label>
                            <select required class="form-control form-select month" name="month" disabled>
                                <option value="">Select Month</option>
                                @for($i=1;$i<= 12;$i++)
                                    <option value="{{ $i }}" @if(request()->get('month') == $i) selected @endif>{{ date('F',strtotime("2022-$i-01")) }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <label for=""><b>Employee</b></label>
                            <select class="form-select employee_id select2" id="employee_id" name="employee_id" disabled>
                                <option value="">Select Employee</option>
                                @forelse ($employee as $em)
                                <option value="{{ $em->id }}" @if(request()->get('employee_id') == $em->id) selected @endif>
                                    {{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}
                                </option>
                                @empty
                                @endforelse
                            </select>
                            @if($errors->has('employee_id'))
                            <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                            @endif
                        </div>
                    </div>



                    <div class="row">
                        <!-- Fine -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="fine" class="form-label">Fine</label>
                                <input type="text" class="form-control" id="fine" name="fine" value="{{ old('fine', $c->fine) }}">
                            </div>
                        </div>

                        <!-- Mobile Bill -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="mobilebill" class="form-label">Mobile Bill</label>
                                <input type="text" class="form-control" id="mobilebill" name="mobilebill" value="{{ old('mobilebill', $c->mobilebill) }}">
                            </div>
                        </div>

                        <!-- Loan -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="loan" class="form-label">Loan</label>
                                <input type="text" class="form-control" id="loan" name="loan" value="{{ old('loan', $c->loan) }}">
                            </div>
                        </div>

                        <!-- Cloth -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="cloth" class="form-label">Cloth</label>
                                <input type="text" class="form-control" id="cloth" name="cloth" value="{{ old('cloth', $c->cloth) }}">
                            </div>
                        </div>

                        <!-- Jacket -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="jacket" class="form-label">Jacket</label>
                                <input type="text" class="form-control" id="jacket" name="jacket" value="{{ old('jacket', $c->jacket) }}">
                            </div>
                        </div>

                        <!-- HR -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="hr" class="form-label">HR</label>
                                <input type="text" class="form-control" id="hr" name="hr" value="{{ old('hr', $c->hr) }}">
                            </div>
                        </div>

                        <!-- C/F -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="c_f" class="form-label">C/F</label>
                                <input type="text" class="form-control" id="c_f" name="c_f" value="{{ old('c_f', $c->c_f) }}">
                            </div>
                        </div>

                        <!-- Medical -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="medical" class="form-label">Medical</label>
                                <input type="text" class="form-control" id="medical" name="medical" value="{{ old('medical', $c->medical) }}">
                            </div>
                        </div>

                        <!-- Matters Pillow Cost -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="matterss_pillowCost" class="form-label">Matters Pillow Cost</label>
                                <input type="text" class="form-control" id="matterss_pillowCost" name="matterss_pillowCost" value="{{ old('matterss_pillowCost', $c->matterss_pillowCost) }}">
                            </div>
                        </div>

                        <!-- Tonic Sim -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="tonic_sim" class="form-label">Tonic Sim</label>
                                <input type="text" class="form-control" id="tonic_sim" name="tonic_sim" value="{{ old('tonic_sim', $c->tonic_sim) }}">
                            </div>
                        </div>

                        <!-- Over Payment Cut -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="over_paymentCut" class="form-label">Over Payment Cut</label>
                                <input type="text" class="form-control" id="over_paymentCut" name="over_paymentCut" value="{{ old('over_paymentCut', $c->over_paymentCut) }}">
                            </div>
                        </div>

                        <!-- Bank Charge Excl -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="bank_charge_exc" class="form-label">Bank Charge Excl</label>
                                <input type="text" class="form-control" id="bank_charge_exc" name="bank_charge_exc" value="{{ old('bank_charge_exc', $c->bank_charge_exc) }}">
                            </div>
                        </div>

                        <!-- Dress -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="dress" class="form-label">Dress</label>
                                <input type="text" class="form-control" id="dress" name="dress" value="{{ old('dress', $c->dress) }}">
                            </div>
                        </div>

                        <!-- Excess Mobile -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="excess_mobile" class="form-label">Excess Mobile</label>
                                <input type="text" class="form-control" id="excess_mobile" name="excess_mobile" value="{{ old('excess_mobile', $c->excess_mobile) }}">
                            </div>
                        </div>

                        <!-- Mess -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="mess" class="form-label">Mess</label>
                                <input type="text" class="form-control" id="mess" name="mess" value="{{ old('mess', $c->mess) }}">
                            </div>
                        </div>

                        <!-- Absent -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="absent" class="form-label">Absent</label>
                                <input type="text" class="form-control" id="absent" name="absent" value="{{ old('absent', $c->absent) }}">
                            </div>
                        </div>

                        <!-- Vacant -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="vacant" class="form-label">Vacant</label>
                                <input type="text" class="form-control" id="vacant" name="vacant" value="{{ old('vacant', $c->vacant) }}">
                            </div>
                        </div>

                        <!-- Advance -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="adv" class="form-label">Advance</label>
                                <input type="text" class="form-control" id="adv" name="adv" value="{{ old('adv', $c->adv) }}">
                            </div>
                        </div>

                        <!-- Stamp -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="stmp" class="form-label">Stamp</label>
                                <input type="text" class="form-control" id="stmp" name="stmp" value="{{ old('stmp', $c->stmp) }}">
                            </div>
                        </div>

                        <!-- Fuel Bill -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="fuel_bill" class="form-label">Fuel Bill</label>
                                <input type="text" class="form-control" id="fuel_bill" name="fuel_bill" value="{{ old('fuel_bill', $c->fuel_bill) }}">
                            </div>
                        </div>

                        <!-- Post Allowance -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="post_allowance" class="form-label">Post Allowance</label>
                                <input type="text" class="form-control" id="post_allowance" name="post_allowance" value="{{ old('post_allowance', $c->post_allowance) }}">
                            </div>
                        </div>

                        <!-- Allowance -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="allowance" class="form-label">Allowance</label>
                                <input type="text" class="form-control" id="allowance" name="allowance" value="{{ old('allowance', $c->allowance) }}">
                            </div>
                        </div>

                        <!-- Leave -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="leave" class="form-label">Leave</label>
                                <input type="text" class="form-control" id="leave" name="leave" value="{{ old('leave', $c->leave) }}">
                            </div>
                        </div>

                        <!-- Arrear -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="arrear" class="form-label">Arrear</label>
                                <input type="text" class="form-control" id="arrear" name="arrear" value="{{ old('arrear', $c->arrear) }}">
                            </div>
                        </div>

                        <!-- Status -->
                        {{--<div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $c->status) }}">
                            </div>
                        </div>--}}

                        <!-- Salary Stop Message -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="salary_stop_message" class="form-label">Salary Stop Message</label>
                                <input type="text" class="form-control" id="salary_stop_message" name="salary_stop_message" value="{{ old('salary_stop_message', $c->salary_stop_message) }}">
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-3 mb-1">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks', $c->remarks) }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Update Deduction</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
{{--$c--}}
@endsection