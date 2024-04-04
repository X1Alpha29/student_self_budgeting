@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg" style="max-width: 600px; margin: 0 auto;"> <!-- Adjusted width -->
        <div class="card-header bg-dark text-white">
            <h5>Log Your Expense</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/expenses">
                @csrf
                <div class="mb-3">
                    <label for="expenseName" class="form-label">Expense Name</label>
                    <input type="text" class="form-control" id="expenseName" name="expense_name" required>
                </div>
                <div class="mb-3">
                    <label for="categoryInput" class="form-label">Category</label>
                    <select class="form-select" id="categoryInput" name="category">
                        <option value="" selected disabled>Choose a category</option>
                        <option value="Bills">Bills</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Food">Food</option>
                        <option value="Alcohol">Alcohol</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Holiday">Holiday</option>
                        <option value="Family">Family</option>
                        @if(session('newCategory'))
                            <?php $newCategory = session('newCategory'); ?>
                            <option value="{{ $newCategory->id }}">{{ $newCategory->name }}</option>
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" placeholder="£" id="amount" name="amount" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ request()->fullUrlWithQuery(['showNewExpenseForm' => '1']) }}#newExpenseForm" class="btn btn-secondary">Add New Category</a>
                </div>
            </div>

            @if(request('showNewExpenseForm'))
                <div class="row mt-3" id="newExpenseForm">
                    <div class="col-12">
                        <h5>New Category</h5>
                        <form method="POST" action="{{ route('expense-categories.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="newCategoryName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="newCategoryName" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                            <a href="{{ url()->current() }}" class="btn btn-danger ml-2">Cancel</a>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection






<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(window.location.href.indexOf("#newExpenseForm") > -1) {
            document.getElementById("newExpenseForm").scrollIntoView();
        }
    });
</script>

