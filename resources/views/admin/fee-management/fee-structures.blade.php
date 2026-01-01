<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Structures - Fee Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { max-width: 1200px; margin: 0 auto; }
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
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
        
        .badge {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cog"></i> Fee Structures</h1>
            <div>
                <button onclick="openModal()" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Fee Structure
                </button>
                <a href="{{ route('admin.fee.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>Fee Name</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Frequency</th>
                        <th>Applicable To</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feeStructures as $fee)
                    <tr>
                        <td><strong>{{ $fee->fee_name }}</strong></td>
                        <td>${{ number_format($fee->amount, 2) }}</td>
                        <td>{{ ucfirst($fee->fee_type) }}</td>
                        <td>{{ ucfirst($fee->frequency) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $fee->applicable_to)) }}</td>
                        <td>
                            <span class="badge badge-{{ $fee->is_active ? 'active' : 'inactive' }}">
                                {{ $fee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #718096;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                            No fee structures found. Click "Add Fee Structure" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Fee Structure -->
    <div id="feeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Fee Structure</h2>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            <form action="{{ route('admin.fee.structures.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="fee_name">Fee Name *</label>
                        <input type="text" name="fee_name" id="fee_name" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount *</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fee_type">Fee Type *</label>
                        <input type="text" name="fee_type" id="fee_type" placeholder="e.g., Tuition, Library" required>
                    </div>
                    <div class="form-group">
                        <label for="frequency">Frequency *</label>
                        <select name="frequency" id="frequency" required>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="yearly">Yearly</option>
                            <option value="one-time">One-Time</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="applicable_to">Applicable To</label>
                    <select name="applicable_to" id="applicable_to">
                        <option value="all">All Students</option>
                        <option value="class_specific">Class Specific</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked> Active
                    </label>
                </div>
                
                <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 10px;">
                    <i class="fas fa-check"></i> Create Fee Structure
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('feeModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('feeModal').classList.remove('active');
        }
        
        // Close modal when clicking outside
        document.getElementById('feeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>