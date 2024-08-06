@extends('layout.app')
@section('pageTitle','Salary Report')
@section('pageSubTitle','report')
@section('content')
<style>
    .tbl_border{
    border: 1px solid;
    border-collapse: collapse;
    }
</style>
<div class="col-12">
    <div class="card">
        <form action="">
            <div class="row">
                <div class="table-responsive">
                    <table class="table tbl_border">
                        <tr class="text-center tbl_border"><th colspan="8" class="tbl_border">Release Salary Sheet For The Month of November-2023</th></tr>
                        <tr class="text-center tbl_border">
                            <th class="tbl_border">SL</th>
                            <th class="tbl_border">ID NO</th>
                            <th class="tbl_border">Rank</th>
                            <th class="tbl_border">Name</th>
                            <th class="tbl_border">Account Number</th>
                            <th class="tbl_border">Salary Amount</th>
                            <th class="tbl_border">Total Amount</th>
                            <th class="tbl_border">Post</th>
                        </tr>
                        @forelse ($data as $d)
                            <tr class="tbl_border">
                                <th class="tbl_border text-center">{{ ++$loop->index}}</th>
                                <th class="tbl_border text-center">{{$d->employee?->admission_id_no}}</th>
                                <th class="tbl_border text-center">{{$d->position?->name}}</th>
                                <th class="tbl_border">{{$d->employee?->en_applicants_name}}</th>
                                <th class="tbl_border text-center">{{$d->employee?->bn_ac_no}}</th>
                                <th class="tbl_border text-end">{{$d->branches?->net_salary}}</th>
                                <th class="tbl_border text-end">{{$d->branches?->net_salary}}</th>
                                <th class="tbl_border">{{$d->branches?->brance_name}}</th>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

