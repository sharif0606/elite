@extends('layout.app')

@section('pageTitle',trans('Reply Inquiry'))
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
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.inquiry.update',encryptor('encrypt',$inquiry->id))}}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="remarks">Query <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="5">{{$inquiry->remarks}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks">Reply <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="reply" rows="5">{{old('reply',$inquiry->reply)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
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