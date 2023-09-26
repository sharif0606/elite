@extends('layout.app')

@section('pageTitle',trans('Invoice Generate'))
@section('pageSubTitle',trans('Create'))

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route('invoiceGenerate.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Customer</b></label>
                                    <select class="form-select customer_id" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @forelse ($customer as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Start Date</b></label>
                                    <input class="form-control start_date" type="date" name="start_date" value="" placeholder="Start Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>End Date</b></label>
                                    <input class="form-control end_date" type="date" name="end_date" value="" placeholder="End Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Bill Date</b></label>
                                    <input class="form-control" type="date" name="bill_date" value="" placeholder="Bill Date">
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Vat</b></label>
                                    <input class="form-control" type="text" name="vat" value="" placeholder="Vat">
                                </div>
                                <div class="col-lg-3 mt-4 p-0">
                                    <button onclick="getInvoiceData()" type="button" class="btn btn-primary">Generate Bill</button>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tr class="text-center">
                                        <th>S.L</th>
                                        <th>Service</th>
                                        <th>Rate</th>
                                        <th>Total Person</th>
                                        <th>Working Days</th>
                                        <th>Total Hours</th>
                                        <th>Rate per hours</th>
                                        <th>Vat</th>
                                        <th>Total Amount</th>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>01</td>
                                        <td>Security In-Charg</td>
                                        <td>20,076/-</td>
                                        <td>01</td>
                                        <th>23</th>
                                        <td>184</td>
                                        <td>109.10/-</td>
                                        <td>109.10/-</td>
                                        <td>20,076/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>02</td>
                                        <td>Security Supervisor</td>
                                        <td>15,600/-</td>
                                        <td>03</td>
                                        <th>23</th>
                                        <td>552</td>
                                        <td>84.78/-</td>
                                        <td>84.78/-</td>
                                        <td>46,800/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>03</td>
                                        <td>Receptionist</td>
                                        <td>14,676/-</td>
                                        <td>01</td>
                                        <th>23</th>
                                        <td>184</td>
                                        <td>79.76/-</td>
                                        <td>14,676/-</td>
                                        <td>14,676/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>04</td>
                                        <td>Security Guard (Premium)</td>
                                        <td>13,200/-</td>
                                        <td>06</td>
                                        <th>23</th>
                                        <td>1104</td>
                                        <td>71.73/-</td>
                                        <td>71.73/-</td>
                                        <td>79,200/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>05</td>
                                        <td>Security Guard (B Grade)</td>
                                        <td>10,596/-</td>
                                        <td>12</td>
                                        <th>23</th>
                                        <td>2208</td>
                                        <td>57.58/-</td>
                                        <td>57.58/-</td>
                                        <td>1,27,152/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>06</td>
                                        <td>Security Guard (Female)</td>
                                        <td>12,000/-</td>
                                        <td>02</td>
                                        <th>23</th>
                                        <td>386</td>
                                        <td>65.21/-</td>
                                        <td>65.21/-</td>
                                        <td>24,000/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td></td>
                                        <th colspan="7">Sub Tatal</th>
                                        <td>3,11,904/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td></td>
                                        <td colspan="7">Less: 01 duty absent of Receptionist on 17-18/07/2023</td>
                                        <td>978/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td></td>
                                        <td colspan="7">Less: 03 duty absent of Security Guard (Female) on 30-31/07/2023 & 20/08/2023</td>
                                        <td>400/-</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td></td>
                                        <th colspan="7">Tatal</th>
                                        <td>3,08,482/-</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
    function getInvoiceData(e){
        var customer=$('.customer_id').val();
        var startDate=$('.start_date').val();
        var endDate=$('.end_date').val();
        $.ajax({
            url: "{{route('get_invoice_data')}}",
            type: "GET",
            dataType: "json",
            data: { customer_id:customer,start_date:startDate,end_date:endDate },
            success: function(data) {
                console.log(data);

            },
        });
     }
</script>

@endpush
