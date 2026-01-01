<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Payments - Fee Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { max-width: 1400px; margin: 0 auto; }
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
        }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .filter-section input, .filter-section select {
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }
        
        table { width: 100%; border-collapse: collapse; }
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
        tr:hover { background: #f7fafc; }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        
        .action-links { display: flex; gap: 10px; }
        .action-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        .action-links a:hover { text-decoration: underline; }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #4a5568;
        }
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-money-check-alt"></i> All Payments</h1>
            <a href="{{ route('admin.fee.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="content-card">
            <div class="filter-section">
                <input type="text" placeholder="Search by payment reference or student..." style="flex: 1; min-width: 300px;">
                <input type="date" placeholder="From Date">
                <input type="date" placeholder="To Date">
                <select>
                    <option value="">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="online">Online Payment</option>
                </select>
                <button class="btn btn-secondary">Filter</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Payment Ref</th>
                        <th>Invoice #</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->payment_reference }}</strong></td>
                        <td>{{ $payment->invoice->invoice_number }}</td>
                        <td>{{ $payment->student->name }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td><span class="status-badge status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></td>
                        <td class="action-links">
                            <a href="{{ route('admin.fee.invoices.view', $payment->invoice_id) }}">
                                <i class="fas fa-eye"></i> View Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: #718096;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                            No payments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</body>
</html>