@extends('layout.app')
@section('pageTitle',trans('Product Issue List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="row pb-1">
                    <div class="col-10">
                        <form action="" method="get">
                            <div class="row">
                                <div class="input-group input-group-sm d-flex justify-content-between" >
                                    <div class="d-flex" style="width: 350px;">
                                        {{--  <input type="text" name="employee_name" value="{{isset($_GET['employee_name'])?$_GET['employee_name']:''}}" class="form-control float-start" placeholder="Search by Employee" style="width: 200px;">  --}}
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
                    <div class="col-2">
                        <a class="float-end" href="{{route('product_issue.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                    </div>
                </div>
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                {{--  <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Size')}}</th>
                                <th scope="col">{{__('Qty')}}</th>  --}}
                                <th scope="col">{{__('Employee name/Id')}}</th>
                                <th scope="col">{{__('Entry Date')}}</th>
                                {{--  <th scope="col">{{__('Type')}}</th>  --}}
                                <th class="white-space-nowrap">{{__('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisition as $d)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                {{--  <td>{{$d->product?->product_name}}</td>
                                <td>{{$d->size?->name}}</td>
                                <td>{{$d->product_qty}}</td>  --}}
                                <td>{{$d->employee?->bn_applicants_name}}/ ID- {{$d->employee?->admission_id_no}}</td>
                                <td>{{ \Carbon\Carbon::parse($d->issue_date)->format('d/m/Y') }}</td>
                                {{--  <td>@if ($d->type==2) Used @else New @endif</td>  --}}
                                <td class="white-space-nowrap">
                                    <a href="{{route('product_issue.show',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{--  <a href="{{route('product_issue.edit',encryptor('encrypt',$d->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>  --}}
                                    {{--  <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $d->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>  --}}
                                    <form id="form{{ $d->id }}" action="{{ route('product_issue.destroy', encryptor('encrypt', $d->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Row?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
