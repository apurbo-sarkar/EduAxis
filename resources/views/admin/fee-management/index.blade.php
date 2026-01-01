<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Management - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
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
        .header h1 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 600;
        }
        .header h1 i { color: #dc3545; margin-right: 10px; }
        .back-btn {
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .back-btn:hover { background: #5a6268; }
        
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
        .stat-card i {
            font-size: 36px;
            margin-bottom: 15px;
        }
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
        .stat-card.collected i { color: #2ecc71; }
        .stat-card.pending i { color: #e74c3c; }
        .stat-card.students i { color: #9b59b6; }
        
        .quick-actions {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .quick-actions h2 {
            margin-bottom: 20px;
            color: #2d3748;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .action-btn {
            padding: 15px 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s;
            font-weight: 600;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        .action-btn i { margin-right: 8px; }
        
        .recent-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
        }
        .recent-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .recent-card h2 {
            margin-bottom: 20px;
            color: #2d3748;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #f7fafc;
            font-weight: 600;
            color: #4a5568;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-partial { background: #dbeafe; color: #1e40af; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-completed { background: #d1fae5; color: #065f46; }
        
        @media (max-width: 768px) {
            .recent-section { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-dollar-sign"></i>Fee Management Dashboard</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card invoiced">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>Total Invoiced</h3>
                <div class="amount">${{ number_format($stats['total_invoiced'], 2) }}</div>
            </div>
            <div class="stat-card collected">
                <i class="fas fa-hand-holding-usd"></i>
                <h3>Total Collected</h3>
                <div class="amount">${{ number_format($stats['total_collected'], 2) }}</div>
            </div>
            <div class="stat-card pending">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Pending Amount</h3>
                <div class="amount">${{ number_format($stats['pending_amount'], 2) }}</div>
            </div>
            <div class="stat-card students">
                <i class="fas fa-users"></i>
                <h3>Total Students</h3>
                <div class="amount">{{ $stats['total_students'] }}</div>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="{{ route('admin.fee.invoices.create') }}" class="action-btn">
                    <i class="fas fa-plus-circle"></i> Create New Invoice
                </a>
                <a href="{{ route('admin.fee.invoices') }}" class="action-btn">
                    <i class="fas fa-file-invoice"></i> View All Invoices
                </a>
                <a href="{{ route('admin.fee.payments') }}" class="action-btn">
                    <i class="fas fa-money-check-alt"></i> View Payments
                </a>
                <a href="{{ route('admin.fee.structures') }}" class="action-btn">
                    <i class="fas fa-cog"></i> Fee Structures
                </a>
            </div>
        </div>

        <div class="recent-section">
            <div class="recent-card">
                <h2>Recent Invoices</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->student->name }}</td>
                            <td>${{ number_format($invoice->total_amount, 2) }}</td>
                            <td><span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #718096;">
                                No invoices found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="recent-card">
                <h2>Recent Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->payment_reference }}</td>
                            <td>{{ $payment->student->name }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #718096;">
                                No payments found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>