@extends('layout.app')
@section('pageTitle',trans('Income Statement'))
@section('pageSubTitle',trans('Statement'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="text-center">
                 <h3>Income Statement</h3>
                </div>
                <form action="" method="get">
                    <div class="row ps-2">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Month</label>
                                <select name="imonth" id="month" class="form-control">
                                <option value="">Select Month</option>
                                    <?php
                                        $selected_tmonth = isset($_GET['imonth'])?$_GET['imonth']:\Carbon\Carbon::now()->format('m'); //current month
                                        for ($i = 1; $i <= 12; $i++) {
                                            $selected = $selected_tmonth == $i ? ' selected' : '';
                                            echo '<option value="'.$i.'"'.$selected.'>'. date('F', mktime(0,0,0,$i,5)).'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Year</label>
                                <select id="year" name="iyear" class="form-control">
                                    <option value="">Select Year</option>
                                    <?php
                                        $selected_ty = isset($_GET['iyear'])?$_GET['iyear']:\Carbon\Carbon::now()->format('Y'); //current year
                                        for ($i = 2023; $i <= \Carbon\Carbon::now()->format('Y'); $i++) {
                                            $selected = $selected_ty == $i ? ' selected' : '';
                                            echo '<option value="'.$i.'"'.$selected.'>'. $i.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 pt-3 mt-2">
                            <button class="btn btn-primary btn-block" type="submit">Get Report</button>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        @php $inc=$exp=0; @endphp
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2" class="text-center">For the month of {{date('F', mktime(0,0,0,$selected_tmonth,5))}}-{{$selected_ty}}</th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">ELITE SECURITY SERVICES LIMITED</th>
                            </tr>
                            <tr>
                                <th class="text-center">Received</th>
                                <th class="text-center">Payment</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <table class="table">
                                        <tr>
                                            <th>#SL</th>
                                            <th>Particulars</th>
                                            <th>Amount</th>
                                        </tr>
                                        @forelse($opincome as $i=>$opi)
                                            <tr>
                                                <th>{{ ++$i }}</th>
                                                <th>{{$opi->journal_title}}</th>
                                                <th>{{$opi->cr}}</th>
                                            </tr>
                                        @empty

                                        @endforelse
                                        @forelse($nonopincome as $opi)
                                            <tr>
                                                <th>{{ ++$i }}</th>
                                                <th>{{$opi->journal_title}}</th>
                                                <th>{{$opi->cr}}</th>
                                            </tr>
                                        @empty

                                        @endforelse
                                    </table>
                                </td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <th>#SL</th>
                                            <th>Particulars</th>
                                            <th>Amount</th>
                                        </tr>
                                        @forelse($opexpense as $i=>$opi)
                                            <tr>
                                                <th>{{ ++$i }}</th>
                                                <th>{{$opi->journal_title}}</th>
                                                <th>{{$opi->dr}}</th>
                                            </tr>
                                        @empty

                                        @endforelse
                                        @forelse($nonopexpense as $opi)
                                            <tr>
                                                <th>{{ ++$i }}</th>
                                                <th>{{$opi->journal_title}}</th>
                                                <th>{{$opi->dr}}</th>
                                            </tr>
                                        @empty

                                        @endforelse
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection

