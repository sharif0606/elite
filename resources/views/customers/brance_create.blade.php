@extends('layout.app')
@section('pageTitle','Add Branch ')
@section('pageSubTitle','New Branch ')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('customerbrance.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h4 class="text-center m-0">{{ $cbran->name }}</h4>
                    <h5 class="text-center m-0">Branch details</h5>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="brance_name">Branch Name</label>
                            <input type="text" id="brance_name" value="{{old('brance_name')}}" class="form-control @error('brance_name') is-invalid @enderror" placeholder="Branch Name" name="brance_name">
                            @if($errors->has('brance_name'))
                                <span class="text-danger"> {{ $errors->first('brance_name') }}</span>
                            @endif
                        </div>
                        <input type="hidden" name="customer_id" value="{{$cbran->id}}">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact_person">Contact Person Name</label>
                            <input type="text" id="contact_person" value="{{old('contact_person')}}" class="form-control" placeholder="Contact Person" name="contact_person">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact_number">Contact Mobile No.</label>
                            <input type="text" id="contact_number" value="{{old('contact_number')}}" class="form-control" placeholder="Contact Mobile no." name="contact_number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="billing_person">Billing Person Name</label>
                            <input type="text" id="billing_person" value="{{old('billing_person')}}" class="form-control" placeholder="Billing Person Name" name="billing_person">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="agreement_date">Agreement Date</label>
                            <input type="date" id="agreement_date" value="{{old('agreement_date')}}" class="form-control" placeholder="" name="agreement_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="renew_date">Renew Date</label>
                            <input type="date" id="renew_date" value="{{old('renew_date')}}" class="form-control" placeholder="" name="renew_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="validity_date">Validity Date</label>
                            <input type="date" id="validity_date" value="{{old('validity_date')}}" class="form-control" placeholder="" name="validity_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Vat(%)</b></label>
                        <input required class="form-control vat" type="number" name="vat" value="" placeholder="Vat">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Billing Rate</b></label>
                        <input class="form-control" type="text" name="billing_rate" value="" placeholder="Billing Rate">
                    </div> 
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Take Home Salary</b></label>
                        <input class="form-control take_home" type="text" name="take_home" value="" placeholder="Take Home Salary">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Royalty</b></label>
                        <input class="form-control royal_tea" type="text" name="royal_tea" value="" placeholder="Royalty">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>AIT</b></label>
                        <input class="form-control ait" type="text" name="ait" value="" placeholder="AIT">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Received By Ctg</b></label>
                        <input class="form-control received_by_city" type="text" name="received_by_city" value="" placeholder="Received By Ctg">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Attention</b></label>
                        <input class="form-control attention" type="text" name="attention" value="" placeholder="Attention">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Attention Details</b></label>
                        <input class="form-control attention_details" type="text" name="attention_details" value="" placeholder="Attention Details">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>Zone</b></label>
                        {{--  <input class="form-control zone" type="text" name="zone" value="" placeholder="Zone">  --}}
                        <select class="form-select" id="zone" name="zone_id">
                            <option value="">Select Zone</option>
                            @forelse ($zone as $z)
                            <option value="{{ $z->id }}">{{ $z->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for=""><b>ATM</b></label>
                        <div  id="atmadd">
                            <input class="form-control" type="text" name="atm[]" value="" placeholder="ATM">

                        </div>
                        <p onClick='addRow();' class="add-row text-primary  text-end"><i class="bi bi-plus-square-fill"></i></p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="billing_address">Billing Address</label>
                            <textarea class="form-control" id="billing_address" rows="5" placeholder="Billing Address" name="billing_address">{{old('billing_address')}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function addRow(){

        var row=`
        <div class="d-flex">
            <input class="form-control" type="text" name="atm[]" value="" placeholder="ATM">
            <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        </div>
        `;
            $('#atmadd').append(row);
        }

        function removeRow(e) {
            if (confirm("Are you sure you want to remove this row?")) {
                $(e).closest('.d-flex').remove();
            }
        }


    /* call on load page */
    $(document).ready(function(){
        $('.district').hide();
        $('.upazila').hide();
    })

    function show_upazila(e){
         $('.district').hide();
         $('.district'+e).show();
    }
    function show_unions(e){
         $('.upazila').hide();
         $('.upazila'+e).show();
    }


</script>

<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush
