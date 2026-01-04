@extends('layout.app')
@section('pageTitle','Advance Usage Detail')
@section('pageSubTitle','Advance #' . $advance->id)
@section('content')

<div class="col-12">
    <!-- Advance Summary Card -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-cash-stack"></i> Advance Details - ID #{{ $advance->id }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Customer:</strong><br>
                    {{ $advance->customer?->name }}
                </div>
                <div class="col-md-2">
                    <strong>Branch:</strong><br>
                    {{ $advance->branch?->brance_name ?? 'General' }}
                </div>
                <div class="col-md-2">
                    <strong>Advance Date:</strong><br>
                    {{ $advance->taken_date }}
                </div>
                <div class="col-md-2">
                    <strong>Original Amount:</strong><br>
                    <span class="badge bg-info">{{ number_format($advance->amount, 2) }}</span>
                </div>
                <div class="col-md-2">
                    <strong>Used Amount:</strong><br>
                    <span class="badge bg-danger">{{ number_format($advance->used_amount, 2) }}</span>
                </div>
                <div class="col-md-1">
                    <strong>Remaining:</strong><br>
                    <span class="badge bg-success">{{ number_format($advance->remaining_amount, 2) }}</span>
                </div>
            </div>
            <!-- Payment Information Section -->
            <div class="row border-top pt-3">
                <div class="col-md-12">
                    <h6 class="text-primary mb-3"><i class="bi bi-credit-card"></i> Payment Information</h6>
                </div>
                <div class="col-md-3">
                    <strong>Payment Mode:</strong><br>
                    @if($advance->payment_type)
                        @php
                            $paymentModes = [
                                1 => 'Cash',
                                2 => 'Pay Order',
                                3 => 'Fund Transfer',
                                4 => 'Online Pay'
                            ];
                        @endphp
                        <span class="badge bg-secondary">{{ $paymentModes[$advance->payment_type] ?? 'N/A' }}</span>
                    @else
                        <span class="text-muted">Not specified</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Deposit Bank:</strong><br>
                    @if($advance->depositBank)
                        <span class="badge bg-info">{{ $advance->depositBank->name }}</span>
                    @elseif($advance->deposit_bank)
                        <span class="text-muted">ID: {{ $advance->deposit_bank }}</span>
                    @else
                        <span class="text-muted">Not specified</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Bank Name:</strong><br>
                    @if($advance->bank_name)
                        <span class="badge bg-warning text-dark">{{ $advance->bank_name }}</span>
                    @else
                        <span class="text-muted">Not specified</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>ATM:</strong><br>
                    {{ $advance->atm?->atm ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Progress Bar -->
    <div class="card mb-3">
        <div class="card-body">
            <h6>Usage Progress</h6>
            @php
                $usagePercent = $advance->amount > 0 ? ($advance->used_amount / $advance->amount) * 100 : 0;
            @endphp
            <div class="progress" style="height: 30px;">
                <div class="progress-bar bg-success" role="progressbar" 
                     style="width: {{ 100 - $usagePercent }}%;" 
                     aria-valuenow="{{ 100 - $usagePercent }}" aria-valuemin="0" aria-valuemax="100">
                    Available: {{ number_format($advance->remaining_amount, 2) }}
                </div>
                <div class="progress-bar bg-danger" role="progressbar" 
                     style="width: {{ $usagePercent }}%;" 
                     aria-valuenow="{{ $usagePercent }}" aria-valuemin="0" aria-valuemax="100">
                    Used: {{ number_format($advance->used_amount, 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Usage History Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Usage History</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Usage Date</th>
                        <th>Used Amount</th>
                        <th>Invoice ID</th>
                        <th>Invoice Month</th>
                        <th>Payment ID</th>
                        <th>Grand Total</th>
                        <th>Remarks</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advance->usages as $usage)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->created_at)->format('Y-m-d H:i') }}</td>
                        <td class="text-success"><strong>{{ number_format($usage->used_amount, 2) }}</strong></td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                <a href="{{ route('invoiceGenerate.show', [encryptor('encrypt', $usage->invoicePayment->invoice->id)]) }}" 
                                   class="badge bg-info">
                                    #{{ $usage->invoicePayment->invoice->id }}
                                </a>
                            @endif
                        </td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                {{ \Carbon\Carbon::parse($usage->invoicePayment->invoice->end_date)->format('M-Y') }}
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">#{{ $usage->invoice_payment_id }}</span>
                        </td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                {{ number_format($usage->invoicePayment->invoice->grand_total, 2) }}
                            @endif
                        </td>
                        <td>{{ $usage->remarks ?? '-' }}</td>
                        <td>
                            @if($usage->invoicePayment?->invoice)
                                <a href="{{ route('invoiceGenerate.show', [encryptor('encrypt', $usage->invoicePayment->invoice->id)]) }}" 
                                   class="btn btn-sm btn-info" title="View Invoice">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No usage records found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total Used:</strong></td>
                        <td class="text-center text-success">
                            <strong>{{ number_format($advance->usages->sum('used_amount'), 2) }}</strong>
                        </td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('advance-usage.index', ['role' => currentUser()]) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Usage History
        </a>
        <a href="{{ route('advance.index', ['role' => currentUser()]) }}" class="btn btn-primary">
            <i class="bi bi-list"></i> View All Advances
        </a>
    </div>
</div>

@endsection

