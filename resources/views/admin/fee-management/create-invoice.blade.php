<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Invoice - Fee Management</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Alert Messages */
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
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 16px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
       
        .form-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
       
        .form-group {
            margin-bottom: 25px;
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
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
       
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
       
        .items-section {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .items-section h3 {
            margin-bottom: 20px;
            color: #2d3748;
        }
       
        .item-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1fr 1fr 50px;
            gap: 15px;
            align-items: end;
            margin-bottom: 15px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
        }
       
        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .remove-btn:hover {
            background: #c0392b;
        }
       
        .add-item-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .add-item-btn:hover {
            background: #2980b9;
        }
       
        .total-section {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: right;
            border: 1px solid #e2e8f0;
        }
        .total-section h3 {
            color: #2d3748;
            font-size: 24px;
        }
       
        .submit-section {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .item-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-invoice-dollar"></i> Create New Invoice</h1>
            <a href="{{ route('admin.fee.invoices') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
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

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 10px 0 0 20px; list-style-position: inside;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(!$students || $students->count() == 0)
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Warning:</strong> No students found in the database. Please add students before creating invoices.
        </div>
        @endif

        <div class="form-card">
            <form action="{{ route('admin.fee.invoices.store') }}" method="POST" id="invoiceForm">
                @csrf
               
                <div class="form-row">
                    <div class="form-group">
                       <label for="student_id">Select Student *</label>
                        <select name="student_id" id="student_id" required>
                            <option value="">-- Choose a student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>
                                    {{ $student->full_name }} ({{ $student->admission_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <label for="invoice_date">Invoice Date *</label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                    </div>
                </div>
               
                <div class="form-row">
                    <div class="form-group">
                        <label for="due_date">Due Date *</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}" placeholder="e.g., Monthly fees for January 2024">
                    </div>
                </div>

                <div class="items-section">
                    <h3><i class="fas fa-list"></i> Invoice Items</h3>
                    <div id="itemsContainer">
                        <div class="item-row" data-row="0">
                            <div>
                                <label style="font-size: 12px; font-weight: bold;">Fee Type</label>
                                <select name="items[0][fee_structure_id]" class="fee-select">
                                    <option value="">Select predefined fee</option>
                                    @foreach($feeStructures as $fee)
                                    <option value="{{ $fee->fee_structure_id }}" data-amount="{{ $fee->amount }}" data-name="{{ $fee->fee_name }}">
                                        {{ $fee->fee_name }} (${{ number_format($fee->amount, 2) }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: bold;">Item Name *</label>
                                <input type="text" name="items[0][name]" class="item-name" placeholder="Enter item name" required>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: bold;">Amount *</label>
                                <input type="number" name="items[0][amount]" class="item-amount" step="0.01" min="0" placeholder="0.00" required>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: bold;">Quantity</label>
                                <input type="number" name="items[0][quantity]" class="item-quantity" min="1" value="1">
                            </div>
                            <button type="button" class="remove-btn" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                   
                    <button type="button" class="add-item-btn" id="addItem">
                        <i class="fas fa-plus"></i> Add Another Item
                    </button>
                </div>

                <div class="total-section">
                    <h3>Total Amount: $<span id="grandTotal">0.00</span></h3>
                </div>

                <div class="submit-section">
                    <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 18px;">
                        <i class="fas fa-save"></i> Generate Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let rowCount = 1;

        // Function to add new rows
        document.getElementById('addItem').addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            const newRow = `
                <div class="item-row" data-row="${rowCount}">
                    <div>
                        <select name="items[${rowCount}][fee_structure_id]" class="fee-select">
                            <option value="">Select predefined fee</option>
                            @foreach($feeStructures as $fee)
                            <option value="{{ $fee->fee_structure_id }}" data-amount="{{ $fee->amount }}" data-name="{{ $fee->fee_name }}">
                                {{ $fee->fee_name }} (${{ number_format($fee->amount, 2) }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div><input type="text" name="items[${rowCount}][name]" class="item-name" placeholder="Enter item name" required></div>
                    <div><input type="number" name="items[${rowCount}][amount]" class="item-amount" step="0.01" min="0" placeholder="0.00" required></div>
                    <div><input type="number" name="items[${rowCount}][quantity]" class="item-quantity" min="1" value="1"></div>
                    <button type="button" class="remove-btn" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                </div>`;
            container.insertAdjacentHTML('beforeend', newRow);
            rowCount++;
            updateTotals();
        });

        // Function to remove rows and update total
        function removeRow(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                btn.closest('.item-row').remove();
                updateTotals();
            } else {
                alert("At least one item is required.");
            }
        }

        // Auto-fill amount and name when selecting a Fee Type
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('fee-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const row = e.target.closest('.item-row');
                const amountInput = row.querySelector('.item-amount');
                const nameInput = row.querySelector('.item-name');
               
                if (selectedOption.value !== "") {
                    amountInput.value = selectedOption.dataset.amount;
                    nameInput.value = selectedOption.dataset.name;
                }
                updateTotals();
            }
        });

        // Update total when amounts or quantities change
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('item-amount') || e.target.classList.contains('item-quantity')) {
                updateTotals();
            }
        });

        function updateTotals() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const amount = parseFloat(row.querySelector('.item-amount').value) || 0;
                const quantity = parseInt(row.querySelector('.item-quantity').value) || 1;
                total += amount * quantity;
            });
            document.getElementById('grandTotal').innerText = total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        // Initial calculation
        updateTotals();

        // Form validation before submit
        document.getElementById('invoiceForm').addEventListener('submit', function(e) {
            const studentId = document.getElementById('student_id').value;
            if (!studentId) {
                e.preventDefault();
                alert('Please select a student');
                return false;
            }

            const items = document.querySelectorAll('.item-row');
            let hasValidItem = false;
            
            items.forEach(row => {
                const name = row.querySelector('.item-name').value.trim();
                const amount = parseFloat(row.querySelector('.item-amount').value);
                if (name && amount > 0) {
                    hasValidItem = true;
                }
            });

            if (!hasValidItem) {
                e.preventDefault();
                alert('Please add at least one valid item with name and amount');
                return false;
            }

            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Invoice...';
        });
    </script>
</body>
</html>