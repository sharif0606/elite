@extends('layout.app')
@section('pageTitle',trans('Release List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">

            <div class="card">
                <form method="get" action="" class="no-print">
                    <div class="row p-3">
                        <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                            <label for="admission_id_no">{{__('Employee ID')}}</label>
                            <input type="text" id="admission_id_no" name="admission_id_no" class="form-control" value="{{ request('admission_id_no') }}" placeholder="Employee ID">
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                            <label for="fdate">{{__('From Date')}}</label>
                            <input type="date" id="fdate" class="form-control" value="{{ request('fdate') }}" name="fdate">
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                            <label for="tdate">{{__('To Date')}}</label>
                            <input type="date" id="tdate" class="form-control" value="{{ request('tdate') }}" name="tdate">
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 py-1 d-flex align-items-end flex-wrap gap-2">
                            <button type="submit" class="btn btn-sm btn-info">{{__('Search')}}</button>
                            <a href="{{ route('relEmployee.index', ['role' => currentUser()]) }}" class="btn btn-sm btn-danger">{{__('Clear')}}</a>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="printReleaseList()"><i class="bi bi-printer"></i> {{__('Print')}}</button>
                            <a class="btn btn-sm btn-primary ms-auto" href="{{ route('relEmployee.create', ['role' => currentUser()]) }}"><i class="bi bi-plus-square"></i></a>
                        </div>
                    </div>
                </form>
                @if(Session::has('response'))
                    {!!Session::get('response')['message']!!}
                @endif
                <div id="result_show">
                    <div class="text-center mb-3 d-none d-print-block">
                        <h4>{{ __('Release Employee List') }}</h4>
                        @if(request('admission_id_no') || request('fdate') || request('tdate'))
                            <p class="mb-0">
                                @if(request('admission_id_no'))
                                    {{ __('Employee ID') }}: {{ request('admission_id_no') }}
                                @endif
                                @if(request('fdate') || request('tdate'))
                                    | {{ __('Date') }}: {{ request('fdate') ?? '...' }} - {{ request('tdate') ?? date('Y-m-d') }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Employee Name')}}</th>
                                    <th scope="col">{{__('Employee ID')}}</th>
                                    <th scope="col">{{__('Resign Date')}}</th>
                                    <th class="white-space-nowrap no-print">{{__('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $d)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $d->employee?->bn_applicants_name }}</td>
                                    <td>{{ $d->employee?->admission_id_no }}</td>
                                    <td>{{ $d->resign_date }}</td>
                                    <td class="no-print">
                                        <a href="{{route('relEmployee.show',encryptor('encrypt',$d->id))}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a class="mx-2" href="{{route('relEmployee.edit',encryptor('encrypt',$d->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                         <a class="text-danger" href="javascript:void(0)" onclick="$('#form{{$d->id}}').submit()">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <form id="form{{ $d->id }}" onsubmit="return confirm('Are you sure?')" action="{{ route('relEmployee.destroy', encryptor('encrypt', $d->id)) }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form> 
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>
@endsection

@push('scripts')
<script>
    function printReleaseList() {
        var prtDiv = document.getElementById('result_show');
        var prtContent = prtDiv.innerHTML;

        var printFrame = document.createElement('iframe');
        printFrame.style.position = 'absolute';
        printFrame.style.width = '0px';
        printFrame.style.height = '0px';
        printFrame.style.border = 'none';
        document.body.appendChild(printFrame);

        var doc = printFrame.contentWindow.document;
        doc.open();
        doc.write(`
            <html>
            <head>
                <title>Release Employee List</title>
                <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" type="text/css" />
                <style>
                    .no-print { display: none !important; }
                    body { padding: 20px; }
                    table { width: 100%; }
                </style>
            </head>
            <body>
                <div>${prtContent}</div>
            </body>
            </html>
        `);
        doc.close();

        setTimeout(function() {
            printFrame.contentWindow.focus();
            printFrame.contentWindow.print();
            document.body.removeChild(printFrame);
        }, 500);
    }
</script>
@endpush
