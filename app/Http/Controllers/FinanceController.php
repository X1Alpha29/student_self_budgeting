<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $finances = Finance::where('user_id', $userId)->get();
        return view('admin.finances.index', compact('finances'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.finances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $request->validate([
            // validation rules
        ]);

        $finance = new Finance($request->all());
        $finance->user_id = auth()->id(); // Set the user_id to the currently authenticated user
        $finance->save();

        return redirect()->route('finances.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        return view('admin.finances.edit', compact('finance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'expected_date' => 'required|date',
            'amount' => 'required|numeric',
            'loan_type' => 'required|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $finance->update($request->all());

        return redirect()->route('finances.index')
            ->with('success', 'Finance information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        $finance->delete();

        return redirect()->route('finances.index')
            ->with('success', 'Finance information deleted successfully.');
    }
}

