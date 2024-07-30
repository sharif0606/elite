@extends('layout.app')
@section('pageTitle',trans('Deduction Asign List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <div class="table-responsive">
                    {{-- <a href="{{route('salaryStopIndex')}}" class="btn btn-danger py-1 px-2 m-1">Salary Stop</a> --}}
                    <a href="{{route('fineIndex')}}" class="btn btn-danger py-1 px-2 m-1">Fine List</a>
                    <a href="{{route('mobileBillIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mobile Bill</a>
                    <a href="{{route('loanIndex')}}" class="btn btn-danger py-1 px-2 m-1">Loan</a>
                    <a href="{{route('clothIndex')}}" class="btn btn-danger py-1 px-2 m-1">Cloth</a>
                    <a href="{{route('JacketIndex')}}" class="btn btn-danger py-1 px-2 m-1">Jacket</a>
                    <a href="{{route('HrIndex')}}" class="btn btn-danger py-1 px-2 m-1">Hr</a>
                    <a href="{{route('CfIndex')}}" class="btn btn-danger py-1 px-2 m-1">CF</a>
                    <a href="{{route('medicalIndex')}}" class="btn btn-danger py-1 px-2 m-1">Medical</a>
                    <a href="{{route('MatterssPillowIndex')}}" class="btn btn-danger py-1 px-2 m-1">Matterss Pillow Cost</a>
                    <a href="{{route('tonicSimIndex')}}" class="btn btn-danger py-1 px-2 m-1">Tonic Sim</a>
                    <a href="{{route('overPaymentIndex')}}" class="btn btn-danger py-1 px-2 m-1">Over Payment</a>
                    <a href="{{route('bankChargeIndex')}}" class="btn btn-danger py-1 px-2 m-1">Bank Charge/Exc</a>
                    <a href="{{route('DressIndex')}}" class="btn btn-danger py-1 px-2 m-1">Dress</a>
                    <a href="{{route('stmpIndex')}}" class="btn btn-danger py-1 px-2 m-1">Stmp</a>
                    <a href="{{route('mobileExcessIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mobile Excess</a>
                    <a href="{{route('messIndex')}}" class="btn btn-danger py-1 px-2 m-1">Mess</a>
                    {{-- <a href="{{route('absentIndex')}}" class="btn btn-danger py-1 px-2 m-1">Absent</a>
                    <a href="{{route('vacantIndex')}}" class="btn btn-danger py-1 px-2 m-1">Vacant</a> --}}
                    <a href="{{route('advIndex')}}" class="btn btn-danger py-1 px-2 m-1">Adv</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection