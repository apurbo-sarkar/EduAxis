<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\FeeStructure;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminFeeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_invoiced' => Invoice::sum('total_amount'),
            'total_collected' => Payment::where('status', 'completed')->sum('amount'),
            'pending_amount' => Invoice::whereIn('status', ['pending', 'partial', 'overdue'])->sum('balance'),
            'total_students' => Student::count(),
        ];

        $recentInvoices = Invoice::with('student')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentPayments = Payment::with(['student', 'invoice'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.fee-management.index', compact('stats', 'recentInvoices', 'recentPayments'));
    }

    public function invoices()
    {
        $invoices = Invoice::with('student')->orderBy('invoice_date', 'desc')->paginate(20);
        return view('admin.fee-management.invoices', compact('invoices'));
    }

    public function createInvoice()
    {
        $students = Student::orderBy('full_name')->get();
        $feeStructures = FeeStructure::where('is_active', true)->get();
        
        Log::info('Create Invoice Page Loaded', [
            'students_count' => $students->count(),
            'fee_structures_count' => $feeStructures->count()
        ]);
        
        return view('admin.fee-management.create-invoice', compact('students', 'feeStructures'));
    }
   
    public function storeInvoice(Request $request)
    {
        // Log incoming request for debugging
        Log::info('Invoice Creation Request', $request->all());

        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                $totalAmount += $item['amount'] * $quantity;
            }

            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create invoice
            $invoice = Invoice::create([
                'student_id' => $request->student_id,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'balance' => $totalAmount,
                'status' => 'pending',
                'description' => $request->description,
            ]);

            // Create invoice items
            foreach ($request->items as $item) {
                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                $itemTotal = $item['amount'] * $quantity;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->invoice_id,
                    'fee_structure_id' => $item['fee_structure_id'] ?? null,
                    'item_name' => $item['name'],
                    'amount' => $item['amount'],
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();
            
            Log::info('Invoice created successfully', ['invoice_id' => $invoice->invoice_id]);
            
            return redirect()->route('admin.fee.invoices')->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating invoice: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    public function viewInvoice($id)
    {
        $invoice = Invoice::with(['student', 'items', 'payments'])->findOrFail($id);
        return view('admin.fee-management.view-invoice', compact('invoice'));
    }

    public function payments()
    {
        $payments = Payment::with(['student', 'invoice'])->orderBy('payment_date', 'desc')->paginate(20);
        return view('admin.fee-management.payments', compact('payments'));
    }

    public function recordPayment(Request $request, $invoiceId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,debit_card,online',
            'remarks' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        if ($request->amount > $invoice->balance) {
            return back()->with('error', 'Payment amount cannot exceed balance amount!');
        }

        DB::beginTransaction();
        try {
            $paymentReference = 'PAY-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 5, '0', STR_PAD_LEFT);

            Payment::create([
                'invoice_id' => $invoice->invoice_id,
                'student_id' => $invoice->student_id,
                'payment_reference' => $paymentReference,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'remarks' => $request->remarks,
                'transaction_id' => $request->transaction_id,
            ]);

            $invoice->paid_amount += $request->amount;
            $invoice->updateStatus();

            DB::commit();
            return back()->with('success', 'Payment recorded successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }

    public function studentFeeDetails($studentId)
    {
        $student = Student::findOrFail($studentId);
        $invoices = Invoice::where('student_id', $studentId)
            ->with('items', 'payments')
            ->orderBy('invoice_date', 'desc')
            ->get();

        $totalInvoiced = $invoices->sum('total_amount');
        $totalPaid = $invoices->sum('paid_amount');
        $totalBalance = $invoices->sum('balance');

        return view('admin.fee-management.student-details', compact('student', 'invoices', 'totalInvoiced', 'totalPaid', 'totalBalance'));
    }

    public function feeStructures()
    {
        $feeStructures = FeeStructure::orderBy('fee_name')->paginate(20);
        return view('admin.fee-management.fee-structures', compact('feeStructures'));
    }

    public function storeFeeStructure(Request $request)
    {
        $request->validate([
            'fee_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string',
            'frequency' => 'required|in:monthly,quarterly,yearly,one-time',
        ]);

        FeeStructure::create($request->all());
        return back()->with('success', 'Fee structure created successfully!');
    }
}