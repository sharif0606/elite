@extends('layout.app')
@section('pageTitle',trans('Employee List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <form class="form" method="get" action="">
        <div class="row">
            <div class="col-4 py-1">
                <label for="employee_id">{{__('Employee Name/ID')}}</label>
                <select name="employee_id" class="choices form-select">
                    <option value="">Select</option>
                    @forelse ($employee as $p)
                        <option value="{{$p->id}}" {{ old('employee_id')==$p->id?"selected":""}}>{{$p->bn_applicants_name}}</option>
                    @empty
                        <option value="">No Data Found</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-6 d-flex justify-content-end">
                <button type="submit" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>

            </div>
            <div class="col-6 d-flex justify-content-Start">
                <button type="#" class="btn pbtn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Reset')}}</button>

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
                                        <a href="{{route('stock.individual',encryptor('encrypt',$d->product_id))}}">
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
