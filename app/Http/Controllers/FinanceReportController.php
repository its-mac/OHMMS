<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function defaulters(Request $request)
    {
        $query = Invoice::with('student')
            ->whereIn('status', ['unpaid', 'partial']);

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        $totalOutstanding = (clone $query)
            ->get()
            ->sum(fn($invoice) => $invoice->total_amount - $invoice->paid_amount);

        return view('finance-reports.defaulters', compact('invoices', 'totalOutstanding'));
    }

    public function collections(Request $request)
    {
        $query = Invoice::with('student');

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        $totalGenerated = (clone $query)->sum('total_amount');
        $totalCollected = (clone $query)->sum('paid_amount');
        $totalOutstanding = $totalGenerated - $totalCollected;

        return view('finance-reports.collections', compact(
            'invoices',
            'totalGenerated',
            'totalCollected',
            'totalOutstanding'
        ));
    }
}
