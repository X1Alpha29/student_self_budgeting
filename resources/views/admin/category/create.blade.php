@extends('admin.layouts.main')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Budget Categories</li>
    </ol>
</div>

<div class="row justify-content-center" style="margin-left: 20px;">
    @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    <div class="col-sm-6"> <!-- Reduced form width -->
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" id="createCategoryForm">
            @csrf
            <div class="card mb-3 shadow-sm"> <!-- Added shadow for depth -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark text-white">
                    <h6 class="m-0 font-weight-bold">Create Budget Category</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 pr-md-2 border-end"> <!-- Added border-end class -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter the name of category">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-md-2">
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <select name="duration" id="duration" class="form-select">
                                    <option value="Week">Week</option>
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                            <div class="form-group">
                                <label for="amount">Amount (£)</label>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01" placeholder="Enter amount in GBP">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-md-2">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
