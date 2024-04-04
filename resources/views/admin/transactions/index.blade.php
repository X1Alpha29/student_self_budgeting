@extends('admin.layouts.main')

@section('content')
<div class="container-fluid" style="min-height: 100vh;">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5>Categories</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Duration</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>£{{ $category->amount }}</td>
                            <td>{{ $category->duration }}</td>
                            <td>{{ $category->from_date }}</td>
                            <td>{{ $category->to_date }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-success">Update</a>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
        </div>
    </div>
</div>

@endsection
