@extends('layout.app')
@section('pageTitle','Office Staff Salary List')
@section('pageSubTitle','All')
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-striped">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('salarySheetFour')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center bg-primary text-white">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Month')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salarysheet as $s)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>
                            @for($i=1; $i<= 12; $i++)
                            @if($s->month==$i)
                            {{ date('F',strtotime("2022-$i-01")) }}
                            @endif
                            @endfor
                            -{{ $s->year }}
                        </td>
                        <td>
                            <a href="{{route('salarysheet.salarySheetFourShow',[encryptor('encrypt',$s->id)])}}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No Data Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection