@extends('admin.layouts.main')

@section('content')
<div class="container-fluid" style="min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow"> <!-- Removed width adjustment -->
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Debts</h4>
                    <button id="logDebtBtn" class="btn btn-success">Log Debt</button>
                </div>
                <div class="card-body">
                    @if($debts->isEmpty())
                    <div class="alert alert-dark" role="alert">
                        <strong>No Debts logged yet.</strong>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Payback Deadline</th>
                                    <th scope="col">Days Remaining</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($debts as $debt)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $debt->name }}</td>
                                    <td>£{{ number_format($debt->amount, 2) }}</td>
                                    <td>{{ $debt->date }}</td>
                                    <td>{{ $debt->payback_deadline }}</td>
                                    <td>
                                        <strong>
                                            {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($debt->payback_deadline), false) }} days
                                        </strong>
                                    </td>
                                    <td>{{ $debt->notes }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success paymentBtn" data-debt-id="{{ $debt->id }}" style="margin-right: 5px;">Payment</button>
                                        <form action="{{ route('debts.destroy', $debt->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <details>
                                            <summary>View Payments</summary>
                                            <ul>
                                                @forelse ($debt->payments as $payment)
                                                <li>£{{ number_format($payment->amount, 2) }} on {{ $payment->created_at->format('Y-m-d') }}</li>
                                                @empty
                                                <li>No payments recorded.</li>
                                                @endforelse
                                            </ul>
                                        </details>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            <div id="logDebtCard" class="card mt-3" style="display:none; max-width: 600px; margin: 0 auto;"> <!-- Adjusted width -->
                <div class="card-header bg-primary text-white">Log a New Debt</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('debts.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required min="0">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="payback_deadline" class="form-label">Payback Deadline</label>
                            <input type="date" class="form-control" id="payback_deadline" name="payback_deadline" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Save Debt</button>
                        <button type="button" class="btn btn-secondary" id="cancelLogDebtBtn">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Log Payment Card -->
    <div id="logPaymentCard" class="card" style="display:none; max-width: 600px; margin: 0 auto;"> <!-- Adjusted width -->
        <div class="card-header bg-primary text-white">Log Payment</div>
        <div class="card-body">
            <form id="logPaymentForm" method="POST" action="{{ route('debts.pay') }}">
                @csrf
                <input type="hidden" id="debtIdForPayment" name="debt_id">
                <div class="mb-2">
                    <label for="paymentAmount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentAmount" name="payment_amount" required min="0">
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-sm btn-success">Save Payment</button>
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelLogPaymentBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('logDebtBtn').addEventListener('click', function() {
        document.getElementById('logDebtCard').style.display = 'block';
        document.getElementById('logPaymentCard').style.display = 'none'; // Hide the payment card when showing the debt card
    });

    document.getElementById('logDebtBtn').addEventListener('click', function() {
        document.getElementById('logDebtCard').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
    
    document.getElementById('cancelLogDebtBtn').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    document.getElementById('cancelLogDebtBtn').addEventListener('click', function() {
        document.getElementById('logDebtCard').style.display = 'none';
    });

    document.getElementById('cancelLogPaymentBtn').addEventListener('click', function() {
        document.getElementById('logPaymentCard').style.display = 'none';
    });

    document.querySelectorAll('.paymentBtn').forEach(button => {
        button.addEventListener('click', function() {
            const debtId = this.getAttribute('data-debt-id');
            document.getElementById('debtIdForPayment').value = debtId;
            document.getElementById('logPaymentCard').style.display = 'block';
            document.getElementById('logDebtCard').style.display = 'none'; // Hide the log debt card when showing the payment card
        });
    });
</script>
@endsection
