@extends('admin.layouts.main')

@section('content')
<div class="d-sm-flex-items-center justify-contnet-between mb-4">
    <h1 class="h3 mb-0 ml-4 text-gray-800">Budget Categories</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update Budget Category</li>
    </ol>
</div>

<div class="row justify-content-center" style="margin-left: 20px;">
    @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    <div class="col-lg-10">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-6">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Update Budget Category</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control" placeholder="Enter the name of category">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <select name="duration" class="form-control">
                            <option value="Week" {{ $category->duration == 'Week' ? 'selected' : '' }}>Week</option>
                            <option value="Month" {{ $category->duration == 'Month' ? 'selected' : '' }}>Month</option>
                            <option value="Year" {{ $category->duration == 'Year' ? 'selected' : '' }}>Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (£)</label>
                        <input type="number" name="amount" value="{{ $category->amount }}" class="form-control" step="0.01" placeholder="Enter amount in GBP">
                    </div>
                    <div class="form-group">
                        <label for="from_date">From Date</label>
                        <input type="date" name="from_date" value="{{ $category->from_date }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="to_date">To Date</label>
                        <input type="date" name="to_date" value="{{ $category->to_date }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
