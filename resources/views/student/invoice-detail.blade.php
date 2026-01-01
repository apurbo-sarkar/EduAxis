@extends('student.app')
@section('content')

<div class="invoice-detail-container">
    <div class="page-header">
        <h2><i class="bi bi-file-earmark-text"></i> Invoice Details</h2>
        <div class="header-actions">
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="bi bi-printer"></i> Print
            </button>
            <a href="{{ route('student.payslip') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="invoice-content">
        <div class="invoice-header-info">
            <div class="invoice-number">
                <h3>{{ $invoice->invoice_number }}</h3>
                <span class="status-badge status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>
            <div class="invoice-dates">
                <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="student-info">
            <h4>Bill To:</h4>
            <p><strong>{{ $invoice->student->name }}</strong></p>
            <p>{{ $invoice->student->email }}</p>
        </div>

        <div class="invoice-items">
            <h4>Invoice Items</h4>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td class="text-right">${{ number_format($item->amount, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
            </div>
            <div class="summary-row">
                <span>Paid Amount:</span>
                <strong class="text-success">${{ number_format($invoice->paid_amount, 2) }}</strong>
            </div>
            <div class="summary-row total">
                <span>Balance Due:</span>
                <strong class="text-danger">${{ number_format($invoice->balance, 2) }}</strong>
            </div>
        </div>

        @if($invoice->description)
        <div class="invoice-description">
            <h4>Description:</h4>
            <p>{{ $invoice->description }}</p>
        </div>
        @endif

        @if($invoice->payments->count() > 0)
        <div class="payment-history">
            <h4>Payment History</h4>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Payment Reference</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->payment_reference }}</strong></td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if($invoice->status !== 'paid')
        <div class="payment-action">
            <a href="{{ route('student.payment.initiate', $invoice->invoice_id) }}" class="btn btn-success btn-large">
                <i class="bi bi-credit-card"></i> Make Payment of ${{ number_format($invoice->balance, 2) }}
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .invoice-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h2 {
        color: #2d3748;
        font-size: 24px;
        font-weight: 600;
        margin: 0;
    }

    .page-header h2 i {
        color: #0d6efd;
        margin-right: 10px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .invoice-content {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .invoice-header-info {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .invoice-number h3 {
        color: #2d3748;
        font-size: 24px;
        margin: 0 0 10px 0;
    }

    .status-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-partial { background: #dbeafe; color: #1e40af; }
    .status-paid { background: #d1fae5; color: #065f46; }
    .status-overdue { background: #fee2e2; color: #991b1b; }

    .invoice-dates p {
        color: #718096;
        margin: 5px 0;
        text-align: right;
    }

    .student-info {
        background: #f7fafc;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .student-info h4 {
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .student-info p {
        margin: 5px 0;
        color: #4a5568;
    }

    .invoice-items {
        margin-bottom: 30px;
    }

    .invoice-items h4,
    .payment-history h4 {
        color: #2d3748;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead {
        background: #f7fafc;
    }

    .items-table th,
    .items-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .invoice-summary {
        background: #f7fafc;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        max-width: 400px;
        margin-left: auto;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 15px;
    }

    .summary-row.total {
        border-top: 2px solid #2d3748;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 20px;
        font-weight: bold;
    }

    .text-success { color: #28a745; }
    .text-danger { color: #d32f2f; }

    .invoice-description {
        background: #f7fafc;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .invoice-description h4 {
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .payment-history {
        margin-bottom: 30px;
    }

    .payment-action {
        text-align: center;
        padding: 30px 0;
        border-top: 2px solid #e2e8f0;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .btn-primary { background: #0d6efd; color: white; }
    .btn-secondary { background: #6c757d; color: white; }
    .btn-success { background: #28a745; color: white; }
    .btn-outline {
        background: white;
        color: #4a5568;
        border: 1px solid #cbd5e0;
    }

    .btn-large {
        padding: 15px 40px;
        font-size: 18px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    @media print {
        body { background: white; }
        .page-header .header-actions,
        .payment-action { display: none; }
        .invoice-content { box-shadow: none; }
    }

    @media (max-width: 768px) {
        .invoice-content { padding: 20px; }
        .invoice-header-info { flex-direction: column; gap: 20px; }
        .invoice-dates { text-align: left; }
        .invoice-summary { max-width: 100%; }
    }
</style>
@endpush