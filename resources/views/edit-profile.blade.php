<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow" style="max-width: 500px; margin: auto;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="m-0">Edit Profile</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/edit-profile') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" 
                           class="form-control"
                           value="{{ old('email', auth()->user()->email) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        New Password (optional)
                    </label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="text-center">
                    <button class="btn btn-primary px-4">Save</button>
                    <a href="{{ url('/products') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
