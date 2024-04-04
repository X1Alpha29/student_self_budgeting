<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch debts associated with the authenticated user
        $debts = $user->debts()->get();

        return view('admin.debts.index', compact('debts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payback_deadline' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Associate the debt with the authenticated user
        $user = Auth::user();
        $debt = new Debt($request->all());
        $user->debts()->save($debt);

        return redirect()->route('debts.index')->with('success', 'Debt logged successfully.');
    }

    public function destroy(Debt $debt)
    {
        
        // Check if the debt belongs to the authenticated user
        if ($debt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $debt->delete();
        return back()->with('success', 'Debt removed successfully.');
    }

    public function payDebt(Request $request)
    {
        $debt = Debt::findOrFail($request->debt_id);

        // Check if the debt belongs to the authenticated user
        if ($debt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Assuming you have a method to handle the payment logic
        // Update the debt with the payment
        $debt->amount -= $request->payment_amount; // Adjust this logic as per your needs
        $debt->save();

        return back()->with('success', 'Payment logged successfully.');
    }
}

