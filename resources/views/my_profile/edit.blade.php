{{-- resources/views/profile/edit.blade.php --}}
{{-- CLEAN & FULLY WORKING – NO JETSTREAM DEPENDENCIES --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - MyStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2); 
            min-height: 100vh; 
            font-family: 'Segoe UI', sans-serif; 
        }
        .card { 
            max-width: 560px; 
            margin: 60px auto; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.15); 
            background: white;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .avatar-preview { 
            width: 130px; 
            height: 130px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 6px solid white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-save { 
            background: linear-gradient(135deg, #0d6efd, #0dcaf0); 
            border: none; 
            border-radius: 50px; 
            padding: 14px 60px; 
            font-size: 1.1rem;
            font-weight: 600;
        }
        .btn-save:hover { 
            background: linear-gradient(135deg, #0b5ed7, #0babcc); 
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 fw-bold">Edit Profile</h2>
            <p class="mb-0 opacity-90">Update your account information</p>
        </div>

        <div class="card-body p-5">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo -->
                <div class="text-center mb-5">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                             class="avatar-preview" alt="Profile">
                    @else
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center avatar-preview fw-bold fs-1">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="mt-4">
                        <input type="file" name="photo" class="form-control form-control-lg" accept="image/*">
                        <small class="text-muted">JPG, PNG, GIF, WebP · Max 2MB</small>
                    </div>
                </div>

                <!-- Name & Email -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" 
                               value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" 
                               value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                </div>

                <!-- Optional Password -->
                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            New Password <small class="text-muted">(leave blank to keep current)</small>
                        </label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="••••••••">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-save text-white shadow-lg">
                        Save Changes
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg ms-3 px-5">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
