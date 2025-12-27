<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPaymentController extends Controller
{
    public function payslip()
    {
        $student = Auth::user();
        
        $invoices = Invoice::where('student_id', $student->id)
            ->with('items', 'payments')
            ->orderBy('invoice_date', 'desc')
            ->get();

        $stats = [
            'total_invoiced' => $invoices->sum('total_amount'),
            'total_paid' => $invoices->sum('paid_amount'),
            'total_balance' => $invoices->sum('balance'),
            'pending_invoices' => $invoices->whereIn('status', ['pending', 'partial', 'overdue'])->count(),
        ];

        return view('student.payslip', compact('invoices', 'stats'));
    }

    public function viewInvoice($id)
    {
        $invoice = Invoice::with(['items', 'payments'])
            ->where('student_id', Auth::id())
            ->findOrFail($id);

        return view('student.invoice-detail', compact('invoice'));
    }

    public function initiatePayment(Request $request, $invoiceId)
    {
        $invoice = Invoice::where('student_id', Auth::id())->findOrFail($invoiceId);

        if ($invoice->status === 'paid') {
            return back()->with('error', 'This invoice is already paid!');
        }

        // Here you would integrate with your payment gateway
        // For now, we'll just show a payment form
        return view('student.make-payment', compact('invoice'));
    }
}