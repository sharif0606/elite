@extends('layout.app')

@section('pageTitle',trans('Update Credit Voucher'))
@section('pageSubTitle',trans('Update'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" enctype="multipart/form-data" method="post" action="{{route('credit_voucher.update',encryptor('encrypt',$creditVoucher->id))}}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$creditVoucher->id)}}">
                                <div class="row">

                                    <div class="col-md-6 col-12 d-none">
                                        <div class="form-group">
                                            <label for="countryName">{{__('Voucher No')}}</label>
                                            <input type="text" id="voucher_no" class="form-control" value="{{old('voucher_no',$creditVoucher->voucher_no)}}" name="voucher_no" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="date">{{__('Date')}}</label>
                                            <input type="date" id="current_date" class="form-control" value="{{old('current_date',$creditVoucher->current_date)}}" name="current_date" required>
                                            @if($errors->has('current_date'))
                                                <span class="text-danger"> {{ $errors->first('current_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 d-none">
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}</label>
                                            <input type="text" id="pay_name" class="form-control" value="{{old('pay_name',$creditVoucher->pay_name)}}" name="pay_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Purpose">{{__('Purpose')}}</label>
                                            <input type="text" id="purpose" class="form-control" value="{{old('purpose',$creditVoucher->purpose)}}" name="purpose">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Category">{{__('Received Account')}}
                                                @if($crevoucherbkdn)
                                                @foreach($crevoucherbkdn as $bk)
                                                    @if($bk->particulars=="Received from")
                                                    {{$bk->account_code}} ({{$bk->debit}})
                                                    @endif
                                                @endforeach
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-bordered" id='account' cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>{{__('SN#')}}</th>
                                                <th>{{__('A/C Head')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                {{--  <th>{{__('Remarks')}}</th>  --}}
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align:right;" colspan="2">{{__('Total Amount Tk.')}}</th>
                                                <th>{{$creditVoucher->debit_sum}}</th>
                                                {{--  <th></th>  --}}
                                            </tr>
                                        </tfoot>
                                        <tbody style="background:#eee;">
                                            @if($crevoucherbkdn)
                                                @foreach($crevoucherbkdn as $bk)
                                                    @if($bk->particulars!="Received from")
                                                    <tr>
                                                        <td style='text-align:center;'>1</td>
                                                        <td style='text-align:left;'>{{$bk->account_code}}</td>
                                                        <td style='text-align:left;'>{{$bk->credit}}</td>
                                                        {{--  <td style='text-align:left;'>{{$bk->particulars}}</td>  --}}
                                                    </tr>
                                                    @endif
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
                                                <input type="text" class="form-control" name="cheque_no" value="{{$creditVoucher->cheque_no}}">
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
                                            <input type="text" class="form-control" name="bank" value="{{$creditVoucher->bank}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                            <label>{{__('Cheque Date')}}</label>
                                            <input type="date" class="form-control" name="cheque_dt" value="{{$creditVoucher->cheque_dt}}" >

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

