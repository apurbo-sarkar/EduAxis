@extends('student.app')
@section('content')

<div class="payslip-container">
    <div class="page-header">
        <h2><i class="bi bi-receipt"></i> My Fee Payslips</h2>
    </div>

    <div class="stats-overview">
        <div class="stat-box total">
            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="stat-info">
                <h3>Total Invoiced</h3>
                <p class="amount">${{ number_format($stats['total_invoiced'], 2) }}</p>
            </div>
        </div>
        <div class="stat-box paid">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-info">
                <h3>Total Paid</h3>
                <p class="amount">${{ number_format($stats['total_paid'], 2) }}</p>
            </div>
        </div>
        <div class="stat-box pending">
            <div class="stat-icon"><i class="bi bi-exclamation-circle"></i></div>
            <div class="stat-info">
                <h3>Balance Due</h3>
                <p class="amount">${{ number_format($stats['total_balance'], 2) }}</p>
            </div>
        </div>
        <div class="stat-box invoices">
            <div class="stat-icon"><i class="bi bi-file-earmark-arrow-down"></i></div>
            <div class="stat-info">
                <h3>Pending Invoices</h3>
                <p class="amount">{{ $stats['pending_invoices'] }}</p>
            </div>
        </div>
    </div>

    <div class="invoices-section">
        <h3>Invoice History</h3>
        
        @forelse($invoices as $invoice)
        <div class="invoice-card">
            <div class="invoice-header-section">
                <div class="invoice-info">
                    <h4>{{ $invoice->invoice_number }}</h4>
                    <p class="invoice-date">
                        <i class="bi bi-calendar-event"></i> {{ $invoice->invoice_date->format('M d, Y') }}
                    </p>
                    <p class="due-date">
                        <i class="bi bi-clock"></i> Due: {{ $invoice->due_date->format('M d, Y') }}
                    </p>
                </div>
                <div class="invoice-status">
                    <span class="status-badge status-{{ $invoice->status }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                    <div class="invoice-amount">
                        <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="invoice-details">
                <div class="detail-row">
                    <span>Total Amount:</span>
                    <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
                </div>
                <div class="detail-row">
                    <span>Paid Amount:</span>
                    <strong class="text-success">${{ number_format($invoice->paid_amount, 2) }}</strong>
                </div>
                <div class="detail-row total-row">
                    <span>Balance Due:</span>
                    <strong class="text-danger">${{ number_format($invoice->balance, 2) }}</strong>
                </div>
            </div>

            <div class="invoice-actions">
                <a href="{{ route('student.invoice.view', $invoice->invoice_id) }}" class="btn btn-primary">
                    <i class="bi bi-eye"></i> View Details
                </a>
                @if($invoice->status !== 'paid')
                <a href="{{ route('student.payment.initiate', $invoice->invoice_id) }}" class="btn btn-success">
                    <i class="bi bi-credit-card"></i> Make Payment
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>No Invoices Found</h4>
            <p>You don't have any invoices yet.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('styles')
<style>
    .payslip-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
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

    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .stat-box.total .stat-icon {
        background: #e3f2fd;
        color: #1976d2;
    }

    .stat-box.paid .stat-icon {
        background: #e8f5e9;
        color: #388e3c;
    }

    .stat-box.pending .stat-icon {
        background: #fff3e0;
        color: #f57c00;
    }

    .stat-box.invoices .stat-icon {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .stat-info h3 {
        font-size: 14px;
        color: #718096;
        margin: 0 0 5px 0;
        font-weight: 500;
    }

    .stat-info .amount {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .invoices-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .invoices-section h3 {
        font-size: 20px;
        color: #2d3748;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .invoice-card {
        background: #f8f9fa;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.2s;
    }

    .invoice-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #cbd5e0;
    }

    .invoice-header-section {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .invoice-info h4 {
        font-size: 18px;
        color: #2d3748;
        margin: 0 0 10px 0;
        font-weight: 600;
    }

    .invoice-date, .due-date {
        font-size: 14px;
        color: #718096;
        margin: 5px 0;
    }

    .invoice-date i, .due-date i {
        margin-right: 5px;
    }

    .invoice-status {
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.status-paid {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.status-overdue {
        background: #f8d7da;
        color: #721c24;
    }

    .status-badge.status-partial {
        background: #d1ecf1;
        color: #0c5460;
    }

    .invoice-amount {
        margin-top: 10px;
    }

    .invoice-amount strong {
        font-size: 22px;
        color: #2d3748;
    }

    .invoice-details {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 15px;
    }

    .detail-row span {
        color: #718096;
    }

    .detail-row strong {
        color: #2d3748;
    }

    .detail-row.total-row {
        border-top: 2px solid #e2e8f0;
        margin-top: 8px;
        padding-top: 12px;
        font-size: 16px;
    }

    .text-success {
        color: #38a169 !important;
    }

    .text-danger {
        color: #e53e3e !important;
    }

    .invoice-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #0d6efd;
        color: white;
    }

    .btn-primary:hover {
        background: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }

    .btn-success {
        background: #198754;
        color: white;
    }

    .btn-success:hover {
        background: #157347;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(25, 135, 84, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        font-size: 20px;
        color: #4a5568;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 16px;
        color: #718096;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .payslip-container {
            padding: 15px;
        }

        .stats-overview {
            grid-template-columns: 1fr;
        }

        .invoice-header-section {
            flex-direction: column;
            gap: 15px;
        }

        .invoice-status {
            text-align: left;
        }

        .invoice-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 20px;
        }

        .stat-info .amount {
            font-size: 20px;
        }

        .invoice-info h4 {
            font-size: 16px;
        }

        .invoice-amount strong {
            font-size: 18px;
        }
    }
</style>
@endpush