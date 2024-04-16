@extends('layout.app')
@section('pageTitle',trans('Deduction Asign List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <div>
                <a class="btn btn-sm btn-primary float-end" href="{{route('deduction_asign.create')}}"><i class="bi bi-plus-square"></i></a>
                </div>
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col"><a href="{{route('fineIndex')}}" class="btn btn-primary">Fine List</a></th>
                                <th scope="col"><a href="{{route('mobileBillIndex')}}" class="btn btn-primary">Mobile Bill</a></th>
                                <th scope="col"><a href="{{route('loanIndex')}}" class="btn btn-primary">Loan</a></th>
                                <th scope="col"><a href="{{route('clothIndex')}}" class="btn btn-primary">Cloth</a></th>
                                <th scope="col"><a href="{{route('JacketIndex')}}" class="btn btn-primary">Jacket</a></th>
                                <th scope="col"><a href="{{route('HrIndex')}}" class="btn btn-primary">Hr</a></th>
                                <th scope="col"><a href="{{route('CfIndex')}}" class="btn btn-primary">CF</a></th>
                                <th scope="col"><a href="{{route('medicalIndex')}}" class="btn btn-primary">Medical</a></th>
                                <th scope="col"><a href="{{route('MatterssPillowIndex')}}" class="btn btn-primary">Matterss Pillow Cost</a></th>
                                <th scope="col"><a href="{{route('tonicSimIndex')}}" class="btn btn-primary">Tonic Sim</a></th>
                                <th scope="col"><a href="{{route('overPaymentIndex')}}" class="btn btn-primary">Over Payment</a></th>
                            </tr>
                            <tr>
                                <th scope="col"><a href="{{route('bankChargeIndex')}}" class="btn btn-primary">Bank Charge/Exc</a></th>
                                <th scope="col"><a href="{{route('DressIndex')}}" class="btn btn-primary">Dress</a></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection
