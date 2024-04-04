@extends('admin.layouts.main')

@section('content')
<div id="expensesContainer" class="container-fluid" style="min-height: 100vh; flex-direction: column;">
    <!-- Card Widget for Expenses -->
    <div class="card-widget">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5>Expenses</h5>
                <a href="{{ route('expenses.create') }}" class="btn btn-success">Create New Expense</a>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($currentMonthExpenses as $index => $expense)
                    <div class="list-group-item clickable-row" data-index="{{ $index }}">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h6>{{ $expense->expense_name }}</h6>
                                <p>{{ $expense->category }}</p>
                                <div class="more-info-icon"><i class="bi bi-info-circle"></i></div>
                            </div>
                            <div class="col-sm-6 text-end">
                                <h6>£{{ $expense->amount }}</h6>
                                <p>{{ $expense->date }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Empty column to align buttons -->
                            </div>
                            <div class="col-sm-6 text-end">
                                <div class="btn-group expense-actions" role="group" aria-label="Expense Actions" style="display: none;">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-success">Update</a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="notes" style="display: none;">
                            <strong>Notes:</strong> {{ $expense->notes ?? '-' }}
                        </div>
                    </div>
                    <div class="divider"></div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <p>Monthly Total: £{{ $monthlyTotal }} <span class="divider">/</span> {{ $currentMonthExpenses->count() }} expenses</p>
                <p>Yearly Total: £{{ $yearlyTotal }} <span class="divider">/</span> {{ $currentYearExpenses->count() }} expenses</p>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const index = row.getAttribute('data-index');
                const notes = row.querySelector('.notes');
                const buttons = row.querySelector('.expense-actions');
                notes.style.display = notes.style.display === 'none' ? 'block' : 'none';
                buttons.style.display = notes.style.display === 'none' ? 'none' : 'block';
            });
        });
    });
</script>
@endsection
