@extends('layout.app')
@section('pageTitle', 'Salary Sheet Five List')
@section('pageSubTitle', 'All')
@section('content')
<style>
    th {
        background-color: blue !important;
        color: white !important;
        text-align: center !important;
    }
</style>
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-striped">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{ route('salarysheet.salarySheetFive') }}"><i
                        class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr class="text-center bg-primary text-white">
                        <th scope="col">{{ __('#SL') }}</th>
                        <th scope="col">{{ __('Customer') }}</th>
                        <th scope="col">{{ __('Month') }}</th>
                        <th scope="col">{{ __('Created at') }}</th>
                        <th class="white-space-nowrap">{{ __('ACTION') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salarysheet as $s)
                    <tr class="text-center">
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td scope="row">
                            <ul class="text-start">
                                @foreach ($s->customers as $customer)
                                <li>
                                    {{ $customer->name }}

                                    @php
                                    // Get unique branches related to this customer from salarysheet details
                                    $branches = collect($s->details)
                                    ->where('customer_id', $customer->id) // Match customer
                                    ->pluck('branches.brance_name')
                                    ->unique()
                                    ->filter();
                                    @endphp

                                    @if ($branches->isNotEmpty())
                                    <ul type="square">
                                        @foreach ($branches as $branch)
                                        <li><small>{{ $branch }}</small></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($s->month == $i)
                                {{ date('F', strtotime("2022-$i-01")) }}
                                @endif
                                @endfor
                                -{{ $s->year }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d-m-Y h:i:s A') }}</td>
                        <td>
                            <a class="px-1"
                                href="{{ route('salarysheet.salarySheetFiveShow', [encryptor('encrypt', $s->id)]) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a class="px-1"
                                href="{{ route('salarySheetFiveEdit', [encryptor('encrypt', $s->id), 'role' => currentUser()]) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a class="text-danger px-1" href="javascript:void()"
                                onclick="$('#form{{ $s->id }}').submit()">
                                <i class="bi bi-trash"></i>
                            </a>
                            <form id="form{{ $s->id }}" onsubmit="return confirm('Are you sure?')"
                                action="{{ route('salarySheet.destroy', encryptor('encrypt', $s->id)) }}"
                                method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2">
                {{$salarysheet->links()}}
            </div>
        </div>
    </div>
</div>
@endsection