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
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}</label>
                                            <input type="text" id="pay_name" class="form-control" value="{{old('pay_name',$creditVoucher->pay_name)}}" name="pay_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Category">{{__('Received Account')}}</label>
                                                @php $credit_head=""; @endphp
                                                @if($crevoucherbkdn)
                                                @foreach($crevoucherbkdn as $bk)
                                                    @if($bk->debit >=0 )
                                                        @php $credit_head=$bk->table_name.$bk->table_id; @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                                <select  class="form-control" name="credit">
                                                    @if($paymethod)
                                                        @foreach($paymethod as $d)
                                                            <option {{$credit_head==$d['table_name'].$d['id']?"selected":""}} value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_code']}}-{{$d['head_name']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Category">{{__('Amount')}}</label>
                                            <input type="text" class="form-control" name="amount" value="{{old('amount',$creditVoucher->debit_sum)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="Purpose">{{__('Purpose')}}</label>
                                            <input type="text" id="purpose" class="form-control" value="{{old('purpose',$creditVoucher->purpose)}}" name="purpose">
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
@endsection

