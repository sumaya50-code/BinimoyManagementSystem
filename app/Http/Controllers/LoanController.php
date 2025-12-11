<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:loan-list|loan-create|loan-edit|loan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:loan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loan-edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:loan-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('admin.loans.index');
    }

   public function getData()
{
    $loans = Loan::with('member')->latest();

    return DataTables::of($loans)
        ->addIndexColumn()
        ->addColumn('member_name', fn($row) => $row->member->name ?? 'N/A')
        ->addColumn('status', function ($row) {
            $colors = [
                'Pending'   => 'bg-yellow-500',
                'Approved'  => 'bg-blue-500',
                'Active'    => 'bg-green-600',
                'Completed' => 'bg-gray-600',
                'Overdue'   => 'bg-red-600'
            ];
            $color = $colors[$row->status] ?? 'bg-gray-500';
            return "<span class='px-2 py-1 rounded text-white $color'>{$row->status}</span>";
        })
        ->addColumn('loan_details', function ($row) {
            return '<a href="' . route('loans.show', $row->id) . '"
                        class="btn btn-info btn-sm px-2 py-1">Details</a>';
        })
        ->addColumn('action', function ($row) {
            return '
                <div class="flex gap-2 justify-center">
                    <a href="' . route('loans.edit', $row->id) . '"
                       class="text-blue-600 hover:underline">Edit</a>

                    <a href="javascript:void(0)"
                       data-url="' . route('loans.destroy', $row->id) . '"
                       class="text-red-600 delete-btn hover:underline">
                        Delete
                    </a>
                </div>
            ';
        })
        ->rawColumns(['status', 'action', 'loan_details'])
        ->make(true);
}


    public function create()
    {
        $members = Member::all();
        return view('admin.loans.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'installment_count' => 'required|numeric',
            'installment_type' => 'required',
            'status' => 'required'
        ]);

        Loan::create($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan created successfully');
    }

    public function show(Loan $loan)
    {
        return view('admin.loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $members = Member::all();
        return view('admin.loans.edit', compact('loan', 'members'));
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'member_id' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'installment_count' => 'required|numeric',
            'installment_type' => 'required',
            'status' => 'required'
        ]);

        $loan->update($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(['message' => 'Loan deleted successfully']);
    }
}
