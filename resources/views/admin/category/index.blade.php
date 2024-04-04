@extends('admin.layouts.main')

@section('content')
<div class="container-fluid" id="container-wrapper" style="min-height: 100vh; display: flex; flex-direction: column;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active" aria-current="page">Budgets</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header-sm bg-dark text-white d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Budget Table</h6>
                    <a href="{{ route('category.create') }}" class="btn btn-success">Create New Budget</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-flush table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Budget ID:</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>From</th>
                                <th>Until</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($categories) > 0)
                            @foreach($categories as $key => $category)
                            <tr>
                                <td><a href="#">{{ $key + 1 }}</a></td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>{{ $category->duration }}</td>
                                <td>£{{ $category->amount }}</td>
                                <td>{{ $category->from_date }}</td>
                                <td>{{ $category->to_date }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Update</a>
                                </td>
                                <td>
                                    <form id="deleteForm{{$category->id}}" action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" onclick="return confirmDelete({{ $category->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9">No Category created yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this category?")) {
            document.getElementById("deleteForm" + id).submit();
        }
        return false; // Cancel button was pressed, so return false
    }
</script>
