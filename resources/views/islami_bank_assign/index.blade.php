@extends('layout.app')
@section('pageTitle','List')
@section('pageSubTitle','Islami Bank Assign Employee')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('islamiBankEmpAssign.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col" >{{__('Month')}}</th>
                        {{-- <th scope="col">{{__('Details')}}</th> --}}
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($islamiBankEmpAssign as $e)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">
                            <b><span class="badge bg-primary">{{$e->customer?->name}}</span></b>
                            <br>
                            <span class="">{{$e->branch?->brance_name}}</span>
                            <br>
                            <span class="">{{$e->atm?->atm}}</span>
                        </td>
                        {{-- <td scope="row">{{ date('M-Y', strtotime($e->end_date)) }}</td> --}}
                        <td>
                            @if ($e->details)
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Rank</th>
                                        <th>Salary</th>
                                        <th>OT Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e->details as $de)
                                    @php
                                        $salary = 0;
                                        $ot_salary = 0;

                                        // get salary from employeeRateDetails
                                        $salaryData = DB::table('employee_rates')
                                        ->join('employee_rate_details','employee_rate_details.employee_rate_id','employee_rates.id')
                                        ->select('employee_rate_details.*','employee_rates.customer_id','employee_rates.branch_id','employee_rates.atm_id')
                                        ->where('employee_rates.customer_id', 66)->where('employee_rates.branch_id', $e->company_branch_id)->first();

                                        /*if(request()->get('customer_id') && !request()->get('branch_id')){
                                            $salaryData = $salaryData->where('employee_rates.customer_id', 66);
                                        }elseif(request()->get('customer_id') && request()->get('branch_id')){
                                            $salaryData = $salaryData->where('employee_rates.customer_id', 66)->where('employee_rates.branch_id', request()->get('branch_id'));
                                        }elseif(request()->get('customer_id') && request()->get('branch_id') && request()->get('atm_id') ){
                                            $salaryData = $salaryData->where('employee_rates.customer_id', 66)->where('employee_rates.branch_id', request()->get('branch_id'))->where('employee_rates.atm_id', request()->get('atm_id'));
                                        }
                                        $salaryData = $salaryData->where('customer_id', $e->customer_id)->where('branch_id', $e->branch_id)->first();*/
                                        // print_r($salaryData);
                                        if($salaryData){
                                            $salary = $salaryData->duty_rate;
                                            $ot_salary = $salaryData->ot_rate;
                                        }else{
                                            $salary = $de->duty_rate;
                                            $ot_salary = $de->ot_rate;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $de->employee?->admission_id_no }}</td>
                                        <td>{{ $de->employee?->en_applicants_name }}</td>
                                        <td>{{$de->jobpost?->name }}</td>
                                        <td> {{$salary }} </td>
                                        <td> {{$ot_salary }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                             {{-- <a href="{{route('islamiBankEmpAssign.show',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a> --}}
                            <a href="{{route('islamiBankEmpAssign.edit',[encryptor('encrypt',$e->id)])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $e->id }})">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $e->id }}" action="{{ route('islamiBankEmpAssign.destroy', encryptor('encrypt', $e->id)) }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="6" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                 {{-- {{$islamiBankEmpAssign->links()}} --}}
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Data?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush