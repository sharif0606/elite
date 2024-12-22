@extends('layout.app')

@section('pageTitle',trans('Stock Individual Product Wise Reports'))
@section('pageSubTitle',trans('Reports'))
@push("styles")
<link rel="stylesheet" href="{{ asset('assets/css/main/full-screen.css') }}">
@endpush
@section('content')
<style>
    @media screen and (max-width: 800px) {
  .tbl_scroll {
    overflow: scroll;
  }
}
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="text-end">
                    <button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
                </div>
                <form class="form" method="get" action="">
                    <div class="row">
                        <div class="col-4 py-1">
                            <label for="fdate">{{__('From Date')}}</label>
                            <input type="date" id="fdate" class="form-control" value="{{ old('fdate')}}" name="fdate">
                        </div>
                        <div class="col-4 py-1">
                            <label for="fdate">{{__('To Date')}}</label>
                            <input type="date" id="tdate" class="form-control" value="{{ old('tdate')}}" name="tdate">
                        </div>
                        <div class="col-4 mt-4 d-flex">
                            <div class="col-6 ">
                                <button type="submit" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>

                            </div>
                            <div class="col-6">
                                <button type="#" class="btn pbtn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Reset')}}</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-content" id="result_show">
                        <style>

                            .tbl_expense{
                            border: 1px solid;
                            border-collapse: collapse;
                            }
                            </style>
                        <div class="card-body">
                            <table style="width: 100%">
                                <tr style="text-align: center;">
                                    <th colspan="2">
                                        <h4>এলিট সিকিউরিটি সার্ভিসেস লিমিটেড</h4>
                                        <p>বাড়ি নং-২,লেইন নং-২,রোড নং-২,ব্লক-''কে''</p>
                                        <p>হালিশহর হাউজিং এষ্টেট,চট্টগ্রাম-৪২২৪</p>
                                        {{--  <p>E-MAIL: <a href="#" style="border-bottom: solid 1px; border-color:blue;">{{encryptor('decrypt', request()->session()->get('companyEmail'))}}</a> Contact: {{encryptor('decrypt', request()->session()->get('companyContact'))}}</p>  --}}
                                        <h6><span style="border-bottom: solid 1px;">{{$product?->product_name}}</span></h6>
                                        <p>Stock Item Register</p>
                                    </th>
                                </tr>
                            </table>
                            <div class="tbl_scroll">
                                <table class="tbl_expense" style="width:100%">
                                    <tbody>
                                        <tr class="tbl_expense">
                                            <th colspan="4" class="tbl_expense" style="text-align: center; padding: 5px;">Product Details</th>
                                            <th colspan="2" class="tbl_expense" style="text-align: center; padding: 5px;">IN</th>
                                            <th colspan="2" class="tbl_expense" style="text-align: center; padding: 5px;">OUT</th>
                                            <th colspan="2" class="tbl_expense" style="text-align: center; padding: 5px;">Damage</th>
                                            <th rowspan="2" class="tbl_expense" style="text-align: center; padding: 5px;">Total STOCK</th>
                                        </tr>
                                        <tr class="tbl_expense">
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Employee</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Type</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Size</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Entry Date</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Quantity</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">In Date</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Quantity</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Issue Date</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Quantity</th>
                                            <th class="tbl_expense" style="text-align: center; padding: 5px;">Date</th>
                                        </tr>
                                        @php
                                            $actualQtyTotalkg = 0;
                                            $totalQty = 0;
                                        @endphp
                                        @forelse($stock as $s)
                                        <tr class="tbl_expense">
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">
                                                @if($s->employee && $s->employee?->bn_applicants_name)

                                                {{$s->employee?->bn_applicants_name}}
                                                {{' ( Id- '.$s->employee?->admission_id_no.' )'}}
                                                @else
                                                {{$s->company?->name}}/ Branch- {{$s->company_branch?->brance_name}}
                                                @endif
                                            </td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">@if($s->type=='2') Used @else New  @endif </td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{$s->size?->name}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{\Carbon\Carbon::parse($s->created_at)->format('d/m/Y')}}</td>
                                            @if($s->status=='0')
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{$s->product_qty}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{\Carbon\Carbon::parse($s->entry_date)->format('d/m/Y')}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            @elseif($s->status=='1')
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{abs($s->product_qty)}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{\Carbon\Carbon::parse($s->entry_date)->format('d/m/Y')}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            @elseif($s->status=='2')
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{abs($s->product_qty)}}</td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">{{\Carbon\Carbon::parse($s->entry_date)->format('d/m/Y')}}</td>
                                            @else
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;"></td>
                                            @endif
                                            <td class="tbl_expense" style="text-align: center; padding: 5px;">
                                                @php echo $totalQty += $s->product_qty; @endphp

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <th colspan="10">No data Found</th>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <table style="width: 100%; margin-top: 5rem;">
                                <tr style="padding-top: 5rem;">
                                    {{--  <th style="text-align: center;"><h6>CHECKED BY</h6></th>
                                    <th style="text-align: center;"><h6>VERIFIED BY</h6></th>  --}}
                                    <th style="text-align: center;"><h6>Authoraised Signatory</h6></th>
                                </tr>
                            </table>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')

<script src="{{ asset('/assets/js/full_screen.js') }}"></script>
@endpush
