<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:member-list|member-create|member-edit|member-delete', ['only' => ['index', 'store', 'summary']]);
        $this->middleware('permission:member-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:member-edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.members.index');
    }

    public function getData()
    {
        $members = Member::query();

        return datatables()->of($members)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $color = $row->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                return '<span class="px-3 py-1 rounded text-xs font-medium ' . $color . '">' . $row->status . '</span>';
            })
            ->addColumn('actions', function ($row) {
                $btn = '<div class="flex justify-center space-x-2">';

                $btn .= '<a href="' . route('members.show', $row->id) . '" class="text-blue-600">
                            <iconify-icon icon="heroicons:eye" width="22"></iconify-icon>
                        </a>';
                $btn .= '<a href="' . route('members.edit', $row->id) . '" class="text-yellow-600">
                            <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                        </a>';
                $btn .= '<a href="' . route('members.toggleStatus', $row->id) . '" class="text-indigo-600">
                            <iconify-icon icon="heroicons:switch-horizontal" width="22"></iconify-icon>
                        </a>';
                $btn .= '<form action="' . route('members.destroy', $row->id) . '" method="POST"
                            onsubmit="return confirm(\'Are you sure?\')" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="text-red-600">
                                <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
                            </button>
                        </form>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function summary()
    {
        return view('admin.members.summary');
    }

    public function summaryData()
    {
        $members = Member::withCount(['loanProposals', 'savingsAccounts', 'withdrawals'])->select(['id', 'name', 'member_no', 'nid', 'phone']);

        return datatables()->of($members)
            ->addIndexColumn()
            ->addColumn('loans', function ($row) {
                return $row->loan_proposals_count;
            })
            ->addColumn('savings', function ($row) {
                return $row->savings_accounts_count;
            })
            ->addColumn('withdrawals', function ($row) {
                return $row->withdrawals_count;
            })
            ->addColumn('actions', function ($row) {
                return '<a href="' . route('members.show', $row->id) . '" class="text-blue-600 hover:underline">View Profile</a>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'present_address' => 'required|string',
            'nid' => 'required|unique:members|min:10|max:17',
            'phone' => 'required|digits:11',
        ]);

        $latest = Member::latest()->first();
        $member_no = $latest ? 'M' . str_pad($latest->id + 1, 5, '0', STR_PAD_LEFT) : 'M00001';

        Member::create(array_merge($request->all(), ['member_no' => $member_no, 'status' => $request->status ?? 'Active']));

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
        $member->load(['loanProposals', 'savingsAccounts', 'savingsWithdrawalRequests']);
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string',
            'present_address' => 'required|string',
            'nid' => 'required|unique:members,nid,' . $member->id,
            'phone' => 'required|digits:11',
        ]);

        $member->update($request->all());
        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function toggleStatus(Member $member)
    {
        $member->status = $member->status === 'Active' ? 'Inactive' : 'Active';
        $member->save();

        return redirect()->route('members.index')->with('success', 'Member status updated.');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        $members = Member::where('name', 'LIKE', '%' . $query . '%')
            ->select('id', 'name')
            ->get();

        return response()->json($members->map(function ($member) {
            return [
                'id' => $member->id,
                'text' => $member->name
            ];
        }));
    }
}
