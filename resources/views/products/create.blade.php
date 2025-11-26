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
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            max-width: 580px;
            margin: 60px auto;
            background: white;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .form-control, .form-select {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 14px 0;
            font-size: 1.1rem;
            background: transparent;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #28a745;
            background: transparent;
        }
        .btn-submit {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 50px;
            padding: 14px 50px;
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }
        .btn-submit:hover {
            background: #218838;
        }
        .preview-img {
            max-height: 200px;
            border-radius: 12px;
            border: 3px dashed #28a745;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 fw-bold">Add New Product</h2>
        </div>

        <div class="card-body p-5">

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-success">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-lg" 
                           value="{{ old('name') }}" placeholder="Enter product name" required>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-success">Category</label>
                    <select name="category" class="form-select form-select-lg">
                        <option value="">Choose a category (optional)</option>
                        <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing & Fashion</option>
                        <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food & Fruits</option>
                        <option value="Vehicles" {{ old('category') == 'Vehicles' ? 'selected' : '' }}>Vehicles</option>
                        <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                        <option value="Books" {{ old('category') == 'Books' ? 'selected' : '' }}>Books & Stationery</option>
                        <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports & Fitness</option>
                        <option value="Beauty" {{ old('category') == 'Beauty' ? 'selected' : '' }}>Beauty & Health</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-success">Description</label>
                    <textarea name="description" class="form-control" rows="4" 
                              placeholder="Tell us about your product...">{{ old('description') }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-success">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control form-control-lg" 
                           value="{{ old('price') }}" placeholder="0.00" required>
                </div>

                <!-- Product Photo + PHP Live Preview -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-success">Product Photo</label>
                    <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
                    <small class="text-muted">JPG, PNG, GIF, WebP · Max 2MB</small>

                    <!-- PHP Image Preview (No JavaScript!) -->
                    @if ($imagePreview = old('image'))
                        <?php
                            // Get the uploaded file from old input
                            $file = request()->file('image');
                            $previewUrl = $file ? asset('storage/' . $file->store('temp', 'public')) : null;
                        ?>
                        @if ($file && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp']))
                            <div class="mt-3 text-center">
                                <img src="{{ $previewUrl }}" class="preview-img" alt="Preview">
                                <p class="text-success mt-2"><strong>Preview (will be saved)</strong></p>
                            </div>
                        @endif
                    @endif

                    @if (session('temp_image'))
                        <div class="mt-3 text-center">
                            <img src="{{ asset('storage/' . session('temp_image')) }}" class="preview-img" alt="Preview">
                            <p class="text-success mt-2"><strong>Current preview</strong></p>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-success btn-submit shadow-lg">
                        Add Product
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary ms-3 px-5">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>