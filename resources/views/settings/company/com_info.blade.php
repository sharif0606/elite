@extends('layout.app')

@section('pageTitle',trans('Company Information'))
@section('pageSubTitle',trans('Update'))

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                @if(Session::has('response'))
                {!!Session::get('response')['message']!!}
                @endif
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                           
                                <h6>My Company Information</h6>
                                <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.compaccinfo.update',encryptor('encrypt',$com_acc_info->id))}}">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="c_name">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" id="c_name" class="form-control" value="{{ old('c_name',$com_acc_info->c_name)}}" name="c_name">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="c_name">Company Address <span class="text-danger">*</span></label>
                                                <input type="text" id="c_address" class="form-control" value="{{ old('c_address',$com_acc_info->c_address)}}" name="c_address">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="c_name">Bank Name<span class="text-danger">*</span></label>
                                                <input type="text" id="bank_name" class="form-control" value="{{ old('bank_name',$com_acc_info->bank_name)}}" name="bank_name">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="c_name">Account Name<span class="text-danger">*</span></label>
                                                <input type="text" id="account_name" class="form-control" value="{{ old('account_name',$com_acc_info->account_name)}}" name="account_name">
                                            </div>
                                        </div> -->
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="c_name">Branch Name<span class="text-danger">*</span></label>
                                                <input type="text" id="branch_name" class="form-control" value="{{ old('branch_name',$com_acc_info->branch_name)}}" name="branch_name">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="account_number">Account code<span class="text-danger">*</span></label>
                                                <input type="text" id="account_number" class="form-control" value="{{ old('account_number',$com_acc_info->account_number)}}" name="account_number">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="swift_code">Swift Code<span class="text-danger">*</span></label>
                                                <input type="text" id="swift_code" class="form-control" value="{{ old('swift_code',$com_acc_info->swift_code)}}" name="swift_code">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="bank_address">Bank Address<span class="text-danger">*</span></label>
                                                <input type="text" id="bank_address" class="form-control" value="{{ old('bank_address',$com_acc_info->bank_address)}}" name="bank_address">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="bank_code">Bank Code<span class="text-danger">*</span></label>
                                                <input type="text" id="bank_code" class="form-control" value="{{ old('bank_code',$com_acc_info->bank_code)}}" name="bank_code">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="beni_name">Beneficiary’s Name<span class="text-danger">*</span></label>
                                                <input type="text" id="beni_name" class="form-control" value="{{ old('beni_name',$com_acc_info->beni_name)}}" name="beni_name">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="bank_address">Tel<span class="text-danger">*</span></label>
                                                <input type="text" id="tel" class="form-control" value="{{ old('tel',$com_acc_info->tel)}}" name="tel">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="fax">Fax<span class="text-danger">*</span></label>
                                                <input type="text" id="fax" class="form-control" value="{{ old('fax',$com_acc_info->fax)}}" name="fax">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="whatsup">Whatsup<span class="text-danger">*</span></label>
                                                <input type="text" id="whatsup" class="form-control" value="{{ old('whatsup',$com_acc_info->whatsup)}}" name="whatsup">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Email<span class="text-danger">*</span></label>
                                                <input type="text" id="email" class="form-control" value="{{ old('email',$com_acc_info->email)}}" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="website">Website<span class="text-danger">*</span></label>
                                                <input type="text" id="website" class="form-control" value="{{ old('website',$com_acc_info->website)}}" name="website">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                                        </div>
                                    </div>
                                </form>
                           


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection

@push('scripts')
<script>
    function showBranch(e) {
        $('#branch_id .branchs').hide();
        $('#branch_id .branchs' + e.value).show();
    }

    function hideCompany(e) {
        if (e == "1" || e == "2") {
            $('.company_row').hide();
        } else {
            $('.company_row').show();
        }
    }
    if ($('#role_id').val() == "1" || $('#role_id').val() == "2") {
        $('.company_row').hide();
    } else {
        $('.company_row').show();
    }
</script>
@endpush