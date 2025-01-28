@extends('layout.app')

@section('pageTitle',trans('Update Journal Voucher'))
@section('pageSubTitle',trans('Update'))

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" enctype="multipart/form-data" method="post" action="{{route('journal_voucher.update',encryptor('encrypt',$journalVoucher->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$journalVoucher->id)}}">
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="countryName">{{__('Voucher No')}}</label>
                                        <input type="text" id="voucher_no" class="form-control" value="{{old('voucher_no',$journalVoucher->voucher_no)}}" name="voucher_no" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="date">{{__('Date')}}</label>
                                        <input type="date" id="current_date" class="form-control" value="{{old('current_date',$journalVoucher->current_date)}}" name="current_date" required>
                                        @if($errors->has('current_date'))
                                        <span class="text-danger"> {{ $errors->first('current_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">{{__('Name')}}</label>
                                        <input type="text" id="pay_name" class="form-control" value="{{old('pay_name',$journalVoucher->pay_name)}}" name="pay_name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="Purpose">{{__('Purpose')}}</label>
                                        <input type="text" id="purpose" class="form-control" value="{{old('purpose',$journalVoucher->purpose)}}" name="purpose">
                                    </div>
                                </div>
                                @if(currentUser()=='accountant')
                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label>Account Vourcher No</label>
                                        <input type="text" class="form-control" name="vou_no" value="{{old('vou_no',$journalVoucher->vou_no)}}">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label>Vehicle No</label>
                                        <input type="text" class="form-control" name="vehicle_no" value="{{old('vehicle_no',$journalVoucher->vehicle_no)}}">
                                    </div>
                                </div>
                                @endif
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
                                            <th style="text-align:right;" colspan="2">Total Amount Tk.</th>
                                            <th>{{$journalVoucher->debit_sum}}</th>
                                            <th>{{$journalVoucher->credit_sum}}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="background:#eee;">
                                        @if($jvbkdn)
                                        @foreach($jvbkdn as $bk)
                                        <tr>
                                            <td style='text-align:center;' id='increment_1'>1</td>
                                            <td style='text-align:left;'>{{$bk->account_code}}</td>
                                            <td style='text-align:left;'>{{$bk->debit}}</td>
                                            <td style='text-align:left;'>{{$bk->credit}}</td>
                                            <td style='text-align:left;'>{{$bk->particulars}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group @if($errors->has('name')) has-error @endif">
                                            <label>{{__('Cheque No')}}</label>
                                            <span class="block input-icon input-icon-right">
                                                <input type="text" class="form-control" name="cheque_no" value="{{$journalVoucher->cheque_no}}">
                                                @if($errors->has('cheque_no'))
                                                <i class="ace-icon fa fa-times-circle"></i>
                                                @endif
                                            </span>
                                            @if($errors->has('cheque_no'))
                                            <div class="help-block col-sm-reset">
                                                {{ $errors->first('cheque_no') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>{{__('Bank Name')}}</label>
                                            <input type="text" class="form-control" name="bank" value="{{$journalVoucher->bank}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>{{__('Cheque Date')}}</label>
                                            <input type="date" class="form-control" name="cheque_dt" value="{{$journalVoucher->cheque_dt}}">

                                            @if($errors->has('cheque_dt'))
                                            <div class="help-block col-sm-reset">
                                                {{ $errors->first('cheque_dt') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <input class="form-control" type="file" name="slip">
                                    </div>
                                </div>
                            </div>
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
</div>
@endsection