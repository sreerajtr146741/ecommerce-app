{{-- resources/views/products/edit.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #fff3cd, #f8d7da); min-height: 100vh; }
        .card { max-width: 520px; margin: 60px auto; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .form-control { border: none; border-bottom: 2px solid #ddd; border-radius: 0; padding: 12px 0; }
        .form-control:focus { border-color: #ffc107; box-shadow: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-5">
        <h2 class="text-center mb-5 text-warning fw-bold">Edit Product</h2>

        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-4">
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-5">
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning text-dark fw-bold px-5 py-2">
                    Update Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark ms-3">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>