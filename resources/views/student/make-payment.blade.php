@extends('student.app')
@section('content')

<div class="payment-container">
    <div class="page-header">
        <h2><i class="bi bi-credit-card"></i> Make Payment</h2>
        <a href="{{ route('student.invoice.view', $invoice->invoice_id) }}" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i> Back to Invoice
        </a>
    </div>

    <div class="payment-content">
        <div class="invoice-summary-card">
            <h3>Payment Summary</h3>
            <div class="summary-details">
                <div class="detail-item">
                    <span>Invoice Number:</span>
                    <strong>{{ $invoice->invoice_number }}</strong>
                </div>
                <div class="detail-item">
                    <span>Invoice Date:</span>
                    <strong>{{ $invoice->invoice_date->format('M d, Y') }}</strong>
                </div>
                <div class="detail-item">
                    <span>Due Date:</span>
                    <strong>{{ $invoice->due_date->format('M d, Y') }}</strong>
                </div>
                <div class="detail-item">
                    <span>Total Amount:</span>
                    <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
                </div>
                <div class="detail-item">
                    <span>Already Paid:</span>
                    <strong class="text-success">${{ number_format($invoice->paid_amount, 2) }}</strong>
                </div>
                <div class="detail-item total">
                    <span>Amount to Pay:</span>
                    <strong class="text-primary">${{ number_format($invoice->balance, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="payment-form-card">
            <h3>Payment Information</h3>
            <div class="info-message">
                <i class="bi bi-info-circle"></i>
                <p>This is a demo payment form. In a production environment, this would integrate with a real payment gateway like Stripe, PayPal, or your bank's payment system.</p>
            </div>

            <form id="paymentForm">
                @csrf
                <div class="form-section">
                    <h4>Select Payment Method</h4>
                    <div class="payment-methods">
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="credit_card" checked>
                            <div class="method-card">
                                <i class="bi bi-credit-card"></i>
                                <span>Credit Card</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="debit_card">
                            <div class="method-card">
                                <i class="bi bi-wallet2"></i>
                                <span>Debit Card</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="bank_transfer">
                            <div class="method-card">
                                <i class="bi bi-bank"></i>
                                <span>Bank Transfer</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="online">
                            <div class="method-card">
                                <i class="bi bi-phone"></i>
                                <span>Online Payment</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-section card-details-section">
                    <h4>Card Details</h4>
                    <div class="form-group">
                        <label for="card_number">Card Number *</label>
                        <input type="text" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Expiry Date *</label>
                            <input type="text" id="expiry" placeholder="MM/YY" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV *</label>
                            <input type="text" id="cvv" placeholder="123" maxlength="4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_holder">Cardholder Name *</label>
                        <input type="text" id="card_holder" placeholder="John Doe" value="{{ Auth::user()->name }}">
                    </div>
                </div>

                <div class="form-section">
                    <h4>Amount to Pay</h4>
                    <div class="amount-input-wrapper">
                        <span class="currency-symbol">$</span>
                        <input type="number" id="payment_amount" step="0.01" max="{{ $invoice->balance }}" value="{{ $invoice->balance }}" readonly>
                    </div>
                    <p class="help-text">You can pay the full amount or a partial amount</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="window.history.back()">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success btn-large">
                        <i class="bi bi-lock"></i> Pay ${{ number_format($invoice->balance, 2) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .payment-container {
        max-width: 1000px;
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
        color: #28a745;
        margin-right: 10px;
    }

    .payment-content {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 25px;
    }

    .invoice-summary-card,
    .payment-form-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .invoice-summary-card {
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .invoice-summary-card h3,
    .payment-form-card h3 {
        color: #2d3748;
        font-size: 20px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .summary-details {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-item span {
        color: #718096;
    }

    .detail-item.total {
        border-top: 2px solid #2d3748;
        border-bottom: none;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 18px;
        font-weight: bold;
    }

    .text-success { color: #28a745; }
    .text-primary { color: #0d6efd; }

    .info-message {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        gap: 10px;
        align-items: start;
    }

    .info-message i {
        color: #1976d2;
        font-size: 20px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .info-message p {
        margin: 0;
        color: #1565c0;
        font-size: 14px;
        line-height: 1.5;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h4 {
        color: #2d3748;
        font-size: 16px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .payment-method-option {
        cursor: pointer;
    }

    .payment-method-option input[type="radio"] {
        display: none;
    }

    .method-card {
        border: 2px solid #e2e8f0;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s;
        background: white;
    }

    .method-card i {
        font-size: 32px;
        color: #718096;
        margin-bottom: 10px;
        display: block;
    }

    .method-card span {
        color: #4a5568;
        font-weight: 600;
        font-size: 14px;
    }

    .payment-method-option input[type="radio"]:checked + .method-card {
        border-color: #0d6efd;
        background: #e3f2fd;
    }

    .payment-method-option input[type="radio"]:checked + .method-card i {
        color: #0d6efd;
    }

    .payment-method-option:hover .method-card {
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .amount-input-wrapper {
        position: relative;
    }

    .currency-symbol {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #718096;
        font-weight: bold;
        font-size: 16px;
    }

    .amount-input-wrapper input {
        padding-left: 35px;
        font-size: 18px;
        font-weight: bold;
        color: #2d3748;
    }

    .help-text {
        margin-top: 8px;
        font-size: 13px;
        color: #718096;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-outline {
        background: white;
        color: #4a5568;
        border: 1px solid #cbd5e0;
    }

    .btn-large {
        padding: 15px 40px;
        font-size: 16px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    @media (max-width: 992px) {
        .payment-content {
            grid-template-columns: 1fr;
        }

        .invoice-summary-card {
            position: static;
        }
    }

    @media (max-width: 576px) {
        .payment-methods {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        
        // Simulate payment processing
        setTimeout(function() {
            alert('This is a demo payment form. In production, this would integrate with a real payment gateway.\n\nPayment would be processed here and the invoice would be updated.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            // Redirect back to invoice
            window.location.href = '{{ route("student.invoice.view", $invoice->invoice_id) }}';
        }, 2000);
    });

    // Format card number with spaces
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date
    document.getElementById('expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    // Only allow numbers in CVV
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>
@endpush