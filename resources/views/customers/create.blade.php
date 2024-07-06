@extends('layout.app')
@section('pageTitle','Add Customer ')
@section('pageSubTitle','New Customer ')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('customer.store', ['role' =>currentUser()])}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h5 class="text-center m-0">Customer details</h5>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="name">Customer Name<span class="text-danger">*</span></label>
                            <input type="text" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Customer Name" name="name">
                            @if($errors->has('name'))
                                <span class="text-danger"> {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="contact">Phone Number</label>
                            <input type="text" id="contact" value="{{old('contact')}}" class="form-control @error('contact') is-invalid @enderror" placeholder="Contact Number" name="contact">
                            @if($errors->has('contact'))
                                <span class="text-danger"> {{ $errors->first('contact') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="file_upload_name">File Upload Name</label>
                            <input type="text" id="file_upload_name" value="{{old('file_upload_name')}}" class="form-control" placeholder="" name="file_upload_name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="file_upload">Upload File</label>
                            <input type="file" id="file_upload" value="{{old('file_upload')}}" class="form-control" placeholder="" name="file_upload">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="bin">Bin</label>
                            <input type="text" id="bin" value="{{old('bin')}}" class="form-control" placeholder="Bin" name="bin">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input type="text" id="invoice_number" value="{{old('invoice_number')}}" class="form-control" placeholder="Invoice Number" name="invoice_number">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for=""><b>Zone</b></label>
                        <select class="form-select" id="zone" name="zone_id">
                            <option value="">Select Zone</option>
                            @forelse ($zones as $z)
                            <option value="{{ $z->id }}">{{ $z->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for=""><b>Customer Type</b></label>
                        <select class="form-select" name="customer_type" onchange="getCustomerType();" required>
                            <option value="">Select type</option>
                            <option value="0">Institution</option>
                            <option value="1">Bank</option>
                        </select>
                    </div>
                    <div class="col-12 d-none" id="billSection">
                        <div class="row py-2 my-1" style="border: solid 1px red; border-radius: 8px;">
                            <div class="text-center"><h5 class="text-danger">Billing Information</h5></div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="contact_person">Contact Person Name</label>
                                    <input type="text" id="contact_person" value="{{old('contact_person')}}" class="form-control" placeholder="Contact Person" name="contact_person">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="billing_person">Billing Person Name</label>
                                    <input type="text" id="billing_person" value="{{old('billing_person')}}" class="form-control" placeholder="Billing Person Name" name="billing_person">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="agreement_date">Agreement Date</label>
                                    <input type="date" id="agreement_date" value="{{old('agreement_date')}}" class="form-control" name="agreement_date">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="renew_date">Renew Date</label>
                                    <input type="date" id="renew_date" value="{{old('renew_date')}}" class="form-control" name="renew_date">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="validity_date">Validity Date</label>
                                    <input type="date" id="validity_date" value="{{old('validity_date')}}" class="form-control" name="validity_date">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Vat(%)</b></label>
                                    <input class="form-control vat" id="vat" type="number" name="vat" value="{{old('vat')}}" placeholder="Vat">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Take Home Salary</b></label>
                                    <input class="form-control take_home" id="take_home" type="text" name="take_home" value="{{old('take_home')}}" placeholder="Take Home Salary">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Royalty</b></label>
                                    <input class="form-control royal_tea" type="text" name="royal_tea" value="{{old('royal_tea')}}" placeholder="Royalty">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>AIT</b></label>
                                    <input class="form-control ait" type="text" name="ait" value="{{old('ait')}}" placeholder="AIT">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Received By Ctg</b></label>
                                    <input class="form-control received_by_city" type="text" name="received_by_city" value="{{old('received_by_city')}}" placeholder="Received By Ctg">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Attention</b></label>
                                    <input class="form-control attention" type="text" name="attention" value="{{old('attention')}}" placeholder="Attention">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for=""><b>Attention Details</b></label>
                                    <input class="form-control attention_details" type="text" name="attention_details" value="{{old('attention_details')}}" placeholder="Attention Details">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" rows="2" placeholder="Full Address" name="address">{{old('address')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" value="" data-height="110" data-default-file="{{ asset('assets/images/customerdefault.png') }}" class="form-control dropify">
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end my-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
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

    function getCustomerType() {
        var ctype = document.querySelector('select[name="customer_type"]').value;

        if (ctype === "0") {
            $('#billSection').removeClass('d-none');
        }else {
            $('#contact_person').val('');
            $('#billing_person').val('');
            $('#agreement_date').val('');
            $('#renew_date').val('');
            $('#validity_date').val('');
            $('#vat').val('');
            $('#take_home').val('');
            $('.royal_tea').val('');
            $('.ait').val('');
            $('.received_by_city').val('');
            $('.attention').val('');
            $('.attention_details').val('');
            $('#address').val('');
            $('#billSection').addClass('d-none');
        }
    }
</script>

<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush
