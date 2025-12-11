<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Saving;
use App\Models\User;

class SavingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:saving-list|saving-create|saving-edit|saving-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:saving-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:saving-edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:saving-delete', ['only' => ['destroy']]);
    }

    // List all transactions page
    public function index()
    {
        return view('admin.savings.index');
    }

    // AJAX DataTables for transactions
    public function getSavingsData(Request $request)
    {
        $transactions = Saving::with('member')->latest();

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('member', fn($row) => $row->member->name)
            ->addColumn('type', fn($row) => ucfirst($row->type))
            ->addColumn('amount', fn($row) => $row->amount)
            ->addColumn('balance', fn($row) => $row->balance)
            ->addColumn('status', fn($row) => ucfirst($row->status))
            ->addColumn('interest', fn($row) => '<a href="'.route('savings.interest', $row->member_id).'" class="btn btn-info btn-sm text-white px-3 py-1 rounded">View</a>')
            ->addColumn('actions', function($row) {
                $edit = '<a href="'.route('savings.edit', $row->id).'" class="text-yellow-600 mr-2">
                            <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                         </a>';

                $approve = ($row->type == 'withdraw' && $row->status == 'pending')
                            ? '<a href="'.route('savings.approve', $row->id).'" class="text-green-600 mr-2">
                                <iconify-icon icon="heroicons:check" width="22"></iconify-icon>
                               </a>'
                            : '';

                $delete = '<form action="'.route('savings.destroy', $row->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="text-red-600">
                                    <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
                                </button>
                           </form>';

                return $edit.$approve.$delete;
            })
            ->rawColumns(['interest', 'actions'])
            ->make(true);
    }

    // Show create form
    public function create()
    {
        $members = User::all();
        return view('admin.savings.create', compact('members'));
    }

    // Store deposit or withdraw transaction
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'type'      => 'required',
            'amount'    => 'required|numeric|min:1',
        ]);

        $last = Saving::where('member_id', $request->member_id)->latest()->first();
        $prevBalance = $last->balance ?? 0;

        if ($request->type == 'deposit') {
            $newBalance = $prevBalance + $request->amount;
            $status = 'approved';
        } else {
            $newBalance = $prevBalance - $request->amount;
            $status = 'pending';
        }

        Saving::create([
            'member_id' => $request->member_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'balance' => $newBalance,
            'status' => $status,
            'interest_rate' => 5,
        ]);

        return redirect()->route('savings.index')->with('success', 'Transaction saved successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $transaction = Saving::findOrFail($id);
        $members = User::all();
        return view('admin.savings.edit', compact('transaction', 'members'));
    }

    // Update transaction
    public function update(Request $request, $id)
    {
        $request->validate([
            'type'   => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $transaction = Saving::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('savings.index')->with('success', 'Updated successfully');
    }

    // Delete transaction
    public function destroy($id)
    {
        Saving::destroy($id);
        return redirect()->route('savings.index')->with('success', 'Deleted successfully');
    }

    // Approve withdraw
    public function approve($id)
    {
        $transaction = Saving::findOrFail($id);

        if ($transaction->type == 'withdraw') {
            $last = Saving::where('member_id', $transaction->member_id)
                          ->where('id', '<', $transaction->id)
                          ->latest()->first();

            $prevBalance = $last->balance ?? 0;

            $transaction->update([
                'balance' => $prevBalance - $transaction->amount,
                'status' => 'approved',
            ]);
        }

        return back()->with('success', 'Withdraw request approved');
    }

    // Interest Calculation page
    public function calculateInterest($member_id)
    {
        $transactions = Saving::where('member_id', $member_id)->get();
        $lastBalance = $transactions->last()->balance ?? 0;
        $interest = ($lastBalance * 5) / 100;

        return view('admin.savings.interest', compact('transactions', 'interest', 'lastBalance'));
    }

    // AJAX Data for interest calculation
    public function getInterestData(Request $request, $member_id)
    {
        $transactions = Saving::where('member_id', $member_id)->latest();

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->editColumn('type', fn($row) => ucfirst($row->type))
            ->editColumn('status', fn($row) => ucfirst($row->status))
            ->make(true);
    }
}
