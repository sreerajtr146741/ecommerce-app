{{-- resources/views/products/edit.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #fff3cd, #f8d7da); 
            min-height: 100vh; 
            font-family: 'Segoe UI', sans-serif;
        }
        .card { 
            max-width: 560px; 
            margin: 60px auto; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #ffc107, #ff8c00);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .form-control, .form-select { 
            border: none; 
            border-bottom: 2px solid #ddd; 
            border-radius: 0; 
            padding: 12px 0; 
            background: transparent;
        }
        .form-control:focus, .form-select:focus { 
            border-color: #ffc107; 
            box-shadow: none; 
            background: transparent;
        }
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ff8c00);
            border: none;
            padding: 12px 40px;
            border-radius: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 fw-bold">Edit Product</h2>
        </div>
        
        <div class="card-body p-5">

            <form method="POST" 
                  action="{{ route('products.update', $product) }}" 
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Product Name</label>
                    <input type="text" name="name" class="form-control form-control-lg" 
                           value="{{ old('name', $product->name) }}" required>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Category</label>
                    <select name="category" class="form-select form-select-lg">
                        <option value="">Choose Category</option>
                        <option value="Electronics" {{ old('category', $product->category) == 'Electronics' ? 'selected' : '' }}>
                            Electronics
                        </option>
                        <option value="Clothing" {{ old('category', $product->category) == 'Clothing' ? 'selected' : '' }}>
                            Clothing & Fashion
                        </option>
                        <option value="Food" {{ old('category', $product->category) == 'Food' ? 'selected' : '' }}>
                            Food & Fruits
                        </option>
                        <option value="Vehicles" {{ old('category', $product->category) == 'Vehicles' ? 'selected' : '' }}>
                            Vehicles
                        </option>
                        <option value="Furniture" {{ old('category', $product->category) == 'Furniture' ? 'selected' : '' }}>
                            Furniture
                        </option>
                        <option value="Books" {{ old('category', $product->category) == 'Books' ? 'selected' : '' }}>
                            Books & Stationery
                        </option>
                        <option value="Sports" {{ old('category', $product->category) == 'Sports' ? 'selected' : '' }}>
                            Sports & Fitness
                        </option>
                        <option value="Other" {{ old('category', $product->category) == 'Other' ? 'selected' : '' }}>
                            Other
                        </option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Description</label>
                    <textarea name="description" class="form-control" rows="4" 
                              placeholder="Describe your product...">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control form-control-lg" 
                           value="{{ old('price', $product->price) }}" required>
                </div>

                <!-- Current Photo -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Current Photo</label><br>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}"
                             class="img-thumbnail rounded" 
                             style="max-height: 220px; width: auto; border: 3px solid #ffc107;">
                    @else
                        <div class="bg-light border border-warning border-3 rounded d-inline-block p-4">
                            <p class="text-muted mb-0">No photo uploaded yet</p>
                        </div>
                    @endif
                </div>

                <!-- Change Photo -->
                <div class="mb-5">
                    <label class="form-label fw-bold text-dark">Change Photo</label>
                    <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
                    <small class="text-muted">JPG, PNG, GIF, WebP · Max 2MB</small>
                </div>

                <!-- Buttons -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg px-5 fw-bold shadow">
                        Update Product
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg ms-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>