@extends('layout.app')
@section('pageTitle','Employee List')
@section('pageSubTitle','All Employee')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <form method="get" action="">
            <div class="row">
                <div class="col-sm-3">
                    <label for="">ID</label>
                    <input type="text" name="admission_id_no" class="form-control" value="{{ request()->admission_id_no }}">
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-info">Search</button>
                    <a href="{{route('employee.index', ['role' =>currentUser()])}}" class="btn btn-danger">Clear</a>
                </div>
                <div class="col-sm-6 py-3">
                    <a class="btn btn-sm btn-primary float-end my-2" href="{{route('employee.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                </div>

            </div>
        </form>
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr class="text-center">
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Bangla')}}</th>
                        <th scope="col">{{__('English')}}</th>
                        <th class="white-space-nowrap" width=20%>{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $e)
                    <tr>
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>
                            <p><strong>আইডি নং:</strong> {{$e->admission_id_no}}</p>
                            <p><strong>আবেদনকারীর নাম:</strong> {{$e->bn_applicants_name}}</p>
                            <p><strong>পিতার নাম:</strong> {{$e->bn_fathers_name}}</p>
                            <p><strong>মাতার নাম:</strong> {{$e->bn_mothers_name}}</p>
                        </td>
                        <td>
                            <p><strong>Applicant's Name:</strong> {{$e->en_applicants_name}}</p>
                            <p><strong>Father's Name:</strong> {{$e->en_fathers_name}}</p>
                            <p><strong>Mothers's Name:</strong> {{$e->en_mothers_name}}</p>
                            <p><strong>National ID No:</strong> {{$e->en_nid_no}}</p>
                        </td>
                        <td class="text-center">
                            <a class="px-1" href="{{route('employee.show',encryptor('encrypt',$e->id))}}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a class="px-1" href="{{route('employee.edit',[encryptor('encrypt',$e->id),'role' =>currentUser()])}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="btn btn-sm btn-primary px-2" href="{{route('securityGuards',encryptor('encrypt',$e->id))}}">
                                Security
                            </a>
                            <a class="btn btn-sm btn-success px-2" target="_blank" href="{{route('employee.certificate',encryptor('encrypt',$e->id))}}">
                                Certificate
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="4" class="text-center">No Data Found</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{$employees->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
