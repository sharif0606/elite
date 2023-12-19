@extends('layout.app')
@section('pageTitle',trans('Employee List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <form class="form" method="get" action="">
        <div class="row">
            <div class="col-10">
                <form action="" method="get">
                    <div class="row">
                        <div class="input-group input-group-sm d-flex justify-content-between" >
                            <div class="d-flex" style="width: 350px;">
                                <select class="form-select employee_id select2" id="employee_id" name="employee_id">
                                    <option value="">Select Employee</option>
                                    @forelse ($employee as $em)
                                    <option value="{{ $em->id }}" {{ (request('employee_id') == $em->id ? 'selected' : '') }}>{{ $em->bn_applicants_name .' ('.' Id-'.$em->admission_id_no.')' }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                <div class="input-group-append" style="margin-left: 6px;">
                                    <button type="submit" class="btn btn-info">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                <div class="input-group-append" style="margin-left: -2px;">
                                    <a class="btn btn-warning ms-2" href="{{route('product_issue.index')}}" title="Clear"><i class="bi bi-arrow-clockwise"></i></a>
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
                                    {{--  <th scope="col">{{__('Size')}}</th>
                                    <th scope="col">{{__('Qty')}}</th>  --}}
                                    <th class="white-space-nowrap">{{__('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stock as $d)
                                <tr class="text-center">
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$d->employee?->bn_applicants_name}}</td>
                                    {{--  <td>{{$d->name}}</td>
                                    <td>{{$d->qty}}</td>  --}}
                                    <td class="white-space-nowrap">
                                        <a href="{{route('stock.employeeIndividual',encryptor('encrypt',$d->employee_id))}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
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
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
