@extends('admin.layouts.main')

@section('content')
<div class="container-fluid" style="min-height: 100vh;">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Finance</h5>
            <!-- Button to add new finance information -->
            <button class="btn btn-success" onclick="showAddForm()">+ Add Finance</button>
        </div>
        <div class="card-body">
            @if($finances->isEmpty())
                <p class="text-center">No finance logged yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Loan Type</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($finances as $finance)
                                <tr>
                                    <td>{{ $finance->expected_date }}</td>
                                    <td>{{ $finance->amount }}</td>
                                    <td>{{ $finance->loan_type }}</td>
                                    <td>{{ $finance->status }}</td>
                                    <td>{{ $finance->notes }}</td>
                                    <td>
                                        <a href="{{ route('finances.edit', $finance->id) }}" class="btn btn-sm btn-success">Edit</a>

                                        <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Form to add new finance information (hidden by default) -->
            <div id="addFinanceForm" style="display: none;">
                <form action="{{ route('finances.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="expected_date">Expected Date</label>
                        <input type="date" class="form-control" id="expected_date" name="expected_date" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="loan_type">Loan Type</label>
                        <input type="text" class="form-control" id="loan_type" name="loan_type" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="status" required>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showAddForm() {
        // Show the add finance form
        document.getElementById('addFinanceForm').style.display = 'block';
        
        // Scroll to the form
        document.getElementById('addFinanceForm').scrollIntoView({ behavior: 'smooth' });
    }

    function hideAddForm() {
        // Hide the add finance form
        document.getElementById('addFinanceForm').style.display = 'none';
        
        // Scroll to the top of the page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
