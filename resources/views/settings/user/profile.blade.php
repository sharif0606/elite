@extends('layout.landing')

@section('pageTitle',trans('My Account'))

@push('styles')
<style>
    .match-height {
        background: #eee;
    }
    .form-group,form-control{
        font-size: 14px;;
    }
</style>
@endpush


@section('content')
@include('layout.nav.user')
<!-- // Basic multiple Column Form section start -->

<section id="profile">
    <div class="container">
        <div class="row">
            <div class="match-height p-3 m-3">
                <div class="col-12">
                    <h4>Account Information</h4>
                    @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Company Info</h6>
                            @if($com_info)
                            <table class="table table-bordered">
                                <tr>
                                    <th>Company</th>
                                    <td>{{$com_info->c_name}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{$com_info->c_address}}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>
                                        <p class="m-0">Telephone: {{$com_info->tel}}</p>
                                        <p class="m-0">Fax: {{$com_info->fax}}</p>
                                        <p class="m-0">Email: {{$com_info->email}}</p>
                                        <p class="m-0">Whatsup: {{$com_info->email}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bank</th>
                                    <td>
                                        <p class="m-0">Bank: {{$com_info->bank_name}}</p>
                                        <p class="m-0">Account: {{$com_info->account_name}}</p>
                                        <p class="m-0">Branch: {{$com_info->branch_name}}</p>
                                        <p class="m-0">Account: {{$com_info->account_number}}</p>
                                        <p class="m-0">Swift Code: {{$com_info->swift_code}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bank Address</th>
                                    <td>{{$com_info->bank_address}}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{$com_info->website}}</td>
                                </tr>
                            </table>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6>My Account Info</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <img src="{{asset('uploads/admin/'.$user->image)}}" onerror="this.onerror=null;this.src='{{asset('uploads/admin/profileimage.jpg')}}';" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-end">Name: </th>
                                    <td> {{ $user->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Id: </th>
                                    <td> {{ $user->id}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Email: </th>
                                    <td> {{ $user->email}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Contact Number: </th>
                                    <td> {{ $user->contact_no}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Department: </th>
                                    <td> {{ $user->department?->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Designation: </th>
                                    <td> {{ $user->designation?->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Role: </th>
                                    <td> {{ $user->role?->type}}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Status: </th>
                                    <td> {!! $user->status?"<i class='badge bg-success'>Active</i>":"<i class='badge bg-success'>Inactive</i>" !!}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6>Update Account Info</h6>
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.profile.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="userName">Name <span class="text-danger">*</span></label>
                                            <input type="text" id="userName" class="form-control" value="{{ old('userName',$user->name)}}" name="userName">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" id="contactNumber" class="form-control" value="{{ old('contactNumber',$user->contact_no)}}" name="contactNumber">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="country_id">Import Country<span class="text-danger">*</span></label>
                                            <select id="country_id" class="form-control" name="country_id" disabled>
                                                @if(count($countries) > 0)
                                                @forelse($countries as $c)
                                                <option value="{{$c->id}}" @if($user->country_id == $c->id) selected @endif>{{$c->name}}</option>
                                                @empty
                                                @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="country_id">Port<span class="text-danger">*</span></label>
                                            <select id="port_id" class="form-control" name="port_id">
                                                @if(count($ports) > 0)
                                                @forelse($ports as $p)
                                                <option value="{{$p->id}}" @if($user->port_id == $p->id) selected @endif>{{$p->name}}</option>
                                                @empty
                                                @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" id="image" class="form-control" placeholder="Image" name="image">
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-2">
                                        <button type="submit" class="btn btn-sm btn-primary me-1 mb-1">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <h6 class="text-center">Update User Details Information</h6>
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.userdetl.store')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->userDetl->id}}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="address1">Address<span class="text-danger">*</span></label>
                                        <textarea id="address1" class="form-control" name="address1" rows="4">{{ old('address1',$user->userDetl->address1)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="address2">Address Contact(Details)<span class="text-danger">*</span></label>
                                        <textarea id="address2" class="form-control" name="address2" rows="4">{{ old('address2',$user->userDetl->address2)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <input type="text" id="city" class="form-control" value="{{ old('city',$user->userDetl->city)}}" name="city">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="state">State <span class="text-danger">*</span></label>
                                        <input type="text" id="state" class="form-control" value="{{ old('state',$user->userDetl->state)}}" name="state">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="zip">Zip <span class="text-danger">*</span></label>
                                        <input type="text" id="zip" class="form-control" value="{{ old('zip',$user->userDetl->zip)}}" name="zip">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary me-1 mb-1">Save</button>
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