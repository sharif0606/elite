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
                            <form class="form" method="post" action="{{route('jobpost_descriptionstor',encryptor('encrypt',$description?->id))}}">
                                @csrf
                                <input type="hidden" value="{{ $jobpost->id }}" name="jobpost_id">
                                <h5 class="text-center">Job Post: {{ $jobpost?->name }}</h5>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="title">{{__('Title')}}</label>
                                            <input type="text" id="title" class="form-control" value="{{ old('title',$description?->title)}}" name="title">
                                            @if($errors->has('title'))
                                                <span class="text-danger"> {{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="title_bn">{{__('Title Bn')}}<span class="text-danger">*</span></label>
                                            <input required type="text" id="title_bn" class="form-control" value="{{ old('title_bn',$description?->title_bn)}}" name="title_bn">
                                            @if($errors->has('title_bn'))
                                                <span class="text-danger"> {{ $errors->first('title_bn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="department">{{__('Department')}}</label>
                                            <input type="text" id="department" class="form-control" value="{{ old('department',$description?->department)}}" name="department">
                                            @if($errors->has('department'))
                                                <span class="text-danger"> {{ $errors->first('department') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="department_bn">{{__('Department Bn')}}<span class="text-danger">*</span></label>
                                            <input required type="text" id="department_bn" class="form-control" value="{{ old('department_bn',$description?->department_bn)}}" name="department_bn">
                                            @if($errors->has('department_bn'))
                                                <span class="text-danger"> {{ $errors->first('department_bn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="head_title">{{__('Head Title')}}<span class="text-danger">*</span></label>
                                            <input required type="text" id="head_title" class="form-control" value="{{ old('head_title',$description?->head_title)}}" name="head_title">
                                            @if($errors->has('head_title'))
                                                <span class="text-danger"> {{ $errors->first('head_title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="head_title_bn">{{__('Head Title Bn')}}<span class="text-danger">*</span></label>
                                            <input required type="text" id="head_title_bn" class="form-control" value="{{ old('head_title_bn',$description?->head_title_bn)}}" name="head_title_bn">
                                            @if($errors->has('head_title_bn'))
                                                <span class="text-danger"> {{ $errors->first('head_title_bn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="responsibility_dutie">{{__('দায়িত্ব ও কর্তব্য')}}<span onClick='ResponsibilityRepeat(this);' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="responsibility_dutie_repeater">
                                        @if ($description?->details)
                                            @foreach ($description->details as $d)
                                                @if ($d->type == '1')
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="responsibility_dutie[]" id="" rows="2" placeholder="১. কোম্পনির নিয়ম-নীতি ও কর্তৃপক্ষের নির্দেশ অনুযায়ী সকল কার্যক্রম পরিচালনা করা।">{{$d->description }}</textarea>
                                                            <input type="hidden" name="type_responsibility[]" value="{{'1',$d->type}}">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label for="skills">{{__('দক্ষতা')}}<span onClick='SkillRepeat();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="skills_repeater">
                                        @if ($description?->details)
                                            @foreach ($description->details as $d)
                                                @if ($d->type == '2')
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="description_skill[]" id="" rows="2" placeholder="১. নিজের দায়িত্ব সম্পর্কে যথাযত জ্ঞান থাকতে হবে।">{{$d->description }}</textarea>
                                                            <input type="hidden" name="type_skill[]" value="2">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label for="personality">{{__('ব্যক্তিত্ব')}}<span onClick='Personality();' class="add-row text-primary ms-2"><i class="bi bi-plus-square-fill"></i></span></label>
                                    <div class="personality_repeater">
                                        @if ($description?->details)
                                            @foreach ($description->details as $d)
                                                @if ($d->type == '3')
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="description_personality[]" id="" rows="2" placeholder="১. নিরাপত্তা নীতি, হয়রানী ও উৎপীড়নমুক্ত নীতি সম্পর্কে যথেষ্ট জ্ঞান ও প্রশিক্ষণ থাকতে হবে।">{{$d->description }}</textarea>
                                                            <input type="hidden" name="type_personality[]" value="3">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
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
                <textarea class="form-control" name="responsibility_dutie[]" id="" rows="2" placeholder="২. ফ্যাক্টরীর সম্পদের উপর সার্বক্ষণিক কড়া নজর রাখতে হবে।"></textarea>
                <input type="hidden" name="type_responsibility[]" value="1">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.responsibility_dutie_repeater').append(responsibility);
        }
    function SkillRepeat(){
        var skill=`
        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
            <div class="form-group">
                <textarea class="form-control" name="description_skill[]" id="" rows="2" placeholder="১. নিজের দায়িত্ব সম্পর্কে যথাযত জ্ঞান থাকতে হবে।"></textarea>
                <input type="hidden" name="type_skill[]" value="2">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.skills_repeater').append(skill);
        }
    function Personality(){
        var personality=`
        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
            <div class="form-group">
                <textarea class="form-control" name="description_personality[]" id="" rows="2" placeholder="১. নিরাপত্তা নীতি, হয়রানী ও উৎপীড়নমুক্ত নীতি সম্পর্কে যথেষ্ট জ্ঞান ও প্রশিক্ষণ থাকতে হবে।"></textarea>
                <input type="hidden" name="type_personality[]" value="3">
                @if($errors->has('jobpostName'))
                    <span class="text-danger"> {{ $errors->first('jobpostName') }}</span>
                @endif
            </div>
        </div>
        `;
            $('.personality_repeater').append(personality);
        }

</script>
@endpush
