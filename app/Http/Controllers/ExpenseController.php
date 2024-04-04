<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        // Retrieve expenses associated with the authenticated user
        $userId = Auth::id();
        $currentMonthExpenses = Expense::whereYear('date', '=', now()->year)
            ->whereMonth('date', '=', now()->month)
            ->where('user_id', $userId)
            ->get();

        $monthlyTotal = $currentMonthExpenses->sum('amount');

        $currentYearExpenses = Expense::whereYear('date', '=', now()->year)
            ->where('user_id', $userId)
            ->get();

        $yearlyTotal = $currentYearExpenses->sum('amount');

        $monthlyExpenses = Expense::selectRaw('DATE_FORMAT(date, "%Y-%m") AS month')
            ->selectRaw('SUM(amount) AS total_amount')
            ->whereYear('date', '=', now()->subYear()->year)
            ->where('user_id', $userId)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.expenses.index', compact('currentMonthExpenses', 'monthlyTotal', 'currentYearExpenses', 'yearlyTotal'))
            ->with('monthlyExpenses', $monthlyExpenses);
    }

    public function create()
{
    return view('admin.expenses.create');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'expense_name' => 'required|string',
        'category' => 'required|string',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    // Associate the expense with the authenticated user
    $user = Auth::user();
    $expense = new Expense($validatedData);
    $user->expenses()->save($expense);

    return redirect()->route('expenses.index')->with('success', 'Expense logged successfully.');
}

public function edit($id)
{
    $expense = Expense::findOrFail($id);

    // Check if the expense belongs to the authenticated user
    if ($expense->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('admin.expenses.update', compact('expense'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'expense_name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    $expense = Expense::findOrFail($id);

    // Check if the expense belongs to the authenticated user
    if ($expense->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $expense->update($validatedData);

    return redirect()->route('expenses.index')->with('message', 'Expense updated successfully!');
}

public function destroy($id)
{
    $expense = Expense::findOrFail($id);

    // Check if the expense belongs to the authenticated user
    if ($expense->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $expense->delete();

    return redirect()->back()->with('success', 'Expense deleted successfully.');
}
}
