<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .top-navbar {
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
        }
        .dropdown-menu {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: none;
            min-width: 240px;
            overflow: hidden;
        }
        .card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.12)!important; 
            transition: all 0.3s ease; 
        }
        .product-image { height: 220px; object-fit: cover; width: 100%; border-bottom: 1px solid #eee; }
        .placeholder-img { height: 220px; display: flex; align-items: center; justify-content: center; background: #f1f3f5; flex-direction: column; }
    </style>
</head>
<body>

<!-- TOP NAVBAR WITH PROFILE -->
<nav class="top-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        
        <!-- App Name -->
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <h2 class="mb-0 fw-bold text-primary">MyStore</h2>
        </a>

        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" 
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                
                <!-- Avatar: Real Photo or Initials -->
                <div class="me-3">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                             alt="{{ auth()->user()->name }}" class="user-avatar">
                    @else
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center user-avatar fw-bold fs-4">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <!-- Name & Email -->
                <div class="text-start">
                    <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-header text-primary fw-bold">
                    Welcome, {{ auth()->user()->name }}!
                </li>
                <li><hr class="dropdown-divider"></li>
                
                <li>
                    <a class="dropdown-item py-2" href="{{ route('products.index') }}">
                        My Products ({{ $myProducts->count() }})
                    </a>
                </li>
                
                <!-- EDIT PROFILE LINK - NOW WORKING! -->
                <li>
                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                        Edit Profile
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>
                
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container py-5">

    <!-- Page Title + Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark">My Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success btn-lg shadow-sm">
            Add New Product
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search + Category Filter -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-lg" 
                       placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select form-select-lg">
                    <option value="">All Categories</option>
                    <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                    <option value="Clothing" {{ request('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="Food" {{ request('category') == 'Food' ? 'selected' : '' }}>Food & Fruits</option>
                    <option value="Vehicles" {{ request('category') == 'Vehicles' ? 'selected' : '' }}>Vehicles</option>
                    <option value="Furniture" {{ request('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="Books" {{ request('category') == 'Books' ? 'selected' : '' }}>Books</option>
                    <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
            </div>
        </div>
        @if(request('search') || request('category'))
            <div class="mt-2">
                <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
                    Clear filters
                </a>
            </div>
        @endif
    </form>

    <!-- Product Count -->
    @if($myProducts->count() > 0)
        <p class="text-muted mb-4">Showing {{ $myProducts->count() }} product{{ $myProducts->count() > 1 ? 's' : '' }}</p>
    @endif

    <!-- Products Grid -->
    @if($myProducts->count() > 0)
        <div class="row g-4">
            @foreach($myProducts as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        @if($product->image && \Storage::disk('public')->exists($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <div class="placeholder-img bg-light">
                                <img src="https://img.icons8.com/ios-filled/80/0d6efd/box.png" alt="No image">
                                <small class="text-muted mt-2">No photo</small>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                <span class="badge bg-secondary fs-6">{{ $product->category ?? 'Uncategorized' }}</span>
                            </div>
                            <p class="text-muted small flex-grow-1 mt-2">
                                {{ $product->description ? Str::limit($product->description, 90) : 'No description' }}
                            </p>
                            <h4 class="text-success mb-0 mt-3">${{ number_format($product->price, 2) }}</h4>
                        </div>

                        <div class="card-footer bg-white border-0 text-center py-3">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm px-4">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-4 ms-2"
                                        onclick="return confirm('Delete {{ addslashes($product->name) }}?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 my-5">
            <img src="https://img.icons8.com/carbon-copy/120/000000/empty-box.png" alt="No products">
            <h3 class="mt-4 text-muted">
                @if(request('search') || request('category')) 
                    No products found 
                @else 
                    You haven't added any products yet 
                @endif
            </h3>
            <a href="{{ route('products.create') }}" class="btn btn-success btn-lg px-5 mt-3">
                Add Your First Product
            </a>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>