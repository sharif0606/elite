@extends('layout.app')
@section('pageTitle','Advance Usage History')
@section('pageSubTitle','Track Advance Usage')
@section('content')

<div class="col-12">
    <!-- Summary Cards -->
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Advance Used</h5>
                    <h3>{{ number_format($totalUsed, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <h3>{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Average Usage</h5>
                    <h3>{{ $totalTransactions > 0 ? number_format($totalUsed / $totalTransactions, 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <form method="get" action="">
            <div class="row p-3">
                <div class="col-lg-3 col-md-6 col-sm-12 py-1">
                    <label for="">Customer</label>
                    <select name="customer_id" id="customer_id" class="select2 form-select">
                        <option value="">All Customers</option>
                        @foreach ($customers as $c)
                            <option value="{{$c->id}}" {{request()->customer_id==$c->id?'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="fdate">From Date</label>
                    <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                    <label for="tdate">To Date</label>
                    <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
                </div>
                <div class="col-lg-2 col-sm-6 py-1">
                    <label for="advance_id">Advance ID</label>
                    <input type="number" id="advance_id" class="form-control" value="{{ request('advance_id')}}" name="advance_id" placeholder="Advance ID">
                </div>
                <div class="col-sm-3 py-3">
                    <button type="submit" class="btn btn-sm btn-info mt-2">Search</button>
                    <a href="{{route('advance-usage.index', ['role' => currentUser()])}}" class="btn btn-sm btn-danger mt-2">Clear</a>
                </div>
            </div>
        </form>

        <!-- Usage History Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th scope="col">#SL</th>
                        <th scope="col">Date</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Advance ID</th>
                        <th scope="col">Advance Date</th>
                        <th scope="col">Original Amount</th>
                        <th scope="col">Used Amount</th>
                        <th scope="col">Remaining</th>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">Invoice Month</th>
                        <th scope="col">Branch/ATM</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usages as $usage)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $usage->customer?->name }}</td>
                        <td>
                            <a href="{{ route('advance-usage.detail', [encryptor('encrypt', $usage->advance_id), 'role' => currentUser()]) }}" 
                               class="badge bg-primary" title="View advance details">
                                #{{ $usage->advance_id }}
                            </a>
                        </td>
                        <td>{{ $usage->advance?->taken_date }}</td>
                        <td>{{ number_format($usage->advance?->amount, 2) }}</td>
                        <td class="text-success"><strong>{{ number_format($usage->used_amount, 2) }}</strong></td>
                        <td>{{ number_format($usage->advance?->remaining_amount, 2) }}</td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                <a href="{{ route('invoiceGenerate.show', [encryptor('encrypt', $usage->invoicePayment->invoice->id)]) }}" 
                                   class="badge bg-info" title="View invoice">
                                    #{{ $usage->invoicePayment->invoice->id }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                {{ \Carbon\Carbon::parse($usage->invoicePayment->invoice->end_date)->format('M-Y') }}
                            @endif
                        </td>
                        <td>
                            {{ $usage->advance?->branch?->brance_name ?? 'General' }}
                            @if($usage->advance?->atm)
                                <br><small class="text-muted">{{ $usage->advance->atm->atm_name }}</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('invoiceGenerate.show', [encryptor('encrypt', $usage->invoicePayment?->invoice_id ?? 0)]) }}" 
                               class="btn btn-sm btn-info" title="View Invoice">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">No usage records found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="6" class="text-end"><strong>Total on this page:</strong></td>
                        <td class="text-center text-success"><strong>{{ number_format($usages->sum('used_amount'), 2) }}</strong></td>
                        <td colspan="5"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="pt-2">
                {{ $usages->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
@endpush

