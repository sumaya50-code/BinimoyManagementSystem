<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashAsset;

class CashAssetController extends Controller
{
    public function index()
    {
        $assets = CashAsset::all();
        return view('admin.cash_assets.index', compact('assets'));
    }

    public function create()
    {
        return view('admin.cash_assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required'
        ]);

        CashAsset::create($request->all());
        return redirect()->route('cash_assets.index')->with('success', 'Cash asset added');
    }

    public function edit(CashAsset $cashAsset)
    {
        return view('admin.cash_assets.edit', compact('cashAsset'));
    }

    public function update(Request $request, CashAsset $cashAsset)
    {
        $request->validate(['name' => 'required']);
        $cashAsset->update($request->all());
        return redirect()->route('cash_assets.index')->with('success', 'Cash asset updated');
    }

    public function destroy(CashAsset $cashAsset)
    {
        $cashAsset->delete();
        return redirect()->route('cash_assets.index')->with('success', 'Cash asset removed');
    }
}
