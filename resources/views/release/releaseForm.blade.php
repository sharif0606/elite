@extends('layout.app')
@section('pageTitle',trans('Release'))
@section('pageSubTitle',trans('release'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form action="">
                    <div class="row">
                        <div class="text-center">
                            <h3 class="mb-4">Release Form</h3>
                        </div>
                        <?php
                        print_r($data);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection