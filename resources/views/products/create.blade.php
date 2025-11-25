{{-- resources/views/products/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #e4efe9);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 520px;
            margin: 60px auto;
            background: white;
        }
        .form-control {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 12px 0;
            font-size: 1.1rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }
        .btn-submit {
            background: #28a745;
            border: none;
            border-radius: 12px;
            padding: 12px 40px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .btn-submit:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-5">
        <h2 class="text-center mb-5 text-success fw-bold">Add New Product</h2>

        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div class="mb-4">
                <input type="text" name="name" class="form-control" 
                       placeholder="Product Name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <textarea name="description" class="form-control" rows="4" 
                          placeholder="Description (optional)">{{ old('description') }}</textarea>
            </div>

            <div class="mb-5">
                <input type="number" step="0.01" name="price" class="form-control" 
                       placeholder="Price ($)" value="{{ old('price') }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-submit text-white">
                    Add Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>