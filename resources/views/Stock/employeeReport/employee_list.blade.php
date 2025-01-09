@extends('layout.app')
@section('pageTitle',trans('Employee | Customer List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <form class="form" method="get" action="">
        <div class="row">
            <div class="col-10">
                <form action="" method="get">
                    <div class="row">
                        <div class="input-group input-group-sm d-flex justify-content-between" >
                            <div class="d-flex">
                                <select class="form-select employee_id select2" id="employee_id" name="employee_id">
                                    <option value="">Select Employee</option>
                                    @forelse ($employee as $em)
                                    <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="col-lg-4 col-md-6 col-sm-12 mx-2">
                                    <div class="form-group">
                                        <select class="form-select company_id select2" id="company_id" name="company_id">
                                            <option value="">Select Customer</option>
                                            @forelse ($customer as $c)
                                            <option value="{{ $c->id }}" @if(request()->get('company_id') == $c->id) selected @endif>{{ $c->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if($errors->has('company_id'))
                                        <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <select class="form-select company_branch_id select2" id="company_branch_id" name="company_branch_id">
                                            <option value="">Select Branch</option>
                                            @forelse ($branch as $b)
                                            <option value="{{ $b->id }}">{{ $b->brance_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if($errors->has('company_branch_id'))
                                        <span class="text-danger"> {{ $errors->first('company_branch_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group-append" style="margin-left: 6px;">
                                    <button type="submit" class="btn btn-info">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                <div class="input-group-append" style="margin-left: -2px;">
                                    <a class="btn btn-warning ms-2" href="{{route('stock.employeeList')}}" title="Clear"><i class="bi bi-arrow-clockwise"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                    <th scope="row">{{ ++$loop->index }}</th>
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
                                        @if($d->employee?->bn_applicants_name)
                                        <a href="{{route('stock.employeeIndividual',['id'=>encryptor('encrypt',$d->employee_id),'type' =>2])}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @else
                                        <a href="{{route('stock.employeeIndividual',['id'=>encryptor('encrypt',$d->company_id),'type' =>2])}}">
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
