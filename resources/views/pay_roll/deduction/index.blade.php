@extends('layout.app')
@section('pageTitle',trans('Deduction & Allownce Asign List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <div class="">
                    <div class=""><h5>Deduction</h5></div>
                    <a href="{{route('deduction_asign.salaryStopIndex')}}" class="btn btn-danger py-1 px-2 m-1">Salary Stop</a>
                    <a href="{{route('deduction_asign.fineIndex')}}" class="btn btn-danger py-1 px-2 m-1">Fine List</a>
                    <a href="{{route('deduction_asign.mobileBillIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mobile Bill</a>
                    <a href="{{route('deduction_asign.loanIndex')}}" class="btn btn-danger py-1 px-2 m-1">Loan</a>
                    <a href="{{route('deduction_asign.clothIndex')}}" class="btn btn-danger py-1 px-2 m-1">Cloth</a>
                    <a href="{{route('deduction_asign.JacketIndex')}}" class="btn btn-danger py-1 px-2 m-1">Jacket</a>
                    <a href="{{route('deduction_asign.HrIndex')}}" class="btn btn-danger py-1 px-2 m-1">Hr</a>
                    <a href="{{route('deduction_asign.CfIndex')}}" class="btn btn-danger py-1 px-2 m-1">CF</a>
                    <a href="{{route('deduction_asign.medicalIndex')}}" class="btn btn-danger py-1 px-2 m-1">Medical</a>
                    <a href="{{route('deduction_asign.MatterssPillowIndex')}}" class="btn btn-danger py-1 px-2 m-1">Matterss Pillow Cost</a>
                    <a href="{{route('deduction_asign.tonicSimIndex')}}" class="btn btn-danger py-1 px-2 m-1">Tonic Sim</a>
                    <a href="{{route('deduction_asign.overPaymentIndex')}}" class="btn btn-danger py-1 px-2 m-1">Over Payment</a>
                    <a href="{{route('deduction_asign.bankChargeIndex')}}" class="btn btn-danger py-1 px-2 m-1">Bank Charge/Exc</a>
                    <a href="{{route('deduction_asign.DressIndex')}}" class="btn btn-danger py-1 px-2 m-1">Dress</a>
                    <a href="{{route('deduction_asign.stmpIndex')}}" class="btn btn-danger py-1 px-2 m-1">Stmp</a>
                    <a href="{{route('deduction_asign.mobileExcessIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mobile Excess</a>
                    <a href="{{route('deduction_asign.messIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mess</a>
                    {{-- <a href="{{route('deduction_asign.absentIndex')}}" class="btn btn-danger py-1 px-2 m-1">Absent</a>
                    <a href="{{route('deduction_asign.vacantIndex')}}" class="btn btn-danger py-1 px-2 m-1">Vacant</a> --}}
                    <a href="{{route('deduction_asign.advIndex')}}" class="btn btn-danger py-1 px-2 m-1">Adv</a>
                </div>
                <div class="mt-3">
                    <div class=""><h5>Allownce</h5></div>
                    <a href="{{route('deduction_asign.fuelBillIndex')}}" class="btn btn-danger py-1 px-2 m-1">Fuel Bill</a>
                    <a href="{{route('deduction_asign.postAllowanceIndex')}}" class="btn btn-danger py-1 px-2 m-1">Post Allowance</a>
                    <!-- <a href="{{route('deduction_asign.allowanceIndex')}}" class="btn btn-danger py-1 px-2 m-1">Allowance</a> -->
                    <a href="{{route('deduction_asign.leaveIndex')}}" class="btn btn-danger py-1 px-2 m-1">Leave</a>
                    <a href="{{route('deduction_asign.arrearIndex')}}" class="btn btn-danger py-1 px-2 m-1">Arrear</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection