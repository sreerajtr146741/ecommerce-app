<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <style>
        
    /* Your existing CSS */

    /* Remove Laravel pagination arrow icons */
    .pagination svg {
        display: none !important;
    }


        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; color: white; text-decoration: none; }
        .btn-add { background: #007bff; }
        .btn-add:hover { background: #0056b3; }
        .btn-edit { background: #28a745; }
        .btn-edit:hover { background: #218838; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        .logout { background: #6c757d; }
        .logout:hover { background: #5a6268; }
        .product-item { background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .product-info { max-width: 70%; }
        .product-info strong { display: block; color: #333; font-size: 16px; }
        .product-info p { margin: 5px 0; color: #555; font-size: 14px; }
        .actions { display: flex; gap: 8px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Products Page</h1>

    <div class="top-bar">
        <div>Welcome, {{ Auth::user()->name ?? 'User' }} | 
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn logout">Logout</button>
            </form>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-add">+ Add Product</a>
    </div>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <!-- Search & filter -->
    <form method="GET" action="{{ route('products.index') }}" style="margin-bottom: 16px; display:flex; gap:8px; align-items:center;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;">
        <select name="category" style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <option value="">All Categories</option>
            @if(!empty($categories))
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            @endif
        </select>
        <button type="submit" class="btn btn-add">Search</button>
        <a href="{{ route('products.index') }}" class="btn" style="background:#6c757d;">Clear</a>
    </form>

    @foreach($products as $product)
        <div class="product-item">
            <div class="product-info">
                <strong>{{ $product->name }}</strong>
                <p>{{ $product->description }}</p>
                <p><b>Category:</b> {{ $product->category ?? 'N/A' }}</p>
                <p><b>Price:</b> ${{ number_format($product->price, 2) }}</p>
            </div>
            <div class="actions">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
    <style>
/* Your existing CSS */

    /* Remove Laravel pagination arrow icons */
    .pagination svg {
        display: none !important;
    }</style>
    
    </div>
</div>
</body>
</html>
