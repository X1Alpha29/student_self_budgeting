@extends('admin.layouts.main')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <!-- Main Profile Card -->
    <div class="card" id="profileCard" style="width: 30rem;">
        <div class="card-body text-center">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : asset('default.png') }}" class="card-img-top" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 10px;">
            <div class="d-flex justify-content-center mb-2">
                <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data" class="me-2">
                    @csrf
                    <input type="file" name="profile_picture" id="profile_picture" class="file-input" required hidden>
                    <label for="profile_picture" class="btn btn-primary btn-sm" title="Choose file">
                        <i class="fas fa-file-upload"></i>
                    </label>
                    <!-- Save Profile Picture Button -->
                    <button type="submit" id="savePictureBtn" class="btn btn-primary btn-sm d-none" style="height: 38px;">
                        Save
                    </button>
                </form>
                <form id="delete-picture-form" action="{{ route('profile.delete-picture') }}" method="POST" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()" style="height: 38px;">
                        Delete
                    </button>
                </form>
            </div>
            <div class="text-left mt-2">
                <h5 class="card-title"><span class="detail-label">Name:</span> <span class="user-info">{{ Auth::user()->name }}</span></h5>
                <p class="card-text "><span class="detail-label">Email:</span> <span class="user-info">{{ Auth::user()->email }}</span></p>
            </div>
            <br>
            <button id="updateDetailsBtn" class="btn btn-secondary" onclick="toggleUpdateCard()">Update Details</button>
        </div>
    </div>

    <!-- Update Details Card (Initially Hidden) -->
    <div class="card d-none" id="updateCard" style="width: 18rem;">
        <div class="card-body text-center">
            <form action="{{ route('profile.update-details') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="newName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="newName" name="name" value="{{ Auth::user()->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="newEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="newEmail" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-outline-secondary" onclick="toggleUpdateCard()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleUpdateCard() {
        const profileCard = document.getElementById('profileCard');
        const updateCard = document.getElementById('updateCard');
        profileCard.classList.toggle('d-none');
        updateCard.classList.toggle('d-none');
    }

    document.getElementById('profile_picture').onchange = function () {
        if (this.files.length > 0) {
            // Show the Save button
            document.getElementById('savePictureBtn').classList.remove('d-none');
        }
    };

    function confirmDelete() {
        if (confirm('Are you sure you want to delete your profile picture?')) {
            document.getElementById('delete-picture-form').submit();
        }
    }
</script>
@endsection
