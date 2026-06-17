@extends('layout.app')
@section('pageTitle',trans('Employee | Customer List'))
@section('pageSubTitle',trans('List'))

@section('content')
<style>
    .employee-stock-filters .select2-container {
        width: 100% !important;
    }
    .employee-stock-filters input[type="date"] {
        min-width: 145px;
    }
</style>
<section class="section">
    <form class="form" method="get" action="">
        <div class="row g-2 align-items-end mb-3 flex-lg-nowrap employee-stock-filters">
            <div class="col-lg col-md-6">
                <label for="employee_id" class="small mb-1">{{__('Employee')}}</label>
                <select class="form-select form-select-sm employee_id select2" id="employee_id" name="employee_id">
                    <option value="">Select Employee</option>
                    @forelse ($employee as $em)
                    <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-lg col-md-6">
                <label for="company_id" class="small mb-1">{{__('Customer')}}</label>
                <select class="form-select form-select-sm company_id select2" id="company_id" name="company_id">
                    <option value="">Select Customer</option>
                    @forelse ($customer as $c)
                    <option value="{{ $c->id }}" @if(request()->get('company_id') == $c->id) selected @endif>{{ $c->name }}</option>
                    @empty
                    @endforelse
                </select>
                @if($errors->has('company_id'))
                <span class="text-danger small">{{ $errors->first('company_id') }}</span>
                @endif
            </div>
            <div class="col-lg col-md-6">
                <label for="company_branch_id" class="small mb-1">{{__('Branch')}}</label>
                <select class="form-select form-select-sm company_branch_id select2" id="company_branch_id" name="company_branch_id">
                    <option value="">Select Branch</option>
                    @forelse ($branch as $b)
                    <option value="{{ $b->id }}" @if(request()->get('company_branch_id') == $b->id) selected @endif>{{ $b->brance_name }}</option>
                    @empty
                    @endforelse
                </select>
                @if($errors->has('company_branch_id'))
                <span class="text-danger small">{{ $errors->first('company_branch_id') }}</span>
                @endif
            </div>
            <div class="col-lg-auto col-md-4">
                <label for="fdate" class="small mb-1">{{__('From Date')}}</label>
                <input type="date" id="fdate" class="form-control form-control-sm" value="{{ request('fdate') }}" name="fdate">
            </div>
            <div class="col-lg-auto col-md-4">
                <label for="tdate" class="small mb-1">{{__('To Date')}}</label>
                <input type="date" id="tdate" class="form-control form-control-sm" value="{{ request('tdate') }}" name="tdate">
            </div>
            <div class="col-lg-auto col-md-4 d-flex gap-2 pb-1">
                <button type="submit" class="btn btn-sm btn-info" title="Search">
                    <i class="bi bi-search"></i>
                </button>
                <a class="btn btn-sm btn-warning" href="{{route('stock.employeeList', ['role' => currentUser()])}}" title="Clear">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Employee Name')}}</th>
                                    <th scope="col">{{__('Company Name')}}</th>
                                    {{--  <th scope="col">{{__('Size')}}</th>
                                    <th scope="col">{{__('Qty')}}</th>  --}}
                                    <th class="white-space-nowrap">{{__('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stock as $d)
                                <tr class="text-center">
                                    <th scope="row">{{ $stock->firstItem() + $loop->index }}</th>
                                    <td>
                                        @if($d->employee?->bn_applicants_name)
                                        {{$d->employee?->bn_applicants_name}}({{$d->employee?->admission_id_no}})
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($d->company_id)
                                        {{$d->company?->name}}({{$d->company_branch?->brance_name}})
                                        @else
                                        -
                                        @endif
                                    </td>
                                    {{--  <td>{{$d->name}}</td>
                                    <td>{{$d->qty}}</td>  --}}
                                    <td class="white-space-nowrap">
                                        @php
                                            $dateParams = array_filter([
                                                'fdate' => request('fdate'),
                                                'tdate' => request('tdate'),
                                            ]);
                                        @endphp
                                        @if($d->employee?->bn_applicants_name)
                                        <a href="{{ route('stock.employeeIndividual', array_merge(['id' => encryptor('encrypt', $d->employee_id), 'type' => 1], $dateParams)) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @else
                                        <a href="{{ route('stock.employeeIndividual', array_merge(['id' => encryptor('encrypt', $d->company_id), 'type' => 2], $dateParams)) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="8" class="text-center">No Pruduct Found</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3 text-end">
                        {{ $stock->links() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
