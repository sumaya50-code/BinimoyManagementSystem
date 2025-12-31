<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\LedgerEntry;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    // Profit & Loss (Income - Expense)
    public function profitLoss(Request $request)
    {
        $incomeAccounts = ChartOfAccount::where('type', 'income')->pluck('id');
        $expenseAccounts = ChartOfAccount::where('type', 'expense')->pluck('id');

        $income = LedgerEntry::whereIn('account_id', $incomeAccounts)->sum('credit') - LedgerEntry::whereIn('account_id', $incomeAccounts)->sum('debit');
        $expenses = LedgerEntry::whereIn('account_id', $expenseAccounts)->sum('debit') - LedgerEntry::whereIn('account_id', $expenseAccounts)->sum('credit');

        $profit = $income - $expenses;

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('admin.reports.profit_loss_pdf', compact('income', 'expenses', 'profit'));
            return $pdf->download('profit_loss.pdf');
        }

        if ($request->get('export') == 'csv') {
            $csv = "Type,Amount\nIncome," . number_format($income, 2) . "\nExpenses," . number_format($expenses, 2) . "\nProfit," . number_format($profit, 2) . "\n";
            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="profit_loss.csv"',
            ]);
        }

        return view('admin.reports.profit_loss', compact('income', 'expenses', 'profit'));
    }

    // Balance Sheet
    public function balanceSheet(Request $request)
    {
        $assets = ChartOfAccount::where('type', 'asset')->get()->map(function ($a) {
            $amt = LedgerEntry::where('account_id', $a->id)->sum('debit') - LedgerEntry::where('account_id', $a->id)->sum('credit');
            return ['account' => $a, 'amount' => $amt];
        });

        $liabilities = ChartOfAccount::where('type', 'liability')->get()->map(function ($a) {
            $amt = LedgerEntry::where('account_id', $a->id)->sum('credit') - LedgerEntry::where('account_id', $a->id)->sum('debit');
            return ['account' => $a, 'amount' => $amt];
        });

        $equity = ChartOfAccount::where('type', 'equity')->get()->map(function ($a) {
            $amt = LedgerEntry::where('account_id', $a->id)->sum('credit') - LedgerEntry::where('account_id', $a->id)->sum('debit');
            return ['account' => $a, 'amount' => $amt];
        });

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('admin.reports.balance_sheet_pdf', compact('assets', 'liabilities', 'equity'));
            return $pdf->download('balance_sheet.pdf');
        }

        if ($request->get('export') == 'csv') {
            $rows = "Account,Type,Amount\n";
            foreach ($assets as $r) $rows .= $r['account']->name . ",Asset," . number_format($r['amount'], 2) . "\n";
            foreach ($liabilities as $r) $rows .= $r['account']->name . ",Liability," . number_format($r['amount'], 2) . "\n";
            foreach ($equity as $r) $rows .= $r['account']->name . ",Equity," . number_format($r['amount'], 2) . "\n";
            return response($rows, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="balance_sheet.csv"']);
        }

        return view('admin.reports.balance_sheet', compact('assets', 'liabilities', 'equity'));
    }

    // Cash Flow (simple cash movements)
    public function cashFlow(Request $request)
    {
        // assume account code 1000 is cash
        $cashAccount = ChartOfAccount::where('code', '1000')->first();
        $entries = [];
        if ($cashAccount) {
            $entries = LedgerEntry::where('account_id', $cashAccount->id)->orderBy('created_at', 'desc')->get();
        }

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('admin.reports.cash_flow_pdf', compact('entries'));
            return $pdf->download('cash_flow.pdf');
        }

        if ($request->get('export') == 'csv') {
            $rows = "Date,Description,Debit,Credit\n";
            foreach ($entries as $e) {
                $rows .= $e->created_at->toDateString() . "," . ($e->description ?? '') . "," . number_format($e->debit, 2) . "," . number_format($e->credit, 2) . "\n";
            }
            return response($rows, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="cash_flow.csv"']);
        }

        return view('admin.reports.cash_flow', compact('entries'));
    }

    // Collection Reports
    public function collectionReport(Request $request)
    {
        $query = \App\Models\LoanCollection::with(['installment.loan.member', 'collector'])
            ->where('status', 'verified');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Filter by officer
        if ($request->has('officer_id') && $request->officer_id) {
            $query->where('collector_id', $request->officer_id);
        }

        $collections = $query->get();

        // Group by officer
        $officerWise = $collections->groupBy('collector.name')->map(function ($group) {
            return [
                'total_collections' => $group->count(),
                'total_amount' => $group->sum('amount'),
                'collections' => $group
            ];
        });

        // Group by date
        $dateWise = $collections->groupBy(function ($collection) {
            return $collection->transaction_date->format('Y-m-d');
        })->map(function ($group) {
            return [
                'total_collections' => $group->count(),
                'total_amount' => $group->sum('amount'),
                'collections' => $group
            ];
        });

        // Overdue collections (collections with penalties)
        $overdueCollections = $collections->filter(function ($collection) {
            return $collection->installment && $collection->installment->penalty_amount > 0;
        });

        $officers = \App\Models\User::where('role', 'field_officer')->get();

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('admin.reports.collection_report_pdf', compact('officerWise', 'dateWise', 'overdueCollections', 'collections'));
            return $pdf->download('collection_report.pdf');
        }

        if ($request->get('export') == 'csv') {
            $rows = "Date,Officer,Member,Amount,Penalty\n";
            foreach ($collections as $collection) {
                $rows .= $collection->transaction_date->format('Y-m-d') . ",";
                $rows .= ($collection->collector->name ?? 'N/A') . ",";
                $rows .= ($collection->installment->loan->member->name ?? 'N/A') . ",";
                $rows .= number_format($collection->amount, 2) . ",";
                $rows .= number_format($collection->installment->penalty_amount ?? 0, 2) . "\n";
            }
            return response($rows, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="collection_report.csv"']);
        }

        return view('admin.reports.collection_report', compact('officerWise', 'dateWise', 'overdueCollections', 'officers'));
    }
}
