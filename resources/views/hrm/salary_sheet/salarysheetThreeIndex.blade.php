@extends('layout.app')
@section('pageTitle','Salary Sheet Three List')
@section('pageSubTitle','All')
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-striped">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('salarySheetThree')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center bg-primary text-white">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Month')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salarysheet as $s)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">
                            @foreach($s->customers as $customer)
                                <li>{{ $customer->name }}</li>
                            @endforeach
                        </td>
                        <td>
                            @for($i=1; $i<= 12; $i++)
                            @if($s->month==$i)
                            {{ date('F',strtotime("2022-$i-01")) }}
                            @endif
                            @endfor
                            -{{ $s->year }}
                        </td>
                        <td>
                            <a href="{{route('salarysheet.salarySheetThreeShow',[encryptor('encrypt',$s->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{--  <a href="{{route('customerduty.edit',[encryptor('encrypt',$s->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>  --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{--  {{$salarysheet->links()}}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
