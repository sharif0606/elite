@extends('layout.app')

@section('pageTitle',trans('Update Debit Voucher'))
@section('pageSubTitle',trans('Update'))

@section('content')
<!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" enctype="multipart/form-data" method="post" action="{{route('member_voucher.update',encryptor('encrypt',$memberVoucher->id))}}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$memberVoucher->id)}}">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="countryName">{{__('Voucher No')}}</label>
                                            <input type="text" id="voucher_no" class="form-control" value="{{old('voucher_no',$memberVoucher->voucher_no)}}" name="voucher_no" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="year">{{__('Year')}}</label>
                                            <select id="year" class="form-control"  name="year">
                                                <option value="">Select Year</option>
                                                @for($i=2017; $i<=date('Y')+1; $i++)
                                                    <option value="{{$i}}" @if($memberVoucher->eyear==$i) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                            @if($errors->has('year'))
                                                <span class="text-danger"> {{ $errors->first('year') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="month">{{__('Month')}}</label>
                                            <select id="month" class="form-control" name="month">
                                                <option value="">Select Month</option>
                                                @for($i=1; $i<=12; $i++)
                                                    <option value="{{date('m', strtotime('2020-'.$i.'-01'))}}"  @if($memberVoucher->emonth==$i) selected @endif>{{date('F', strtotime('2020-'.$i.'-01'))}}</option>
                                                @endfor
                                            </select>
                                            @if($errors->has('month'))
                                                <span class="text-danger"> {{ $errors->first('month') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="member_type">{{__('Member Type')}}</label>
                                            <select id="member_type" class="form-control" name="member_type">
                                                <option value="">Select Type</option>
                                                @forelse($membertype as $m)
                                                    <option value="{{$m->id}}" @if($memberVoucher->member_id==$m->id) selected @endif data-fee="{{$m->fee_amount}}">{{$m->member_type}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if($errors->has('member_type'))
                                                <span class="text-danger"> {{ $errors->first('member_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="date">{{__('Date')}}</label>
                                            <input type="date" id="current_date" class="form-control" value="{{old('current_date',$memberVoucher->current_date)}}" name="current_date" required>
                                            @if($errors->has('current_date'))
                                                <span class="text-danger"> {{ $errors->first('current_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}</label>
                                            <input type="text" id="pay_name" class="form-control" value="{{ old('pay_name',$memberVoucher->pay_name)}}" name="pay_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="Purpose">{{__('Purpose')}}</label>
                                            <input type="text" id="purpose" class="form-control" value="{{ old('purpose',$memberVoucher->purpose)}}" name="purpose">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id='account' cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>{{__('SN#')}}</th>
                                                <th>{{__('A/C Head')}}</th>
                                                <th>{{__('DR')}}</th>
                                                <th>{{__('CR')}}</th>
                                                <th>{{__('Remarks')}}</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align:right;" colspan="2">{{__('Total Amount Tk.')}}</th>
                                                <th><input type='text' class='form-control' name='debit_sum' id='debit_sum' value='{{$memberVoucher->debit_sum}}' style='text-align:center; border:none;' readonly autocomplete="off" /></th>
                                                <th><input type='text' class='form-control' name='credit_sum' id='credit_sum' value='{{$memberVoucher->credit_sum}}' style='text-align:center; border:none;' readonly autocomplete="off" /></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody style="background:#eee;">
                                            @if($membervoucherbkdn)
                                                @foreach($membervoucherbkdn as $bk)
                                                    <tr>
                                                        <td style='text-align:center;'>1</td>
                                                        <td style='text-align:left;'>
                                                        <div style='width:100%;position:relative;'>
                                                            <input type='text' disabled class='cls_account_code form-control' style='border:none;' value='{{$bk->account_code}}' />
                                                        </div>
                                                            
                                                        </td>
                                                        <td style='text-align:left;'>
                                                            <input type='text' disabled class='cls_debit form-control' value='{{$bk->debit}}' style='text-align:center; border:none;' /> 
                                                        </td>
                                                        <td style='text-align:left;'>
                                                            <input type='text' disabled class='cls_debit form-control' value='{{$bk->credit}}' style='text-align:center; border:none;' /> 
                                                        </td>
                                                        <td style='text-align:left;'>
                                                        <input type='text' class=" form-control" value='{{$bk->particulars}}' style='text-align:left;border:none;' />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{__('Submit')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- // Basic multiple Column Form section end -->
@endsection
