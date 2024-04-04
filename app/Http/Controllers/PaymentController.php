<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Debt;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'debt_id' => 'required|exists:debts,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        Payment::create($request->all());

        return back()->with('success', 'Payment logged successfully.');
    }
}
