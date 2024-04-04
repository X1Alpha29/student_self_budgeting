@extends('admin.layouts.main')

@section('content')
<div class="container-fluid" style="min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0 d-inline-block">Direct Debits</h4>
                    <button onclick="showAddForm()" class="btn btn-success float-end">+ Add New</button> <!-- Moved the Add New button here -->
                </div>
                <div class="card-body">
                    @if($debits->isEmpty())
                        <p class="text-center">No Direct Debits logged yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Amount (£)</th>
                                        <th scope="col">Reoccurrence Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($debits as $debit)
                                        <tr>
                                            <td>{{ $debit->name }}</td>
                                            <td>{{ $debit->details }}</td>
                                            <td>{{ $debit->category }}</td>
                                            <td>£{{ number_format($debit->amount, 2) }}</td>
                                            <td>{{ date('Y-m-d', strtotime($debit->reoccurance_date)) }}</td>
                                            <td>
                                                <button onclick="showUpdateForm({{ $debit }})" class="btn btn-primary btn-sm">Update</button>
                                                <form action="{{ route('debits.destroy', $debit->id) }}" method="POST" style="display:inline;">
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
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 justify-content-center">
    <div class="col-md-6">
        <div id="addDebitCard" class="card" style="display: none;">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Add New Direct Debit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('debits.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea class="form-control" id="details" name="details"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount (£)</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reoccurance_date">Reoccurrence Date</label>
                                <input type="date" class="form-control" id="reoccurance_date" name="reoccurance_date" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" onclick="hideAddForm()" class="btn btn-secondary float-right">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    function showAddForm() {
        document.getElementById('addDebitCard').style.display = 'block';
    }

    function hideAddForm() {
        document.getElementById('addDebitCard').style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showUpdateForm(debit) {
        document.getElementById('updateDebitCard').style.display = 'block';
        document.getElementById('updateName').value = debit.name;
        document.getElementById('updateDetails').value = debit.details;
        document.getElementById('updateCategory').value = debit.category;
        document.getElementById('updateAmount').value = debit.amount;
        document.getElementById('updateReoccuranceDate').value = debit.reoccurance_date;

    }
    function hideUpdateForm() {
    document.getElementById('updateDebitCard').style.display = 'none';
    window.scrollTo(0, 0);
    }   
</script>
@endsection

