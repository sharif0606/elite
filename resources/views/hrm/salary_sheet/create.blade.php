@extends('layout.app')

@section('pageTitle',trans('Salary Sheet'))
@section('pageSubTitle',trans('Create'))

@section('content')
<style>
    .myDIV {
      writing-mode: vertical-lr;
      text-orientation: mixed;
    }
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row p-2 mt-4">
                            <div class="col-lg-3 mt-4 p-0">
                                <a href="{{route('salarySheetOne')}}" class="btn btn-primary">Salary Sheet One</a>
                            </div>
                            <div class="col-lg-3 mt-4 p-0">
                                <a href="{{route('salarySheetTwo')}}" class="btn btn-primary">Salary Sheet Two</a>
                            </div>
                            <div class="col-lg-3 mt-4 p-0">
                                <button type="button" class="btn btn-primary">Salary Sheet Three</button>
                            </div>
                            <div class="col-lg-3 mt-4 p-0">
                                <button type="button" class="btn btn-primary">Salary Sheet Four</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
</script>
@endpush
