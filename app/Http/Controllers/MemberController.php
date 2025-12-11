<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables; // Yajra DataTables for AJAX tables

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:member-list|member-create|member-edit|member-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:member-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:member-edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.members.index');
    }

    /**
     *  NEW METHOD for DataTable Ajax
     */
    public function getData()
    {
        $members = Member::query();

        return datatables()->of($members)
            ->addIndexColumn()

            // Status Badge
            ->addColumn('status', function ($row) {
                $color = $row->status === 'Active'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700';

                return '<span class="px-3 py-1 rounded text-xs font-medium ' . $color . '">' . $row->status . '</span>';
            })

            // Action Buttons
            ->addColumn('actions', function ($row) {
                $btn = '<div class="flex justify-center space-x-2">';

                // View
                if (auth()->user()->can('member-view')) {
                    $btn .= '<a href="' . route('members.show', $row->id) . '" class="text-blue-600">
                                <iconify-icon icon="heroicons:eye" width="22"></iconify-icon>
                            </a>';
                }

                // Edit
                if (auth()->user()->can('member-edit')) {
                    $btn .= '<a href="' . route('members.edit', $row->id) . '" class="text-yellow-600">
                                <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                            </a>';
                }

                // Delete
                if (auth()->user()->can('member-delete')) {
                    $btn .= '<form action="' . route('members.destroy', $row->id) . '" method="POST"
                                onsubmit="return confirm(\'Are you sure?\')" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="text-red-600">
                                    <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
                                </button>
                            </form>';
                }

                $btn .= '</div>';

                return $btn;
            })

            ->rawColumns(['status', 'actions'])
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
            'address' => 'required|string',
            'nid' => 'required|unique:members',
            'phone' => 'required',
        ]);

        Member::create($request->all());
        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
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
            'address' => 'required|string',
            'nid' => 'required|unique:members,nid,' . $member->id,
            'phone' => 'required',
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
}
