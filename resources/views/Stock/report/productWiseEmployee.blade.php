@extends('layout.app')
@section('pageTitle','Product Wise Employee Report')
@section('pageSubTitle','Product-wise Employee Stock Report')
@section('content')
<section class="section">
    <div class="col-12">
        <div class="card">
            <form class="form" method="get" action="">
                <div class="row p-3">
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_1">{{__('Product 1')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_1" id="product_id_1" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_1==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_2">{{__('Product 2')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_2" id="product_id_2" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_2==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_3">{{__('Product 3')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_3" id="product_id_3" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_3==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_4">{{__('Product 4')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_4" id="product_id_4" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_4==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_5">{{__('Product 5')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_5" id="product_id_5" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_5==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1">
                        <label for="product_id_6">{{__('Product 6')}} <small class="text-muted">(1 Qty Only)</small></label>
                        <select name="product_id_6" id="product_id_6" class="select2 form-select">
                            <option value="">Select Product</option>
                            @forelse ($allProducts as $prod)
                                <option value="{{$prod->id}}" {{request()->product_id_6==$prod->id?'selected':''}}>
                                    {{$prod->product_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="row p-3 pt-0">
                    <div class="col-lg-2 col-md-6 col-sm-12 py-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-success me-1 mb-1">Search</button>
                        <a href="{{route('stock.productWiseEmployee')}}" class="btn btn-sm btn-warning mb-1">Reset</a>
                    </div>
                    <div class="col-lg-10 col-md-12 py-1">
                        <div class="alert alert-info mb-0">
                            <small><i class="bi bi-info-circle"></i> <strong>Note:</strong> Select up to 6 products to find employees who have taken exactly 1 quantity of each selected product.</small>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="text-end p-3">
                <button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
            </div>
            
            <div class="card-content" id="result_show">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Product-wise Employee Report</h5>
                    
                    @if(!empty($selectedProducts))
                        <div class="alert alert-success mb-3 no-print">
                            <strong>Filter Applied:</strong> Showing employees who have taken exactly <strong>1 quantity</strong> of the following products:
                            <ul class="mb-0 mt-2">
                                @foreach($selectedProducts as $productId)
                                    @php
                                        $product = $products[$productId] ?? null;
                                    @endphp
                                    <li>{{ $product ? $product->product_name : 'Product ID: ' . $productId }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(!empty($employeeRows) && !empty($selectedProducts))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th scope="col" style="width: 3%;">{{__('#SL')}}</th>
                                        <th scope="col" style="width: 8%;">{{__('Employee ID')}}</th>
                                        <th scope="col" style="width: 15%;">{{__('Employee Name')}}</th>
                                        @foreach($selectedProducts as $productId)
                                            @php
                                                $product = $products[$productId] ?? null;
                                            @endphp
                                            <th scope="col" class="text-center" style="background-color: #e9ecef; width: 12%;">
                                                {{ $product ? $product->product_name : 'Product ID: ' . $productId }}
                                            </th>
                                        @endforeach
                                        <th scope="col" style="width: 8%;">{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sl = 1;
                                    @endphp
                                    @foreach($employeeRows as $employeeId => $productData)
                                        @php
                                            $employee = $employees[$employeeId] ?? null;
                                        @endphp
                                        <tr class="text-center">
                                            <td style="font-size: 0.9em;">{{ $sl++ }}</td>
                                            <td style="font-size: 0.9em;">
                                                @if($employee)
                                                    {{ $employee->admission_id_no }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-start" style="font-size: 0.9em;">
                                                @if($employee)
                                                    {{ $employee->bn_applicants_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            @foreach($selectedProducts as $productId)
                                                <td class="text-center" style="font-size: 0.9em;">
                                                    @if(isset($productData[$productId]['qty']) && $productData[$productId]['qty'])
                                                        <span class="badge bg-info" style="font-size: 0.85em;">{{ number_format($productData[$productId]['qty'], 0) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                @if($employee)
                                                    <a href="{{route('stock.employeeIndividual', [encryptor('encrypt', $employee->id), 'type' => 1])}}" 
                                                       class="btn btn-sm btn-info" title="View Employee Stock">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total Employees:</strong></td>
                                        <td colspan="{{ count($selectedProducts) + 1 }}" class="text-center">
                                            <strong>{{ count($employeeRows) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif(empty($selectedProducts))
                        <div class="alert alert-warning text-center">
                            <i class="bi bi-exclamation-triangle"></i> Please select at least one product to generate the report.
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> No employees found who have taken exactly 1 quantity of all selected products.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('styles')
<style>
    @media print {
        .no-print, .alert, .btn, 
        #result_show .alert-success,
        #result_show table th:last-child,
        #result_show table td:last-child,
        table th:last-child,
        table td:last-child {
            display: none !important;
        }
        #result_show table tfoot,
        table tfoot {
            display: none !important;
        }
        #result_show .card-title {
            display: block !important;
        }
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    
    function printDiv(divName) {
        // Get only the table element (skip filter details and alerts)
        var tableElement = document.querySelector('#' + divName + ' table');
        if (!tableElement) {
            alert('Table not found');
            return;
        }
        
        // Clone the table
        var tableClone = tableElement.cloneNode(true);
        
        // Remove action column from header - always remove the last column
        var headerRow = tableClone.querySelector('thead tr');
        if (headerRow) {
            var headerCells = headerRow.querySelectorAll('th');
            if (headerCells.length > 0) {
                // Always remove the last header cell (action column)
                headerCells[headerCells.length - 1].remove();
            }
        }
        
        // Remove action column from all body rows - always remove the last column
        var bodyRows = tableClone.querySelectorAll('tbody tr');
        bodyRows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                // Always remove the last cell (action column)
                cells[cells.length - 1].remove();
            }
        });
        
        // Remove footer row completely
        var tfoot = tableClone.querySelector('tfoot');
        if (tfoot) {
            tfoot.remove();
        }
        
        // Get total employees count
        var totalEmployees = {{ count($employeeRows) ?? 0 }};
        
        // Create a clean HTML document for printing (no filter, no action column)
        var printContent = '<!DOCTYPE html><html><head><title>Product-wise Employee Report</title>';
        printContent += '<style>';
        printContent += '@page { size: A4; margin: 0.4cm; }';
        printContent += 'body { font-family: Arial, sans-serif; font-size: 8px; margin: 0; padding: 2px; }';
        printContent += 'table { width: 100%; border-collapse: collapse; font-size: 7px; table-layout: fixed; }';
        printContent += 'table, th, td { border: 1px solid #000; }';
        printContent += 'th { background-color: #f2f2f2; padding: 2px 1px; text-align: center; font-weight: bold; font-size: 6.5px; }';
        printContent += 'td { padding: 2px 1px; text-align: center; font-size: 6.5px; word-wrap: break-word; }';
        printContent += 'thead { display: table-header-group; }';
        printContent += 'tr { page-break-inside: avoid; }';
        printContent += '.print-title { text-align: center; font-size: 10px; font-weight: bold; margin-bottom: 2px; }';
        printContent += '.print-total { margin-top: 10px; padding: 5px; text-align: center; border-top: 2px solid #000; font-weight: bold; font-size: 8px; background: #f2f2f2; }';
        printContent += '@media print {';
        printContent += '  @page { size: A4; margin: 0.4cm; }';
        printContent += '  thead { display: table-header-group; }';
        printContent += '  tbody tr { page-break-inside: avoid; }';
        printContent += '}';
        printContent += '</style>';
        printContent += '</head><body>';
        printContent += '<div class="print-title">Product-wise Employee Report</div>';
        printContent += tableClone.outerHTML;
        printContent += '<div class="print-total">Total Employees: ' + totalEmployees + '</div>';
        printContent += '</body></html>';
        
        // Create print window
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // Wait for content to load, then print
        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 500);
        };
        
        // Fallback if onload doesn't fire
        setTimeout(function() {
            if (!printWindow.closed) {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }
        }, 1000);
    }
</script>
@endpush

