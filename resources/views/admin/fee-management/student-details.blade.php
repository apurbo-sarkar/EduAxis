<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Details - {{ $student->name }}</title>
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
            margin-left: 10px;
        }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-card i { font-size: 36px; margin-bottom: 15px; }
        .stat-card h3 {
            font-size: 14px;
            color: #718096;
            margin-bottom: 8px;
        }
        .stat-card .amount {
            font-size: 28px;
            font-weight: bold;
            color: #2d3748;
        }
        .stat-card.invoiced i { color: #3498db; }
        .stat-card.paid i { color: #2ecc71; }
        .stat-card.balance i { color: #e74c3c; }
        
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .student-info {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .student-info h2 { color: #2d3748; margin-bottom: 15px; }
        .student-info p { margin: 8px 0; color: #4a5568; }
        
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
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-partial { background: #dbeafe; color: #1e40af; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        
        .action-links { display: flex; gap: 10px; }
        .action-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        .action-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-graduate"></i> Student Fee Details</h1>
            <div>
                <a href="{{ route('admin.fee.invoices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Invoice
                </a>
                <a href="{{ route('admin.fee.invoices') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="content-card" style="margin-bottom: 30px;">
            <div class="student-info">
                <h2>{{ $student->name }}</h2>
                <p><strong>Email:</strong> {{ $student->email }}</p>
                <p><strong>Student ID:</strong> {{ $student->id }}</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card invoiced">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>Total Invoiced</h3>
                <div class="amount">${{ number_format($totalInvoiced, 2) }}</div>
            </div>
            <div class="stat-card paid">
                <i class="fas fa-check-circle"></i>
                <h3>Total Paid</h3>
                <div class="amount">${{ number_format($totalPaid, 2) }}</div>
            </div>
            <div class="stat-card balance">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Total Balance</h3>
                <div class="amount">${{ number_format($totalBalance, 2) }}</div>
            </div>
        </div>

        <div class="content-card">
            <h2 style="margin-bottom: 20px; color: #2d3748;">Invoice History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                        <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                        <td>${{ number_format($invoice->paid_amount, 2) }}</td>
                        <td>${{ number_format($invoice->balance, 2) }}</td>
                        <td><span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span></td>
                        <td class="action-links">
                            <a href="{{ route('admin.fee.invoices.view', $invoice->invoice_id) }}">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #718096;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                            No invoices found for this student
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>