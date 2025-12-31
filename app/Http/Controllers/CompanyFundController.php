<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyFund;

class CompanyFundController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:companyfund-view', ['only' => ['index']]);
    }

    public function index()
    {
        $fund = CompanyFund::first();
        return view('admin.company_fund.index', compact('fund'));
    }
}
