<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanCollection;

class LoanCollectionController extends Controller
{
    public function index()
    {
        $collections = LoanCollection::with('installment.loan','collector')->get();
        return view('admin.loan_collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.loan_collections.create');
    }

    public function show(LoanCollection $loanCollection)
    {
        return view('admin.loan_collections.show', compact('loanCollection'));
    }

    public function destroy(LoanCollection $loanCollection)
    {
        $loanCollection->delete();
        return redirect()->route('loan_collections.index')->with('success', 'Collection removed');
    }
}
