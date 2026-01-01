<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentPaymentController extends Controller
{
    public function payslip()
    {
        $student = Auth::guard('student')->user();  // CHANGED
        
        if (!$student) {
            Log::warning('Student not authenticated');
            return redirect()->route('student.login');
        }
        
        $invoices = Invoice::where('student_id', $student->student_id)
            ->with('items', 'payments')
            ->orderBy('invoice_date', 'desc')
            ->get();
        
        $stats = [
            'total_invoiced' => $invoices->sum('total_amount') ?? 0,
            'total_paid' => $invoices->sum('paid_amount') ?? 0,
            'total_balance' => $invoices->sum('balance') ?? 0,
            'pending_invoices' => $invoices->whereIn('status', ['pending', 'partial', 'overdue'])->count() ?? 0,
        ];
        
        Log::info('Payslip loaded', ['student_id' => $student->student_id, 'invoices' => $invoices->count()]);
        
        return view('student.payslip', compact('invoices', 'stats', 'student'));
    }
    
    public function viewInvoice($id)
    {
        $student = Auth::guard('student')->user();
        if (!$student) abort(401);
        
        $invoice = Invoice::with(['items', 'payments'])
            ->where('student_id', $student->student_id)
            ->where('invoice_id', $id)
            ->firstOrFail();
        
        return view('student.invoice-detail', compact('invoice', 'student'));
    }
    
    public function initiatePayment($invoiceId)
    {
        $student = Auth::guard('student')->user();
        if (!$student) abort(401);
        
        $invoice = Invoice::where('student_id', $student->student_id)
            ->where('invoice_id', $invoiceId)
            ->firstOrFail();
        
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Already paid!');
        }
        
        return view('student.make-payment', compact('invoice', 'student'));
    }
}