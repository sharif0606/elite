@extends('layout.app')

@section('pageTitle',trans('Edit Deduction Long Loan'))
@section('pageSubTitle',trans('Edit'))

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route('long_loan.update', [encryptor('encrypt',$loan->id)])}}">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Employee</b></label>
                                        <select class="form-control select2" name="employee_id" id="employee_id">
                                            <option value="0">Select</option>
                                            @foreach ($employees as $e)
                                            <option value="{{ $e->id }}" {{ $e->id==$loan->employee_id?"selected":'' }}>{{ $e->bn_applicants_name }}({{ $e->admission_id_no }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Loan Amount</b></label>
                                        <input type="text" id="loan_amount" onkeyup="perInstallment()" onblur="perInstallment()" onchange="perInstallment()" class="form-control loan_amount" value="{{ old('loan_amount',$loan->loan_amount)}}" name="loan_amount">
                                        @if($errors->has('loan_amount'))
                                            <span class="text-danger"> {{ $errors->first('loan_amount') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Number Of Installment</b></label>
                                        <input type="text" id="number_of_installment" onkeyup="perInstallment();endDate();" onblur="perInstallment();endDate();" onchange="perInstallment();endDate();" class="form-control number_of_installment" value="{{ old('number_of_installment',$loan->number_of_installment)}}" name="number_of_installment">
                                        @if($errors->has('number_of_installment'))
                                            <span class="text-danger"> {{ $errors->first('number_of_installment') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Purchase Date</b></label>
                                        <input class="form-control" type="date" name="purchase_date" value="{{ old('purchase_date',$loan->purchase_date)}}" placeholder="Purchase Date">
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Installment Start Year</b></label>
                                        <select onchange="endDate()"  required class="form-control year">
                                            <option value="">Select Year</option>
                                            @for($i=2023;$i<= date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Installment Start Month</b></label>
                                        <select onchange="endDate()" required class="form-control month">
                                            <option value="">Select Month</option>
                                            @for($i=1;$i<= 12;$i++)
                                            <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                            @endfor
                                        </select>
                                        <input type="hidden" class="start_date" value="" name="start_date">
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Per Installment</b></label>
                                        <input readonly type="text" id="per_installment" class="form-control perinstallment" value="{{ old('per_installment')}}" name="per_installment">
                                        @if($errors->has('per_installment'))
                                            <span class="text-danger"> {{ $errors->first('per_installment') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>End Date</b></label>
                                        <input readonly class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic multiple Column Form section end -->
</div>
@endsection
@push("scripts")
<script>
    function perInstallment(){
        var LoanAmount = $('.loan_amount').val();
        var NumberInstallment = $('.number_of_installment').val();
        var perinstall=parseFloat(LoanAmount/NumberInstallment).toFixed(2);
        $('.perinstallment').val(perinstall);
    }
    function endDate(){
        var InstallmentStart = $('.year').val() + '-' + $('.month').val() + '-01';
        var numberOfInstallments = parseInt($('.number_of_installment').val());

        var startDate = new Date(InstallmentStart);
        console.log(InstallmentStart);
        $('.start_date').val(InstallmentStart);

        var endDate = new Date(startDate.setMonth(startDate.getMonth() + numberOfInstallments));

        var formattedEndDate = endDate.toISOString().slice(0, 10);
        $('.end_date').val(formattedEndDate);
    }

</script>
@endpush
