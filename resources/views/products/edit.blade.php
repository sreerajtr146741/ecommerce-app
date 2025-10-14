<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        textarea { resize: vertical; height: 100px; }
        .btn { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-top: 15px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .back { background: #6c757d; text-decoration: none; padding: 10px 15px; border-radius: 5px; color: white; margin-left: 10px; }
        .back:hover { background: #5a6268; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Product Name:</label>
        <input type="text" name="name" value="{{ $product->name }}" required>

        <label>Description:</label>
        <textarea name="description" required>{{ $product->description }}</textarea>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>

        <label>Category:</label>
        <input type="text" name="category" value="{{ $product->category }}">

        <button type="submit" class="btn">Update Product</button>
        <a href="{{ route('products.index') }}" class="back">Back</a>
    </form>
</div>
</body>

</html>
