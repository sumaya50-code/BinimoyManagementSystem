<?php

namespace App\Http\Controllers;

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
        $members = Member::all();
        return view('admin.members.index', compact('members'));
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

    // Toggle Active/Inactive status
    public function toggleStatus(Member $member)
    {
        $member->status = $member->status === 'Active' ? 'Inactive' : 'Active';
        $member->save();
        return redirect()->route('members.index')->with('success', 'Member status updated.');
    }
}
