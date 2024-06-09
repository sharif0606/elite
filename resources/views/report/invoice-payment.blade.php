@extends('layout.app')
@section('pageTitle','Invoice Payment Report')
@section('pageSubTitle','All Invoice')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form method="get" action="">
            <div class="row">
                <div class="col-sm-3">
                    <label for="">From Year</label>
                    <select class="form-control" name="fyear">
                        <?php
                            $selected_fy = isset($_GET['fyear'])?$_GET['fyear']:\Carbon\Carbon::now()->subMonth(6)->format('Y'); //current year
                            for ($i = 2023; $i <= \Carbon\Carbon::now()->format('Y'); $i++) {
                                $selected = $selected_fy == $i ? ' selected' : '';
                                echo '<option value="'.$i.'"'.$selected.'>'. $i.'</option>';
                            }
                        ?>
                    </select> 
                </div>
                <div class="col-sm-3">
                    <label for="">From Month</label>
                    <select class="form-control" name="fmonth">
                        <?php
                            $selected_fmonth = isset($_GET['fmonth'])?$_GET['fmonth']:\Carbon\Carbon::now()->subMonth(6)->format('m'); //current month
                            for ($i = 1; $i <= 12; $i++) {
                                $selected = $selected_fmonth == $i ? ' selected' : '';
                                echo '<option value="'.$i.'"'.$selected.'>'. date('F', mktime(0,0,0,$i,5)).'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="">To Year</label>
                    <select class="form-control" name="tyear">
                        <?php
                            $selected_ty = isset($_GET['tyear'])?$_GET['tyear']:\Carbon\Carbon::now()->format('Y'); //current year
                            for ($i = 2024; $i <= \Carbon\Carbon::now()->format('Y'); $i++) {
                                $selected = $selected_ty == $i ? ' selected' : '';
                                echo '<option value="'.$i.'"'.$selected.'>'. $i.'</option>';
                            }
                        ?>
                    </select> 
                </div>
                <div class="col-sm-3">
                    <label for="">To Month</label>
                    <select class="form-control" name="tmonth">
                        <?php
                            $selected_tmonth = isset($_GET['tmonth'])?$_GET['tmonth']:\Carbon\Carbon::now()->format('m'); //current month
                            for ($i = 1; $i <= 12; $i++) {
                                $selected = $selected_tmonth == $i ? ' selected' : '';
                                echo '<option value="'.$i.'"'.$selected.'>'. date('F', mktime(0,0,0,$i,5)).'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-info">Search</button>
                    <a href="{{route('report.inv_payment')}}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                @php
                    $period = \Carbon\CarbonPeriod::create("$selected_fy-$selected_fmonth-01", "1 month", "$selected_ty-$selected_tmonth-31");
                @endphp
                @forelse($zones as $zone)
                    <tr>
                        <th colspan="9">{{$zone->name}}</th>
                    </tr>
                    <tr class="text-center">
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        @foreach ($period as $dt)
                            <th scope="col">{{$dt->format("M-Y")}}</th>
                        @endforeach
                        <th scope="col">{{__('Amount')}}</th>
                    </tr>
                    @forelse($zone->customer as $i=>$cust)
                        @php $total=0;@endphp
                        <tr class="text-center">
                            <th scope="col">{{++$i}}</th>
                            <th scope="col">{{$cust->name}}</th>
                            @foreach ($period as $dt)
                            @php
                                $monthly_total = $cust->invPayment->whereBetween('pay_date', [$dt->format("Y-m-d"), $dt->endOfMonth()->format("Y-m-d")])->sum('received_amount');
                                $total += $monthly_total;
                            @endphp
                            <th scope="col">{{ $monthly_total }}</th>
                            @endforeach
                            <th scope="col">{{$total}}</th>
                        </tr>
                    @empty

                    @endforelse
                @empty
                    
                @endforelse
                
            </table>
            <div class="pt-2">
                {{--  {{$guards->links()}}  --}}
            </div>
            
        </div>
    </div>
</div>
<!-- Modal -->

@endsection

