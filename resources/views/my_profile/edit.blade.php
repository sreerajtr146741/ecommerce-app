<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa, #c3cfe2); min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .card { max-width: 560px; margin: 60px auto; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
        .avatar-preview { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 5px solid #0d6efd; }
        .btn-save { background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none; border-radius: 50px; padding: 12px 50px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Edit Profile</h2>
            <p class="text-muted">Update your login details</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Profile Photo -->
            <div class="text-center mb-4">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                         class="avatar-preview" alt="Profile">
                @else
                    <div class="bg-primary text-white d-flex align-items-center justify-content-center avatar-preview fw-bold fs-1">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                @endif
                <div class="mt-3">
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">JPG, PNG, max 2MB</small>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control form-control-lg" 
                       value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" 
                       value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-bold">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                <input type="password" name="password" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm new password">
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-save text-white fw-bold">
                    Save Changes
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary ms-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
