<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop - All Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Products</h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-success">Add My Product</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger ms-2">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Real products from Fake Store API -->
    <h3 class="mt-5 mb-3 text-primary">Featured Products</h3>
    <div class="row">
        @foreach($apiProducts as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $item['image'] }}" class="card-img-top p-3" style="height: 220px; object-fit: contain; background:white;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ Str::limit($item['title'], 50) }}</h6>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($item['description'], 80) }}</p>
                        <h5 class="text-success mt-auto">${{ number_format($item['price'], 2) }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- User's own products (only show if exist) -->
    @if($myProducts->count() > 0)
        <h3 class="mt-5 mb-3 text-dark">My Products</h3>
        <div class="row">
            @foreach($myProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow">
                        <div class="bg-light text-center py-5">
                            <img src="https://img.icons8.com/ios-filled/80/0d6efd/box.png" width="60">
                        </div>
                        <div class="card-body">
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted small">{{ Str::limit($product->description ?? '', 60) }}</p>
                            <h5 class="text-success">${{ number_format($product->price, 2) }}</h5>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>