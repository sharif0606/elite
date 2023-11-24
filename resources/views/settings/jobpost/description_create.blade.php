@extends('layout.app')

@section('pageTitle',trans('Create Description'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" action="{{route(currentUser().'.jobpost.store',['role' =>currentUser()])}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Title')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Title Bn')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Department')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jobpostName">{{__('Department Bn')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="responsibility_dutie">{{__('দায়িত্ব ও কর্তব্য')}}<span onClick='addRow();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                            {{--  <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName" >  --}}
                                            <textarea class="form-control" name="" id="" rows="2" placeholder="১৫. কন্টেইনার কারখানায় প্রবেশের পূর্বে এর ভিতর ও বাহির সঠিকভাবে মেটাল ডিটেক্টর দিয়ে পরীক্ষা করে দেখতে হবে কোথাও কোনো বিষ্ফোরক দ্রব্য, দাহ্যপদার্থ, অবৈধ মালামাল ও যন্ত্রপাতি আছে কিনা। যদি অবৈধ কোনো কিছু পাওয়া যায় তবে তা সাথে সাথে কর্তৃপক্ষকে অবহিত করতে হবে।"></textarea>
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="skills">{{__('দক্ষতা')}}<span onClick='addRow();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName" placeholder="১৫. কন্টেইনার কারখানায় প্রবেশের পূর্বে এর ভিতর ও বাহির সঠিকভাবে মেটাল ডিটেক্টর দিয়ে পরীক্ষা করে দেখতে হবে কোথাও কোনো বিষ্ফোরক দ্রব্য, দাহ্যপদার্থ, অবৈধ মালামাল ও যন্ত্রপাতি আছে কিনা। যদি অবৈধ কোনো কিছু পাওয়া যায় তবে তা সাথে সাথে কর্তৃপক্ষকে অবহিত করতে হবে।">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="personality">{{__('ব্যক্তিত্ব')}}<span onClick='addRow();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                            <input type="text" id="jobpostName" class="form-control" value="{{ old('jobpostName')}}" name="jobpostName" placeholder="১৫. কন্টেইনার কারখানায় প্রবেশের পূর্বে এর ভিতর ও বাহির সঠিকভাবে মেটাল ডিটেক্টর দিয়ে পরীক্ষা করে দেখতে হবে কোথাও কোনো বিষ্ফোরক দ্রব্য, দাহ্যপদার্থ, অবৈধ মালামাল ও যন্ত্রপাতি আছে কিনা। যদি অবৈধ কোনো কিছু পাওয়া যায় তবে তা সাথে সাথে কর্তৃপক্ষকে অবহিত করতে হবে।">
                                            @if($errors->has('jobpostName'))
                                                <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                            @endif
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
@endsection
