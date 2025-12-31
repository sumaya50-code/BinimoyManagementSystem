<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanGuarantor;

class LoanGuarantorController extends Controller
{
    public function index()
    {
        $guarantors = LoanGuarantor::with('loanProposal')->get();
        return view('admin.loan_guarantors.index', compact('guarantors'));
    }

    public function create(Request $request)
    {
        $loanProposal = null;
        if ($request->has('loan_proposal_id')) {
            $loanProposal = \App\Models\LoanProposal::find($request->loan_proposal_id);
        }
        return view('admin.loan_guarantors.create', compact('loanProposal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_proposal_id' => 'required|exists:loan_proposals,id',
            'name' => 'required|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'profession' => 'nullable|string|max:255',
            'nid_number' => 'nullable|string|max:255',
            'liabilities' => 'nullable|string',
            'assets' => 'nullable|string',
            'declaration' => 'nullable|string',
            'investment_received' => 'nullable|string|max:255',
            'investment_amount_words' => 'nullable|string|max:255',
            'guarantor_signature' => 'nullable|string|max:255',
            'tip_sign' => 'nullable|in:left,right',
            'employee_signature' => 'nullable|string|max:255',
            'manager_signature' => 'nullable|string|max:255',
            'authorized_person_name' => 'nullable|string|max:255',
            'authorized_person_signature' => 'nullable|string|max:255',
            'present_village' => 'nullable|string|max:255',
            'present_thana' => 'nullable|string|max:255',
            'present_upazila' => 'nullable|string|max:255',
            'present_district' => 'nullable|string|max:255',
            'present_postcode' => 'nullable|string|max:10',
            'permanent_village' => 'nullable|string|max:255',
            'permanent_thana' => 'nullable|string|max:255',
            'permanent_upazila' => 'nullable|string|max:255',
            'permanent_district' => 'nullable|string|max:255',
            'permanent_postcode' => 'nullable|string|max:10',
        ]);

        // Build present and permanent addresses
        $presentAddress = trim(implode(', ', array_filter([
            $request->present_village,
            $request->present_thana,
            $request->present_upazila,
            $request->present_district,
            $request->present_postcode
        ])));

        $permanentAddress = trim(implode(', ', array_filter([
            $request->permanent_village,
            $request->permanent_thana,
            $request->permanent_upazila,
            $request->permanent_district,
            $request->permanent_postcode
        ])));

        $data = $request->except([
            'present_village',
            'present_thana',
            'present_upazila',
            'present_district',
            'present_postcode',
            'permanent_village',
            'permanent_thana',
            'permanent_upazila',
            'permanent_district',
            'permanent_postcode'
        ]);
        $data['present_address'] = $presentAddress;
        $data['permanent_address'] = $permanentAddress;

        LoanGuarantor::create($data);
        return redirect()->route('loan_proposals.show', $request->loan_proposal_id)->with('success', 'Guarantor added successfully');
    }

    public function show(LoanGuarantor $loanGuarantor)
    {
        return view('admin.loan_guarantors.show', compact('loanGuarantor'));
    }

    public function edit(LoanGuarantor $loanGuarantor)
    {
        return view('admin.loan_guarantors.edit', compact('loanGuarantor'));
    }

    public function update(Request $request, LoanGuarantor $loanGuarantor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'profession' => 'nullable|string|max:255',
            'nid_number' => 'nullable|string|max:255',
            'liabilities' => 'nullable|string',
            'assets' => 'nullable|string',
            'declaration' => 'nullable|string',
            'investment_received' => 'nullable|string|max:255',
            'investment_amount_words' => 'nullable|string|max:255',
            'guarantor_signature' => 'nullable|string|max:255',
            'tip_sign' => 'nullable|in:left,right',
            'employee_signature' => 'nullable|string|max:255',
            'manager_signature' => 'nullable|string|max:255',
            'authorized_person_name' => 'nullable|string|max:255',
            'authorized_person_signature' => 'nullable|string|max:255',
            'present_village' => 'nullable|string|max:255',
            'present_thana' => 'nullable|string|max:255',
            'present_upazila' => 'nullable|string|max:255',
            'present_district' => 'nullable|string|max:255',
            'present_postcode' => 'nullable|string|max:10',
            'permanent_village' => 'nullable|string|max:255',
            'permanent_thana' => 'nullable|string|max:255',
            'permanent_upazila' => 'nullable|string|max:255',
            'permanent_district' => 'nullable|string|max:255',
            'permanent_postcode' => 'nullable|string|max:10',
        ]);

        // Build present and permanent addresses
        $presentAddress = trim(implode(', ', array_filter([
            $request->present_village,
            $request->present_thana,
            $request->present_upazila,
            $request->present_district,
            $request->present_postcode
        ])));

        $permanentAddress = trim(implode(', ', array_filter([
            $request->permanent_village,
            $request->permanent_thana,
            $request->permanent_upazila,
            $request->permanent_district,
            $request->permanent_postcode
        ])));

        $data = $request->except([
            'present_village',
            'present_thana',
            'present_upazila',
            'present_district',
            'present_postcode',
            'permanent_village',
            'permanent_thana',
            'permanent_upazila',
            'permanent_district',
            'permanent_postcode'
        ]);
        $data['present_address'] = $presentAddress;
        $data['permanent_address'] = $permanentAddress;

        $loanGuarantor->update($data);
        return redirect()->route('loan_guarantors.index')->with('success', 'Guarantor updated');
    }

    public function destroy(LoanGuarantor $loanGuarantor)
    {
        $loanGuarantor->delete();
        return redirect()->route('loan_guarantors.index')->with('success', 'Guarantor deleted');
    }
}
