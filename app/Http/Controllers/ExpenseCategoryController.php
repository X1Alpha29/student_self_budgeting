<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;


class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::all();
        return view('expense-categories.index', compact('expenseCategories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::all();

        // Check if a new category was created
        $newCategoryCreated = request()->has('newCategoryCreated');

        return view('expense-create', compact('categories', 'newCategoryCreated'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories',
        ]);
    
        ExpenseCategory::create([
            'name' => $request->name,
        ]);
    
        return redirect()->back()->with('success', 'Expense category created successfully.');
    }
}
