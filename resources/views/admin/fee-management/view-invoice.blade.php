<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details - {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { max-width: 1000px; margin: 0 auto; }
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #2d3748; font-size: 28px; font-weight: 600; }
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
            margin-left: 10px;
        }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
       
        .invoice-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        .invoice-info h2 { color: #2d3748; margin-bottom: 10px; }
        .invoice-info p { color: #718096; margin: 5px 0; }
        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-partial { background: #dbeafe; color: #1e40af; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
       
        .student-details {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .student-details h3 { color: #2d3748; margin-bottom: 10px; }
       
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #f7fafc;
            font-weight: 600;
            color: #4a5568;
        }
        .text-right { text-align: right; }
       
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .summary-box {
            width: 350px;
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .summary-row.total {
            font-size: 20px;
            font-weight: bold;
            border-top: 2px solid #2d3748;
            border-bottom: none;
            margin-top: 10px;
            padding-top: 15px;
        }
       
        .payment-section {
            background: #f7fafc;
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .payment-section h3 { color: #2d3748; margin-bottom: 20px; }
       
        .payment-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
            color: #4a5568;
            font-weight: 600;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
       
        .payments-history {
            margin-top: 20px;
        }

        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
       
        @media print {
            body { background: white; padding: 0; }
            .header, .btn, .payment-section { display: none; }
            .invoice-card { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-invoice"></i> Invoice Details</h1>
            <div>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="{{ route('admin.fee.invoices') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="invoice-card">
            <div class="invoice-header">
                <div class="invoice-info">
                    <h2>{{ $invoice->invoice_number }}</h2>
                    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                    <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="status-badge status-{{ $invoice->status }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>

            <div class="student-details">
                <h3>Student Information</h3>
                <p><strong>Name:</strong> {{ $invoice->student->full_name }}</p>
                <p><strong>Admission Number:</strong> {{ $invoice->student->admission_number }}</p>
                <p><strong>Email:</strong> {{ $invoice->student->student_email }}</p>
                <p><strong>Class:</strong> {{ $invoice->student->student_class }}</p>
            </div>

            <h3 style="margin-bottom: 15px; color: #2d3748;">Invoice Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td class="text-right">${{ number_format($item->amount, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary-section">
                <div class="summary-box">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format($invoice->total_amount, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Paid Amount:</span>
                        <span style="color: #28a745;">${{ number_format($invoice->paid_amount, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Balance Due:</span>
                        <span style="color: #e74c3c;">${{ number_format($invoice->balance, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($invoice->description)
            <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Description:</strong> {{ $invoice->description }}
            </div>
            @endif
        </div>

        @if($invoice->status !== 'paid')
        <div class="invoice-card">
            <div class="payment-section">
                <h3><i class="fas fa-money-check-alt"></i> Record Payment</h3>
                <form action="{{ route('admin.fee.payments.record', $invoice->invoice_id) }}" method="POST">
                    @csrf
                    <div class="payment-form">
                        <div class="form-group">
                            <label for="amount">Amount *</label>
                            <input type="number" name="amount" id="amount" step="0.01" max="{{ $invoice->balance }}" value="{{ $invoice->balance }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date *</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method *</label>
                            <select name="payment_method" id="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="online">Online Payment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="transaction_id">Transaction ID (Optional)</label>
                            <input type="text" name="transaction_id" id="transaction_id">
                        </div>
                        <div class="form-group full-width">
                            <label for="remarks">Remarks (Optional)</label>
                            <textarea name="remarks" id="remarks" rows="2"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 10px; padding: 12px;">
                        <i class="fas fa-check"></i> Record Payment
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($invoice->payments->count() > 0)
        <div class="invoice-card">
            <h3 style="margin-bottom: 20px; color: #2d3748;">
                <i class="fas fa-history"></i> Payment History
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>Payment Ref</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->payment_reference }}</strong></td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>
</html>