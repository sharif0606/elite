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
                                            <label for="title">{{__('Title')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="title" class="form-control" value="{{ old('title')}}" name="title">
                                            @if($errors->has('title'))
                                                <span class="text-danger"> {{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="title_bn">{{__('Title Bn')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="title_bn" class="form-control" value="{{ old('title_bn')}}" name="title_bn">
                                            @if($errors->has('title_bn'))
                                                <span class="text-danger"> {{ $errors->first('title_bn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="department">{{__('Department')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="department" class="form-control" value="{{ old('department')}}" name="department">
                                            @if($errors->has('department'))
                                                <span class="text-danger"> {{ $errors->first('department') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="department_bn">{{__('Department Bn')}}<span class="text-danger">*</span></label>
                                            <input type="text" id="department_bn" class="form-control" value="{{ old('department_bn')}}" name="department_bn">
                                            @if($errors->has('department_bn'))
                                                <span class="text-danger"> {{ $errors->first('department_bn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="responsibility_dutie">{{__('দায়িত্ব ও কর্তব্য')}}<span onClick='ResponsibilityRepeat(this);' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="responsibility_dutie_repeater">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                            <div class="form-group">
                                                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="১. কোম্পনির নিয়ম-নীতি ও কর্তৃপক্ষের নির্দেশ অনুযায়ী সকল কার্যক্রম পরিচালনা করা।"></textarea>
                                                <input type="hidden" name="type[]" value="1">
                                                @if($errors->has('jobpostName'))
                                                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label for="skills">{{__('দক্ষতা')}}<span onClick='SkillRepeat();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="skills_repeater">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                            <div class="form-group">
                                                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="১. নিজের দায়িত্ব সম্পর্কে যথাযত জ্ঞান থাকতে হবে।"></textarea>
                                                <input type="hidden" name="type[]" value="2">
                                                @if($errors->has('jobpostName'))
                                                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label for="personality">{{__('ব্যক্তিত্ব')}}<span onClick='Personality();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="personality_repeater">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                            <div class="form-group">
                                                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="১. নিরাপত্তা নীতি, হয়রানী ও উৎপীড়নমুক্ত নীতি সম্পর্কে যথেষ্ট জ্ঞান ও প্রশিক্ষণ থাকতে হবে।"></textarea>
                                                <input type="hidden" name="type[]" value="3">
                                                @if($errors->has('jobpostName'))
                                                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                                                @endif
                                            </div>
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
@push("scripts")
<script>
    function ResponsibilityRepeat(){
        var responsibility=`
        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
            <div class="form-group">
                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="২. ফ্যাক্টরীর সম্পদের উপর সার্বক্ষণিক কড়া নজর রাখতে হবে।"></textarea>
                <input type="hidden" name="type[]" value="1">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.responsibility_dutie_repeater').after(responsibility);
        }
    function SkillRepeat(){
        var skill=`
        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
            <div class="form-group">
                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="১. নিজের দায়িত্ব সম্পর্কে যথাযত জ্ঞান থাকতে হবে।"></textarea>
                <input type="hidden" name="type[]" value="2">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.skills_repeater').after(skill);
        }
    function Personality(){
        var personality=`
        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
            <div class="form-group">
                <textarea class="form-control" name="description[]" id="" rows="2" placeholder="১. নিরাপত্তা নীতি, হয়রানী ও উৎপীড়নমুক্ত নীতি সম্পর্কে যথেষ্ট জ্ঞান ও প্রশিক্ষণ থাকতে হবে।"></textarea>
                <input type="hidden" name="type[]" value="3">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.personality_repeater').after(personality);
        }

</script>
@endpush
