@extends('layout.app')

@section('pageTitle',trans('Create Deduction'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route('deduction_asign.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Salary Year</b></label>
                                        <select required class="form-control year" name="year">
                                            <option value="">Select Year</option>
                                            @for($i=2023;$i<= date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <label for=""><b>Salary Month</b></label>
                                        <select required class="form-control month" name="month">
                                            <option value="">Select Month</option>
                                            @for($i=1;$i<= 12;$i++)
                                            <option value="{{ $i }}">{{ date('F',strtotime("2022-$i-01")) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class="form-group">
                                            <label for="role_id">Deduction</label>
                                            <select class="form-control" name="deduction" id="deduction">
                                                <option value="0">Select</option>
                                                <option value="1">Fine</option>
                                                <option value="2">Mobile Bill</option>
                                                <option value="3">Loan</option>
                                                <option value="4">Cloth</option>
                                                <option value="5">Jacket</option>
                                                <option value="6">Hr</option>
                                                <option value="7">CF</option>
                                                <option value="8">Medical</option>
                                                <option value="9">Matterss Pillow Cost</option>
                                                <option value="10">Tonic Sim</option>
                                                <option value="11">Over Payment</option>
                                            </select>
                                            @if($errors->has('deduction'))
                                                <span class="text-danger"> {{ $errors->first('deduction') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">{{__('Employee')}}</th>
                                                    <th scope="col">{{__('Taka')}}</th>
                                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="deductiorepet">
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="employee_id[]" id="employee_id">
                                                            <option value="0">Select</option>
                                                            @foreach ($employees as $e)
                                                            <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="amount" class="form-control" value="{{ old('amount')}}" name="amount[]">
                                                        @if($errors->has('amount'))
                                                            <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
@push("scripts")
<script>
    function addRow(){
    var row=`
    <tr>
        <td>
            <select class="form-control" name="employee_id[]" id="employee_id">
                <option value="0">Select</option>
                @foreach ($employees as $e)
                <option value="{{ $e->id }}">{{ $e->bn_applicants_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" id="amount" class="form-control" value="{{ old('amount')}}" name="amount[]">
            @if($errors->has('amount'))
                <span class="text-danger"> {{ $errors->first('amount') }}</span>
            @endif
        </td>
        <td>
            <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
        </td>
    </tr>
    `;
        $('#deductiorepet').append(row);
    }

    function removeRow(e) {
        if (confirm("Are you sure you want to remove this row?")) {
            $(e).closest('tr').remove();
        }
    }
</script>
@endpush
