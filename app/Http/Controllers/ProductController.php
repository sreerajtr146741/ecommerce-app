<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the user's products with search & category filter
     */
    public function index()
    {
        $query = Product::where('user_id', auth()->id());

        // Search by name or description
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = request('category')) {
            $query->where('category', $category);
        }

        $myProducts = $query->latest()->get();

        return view('products.index', compact('myProducts'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'price'       => 'required|numeric|min:0.01',
                'category'    => 'nullable|string|max:100',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            ]);

            $data = $request->only(['name', 'description', 'price', 'category']);
            $data['user_id'] = auth()->id();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($data);

            return redirect()
                ->route('products.index')
                ->with('success', 'Product added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to add product.');
        }
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            if ($product->user_id !== auth()->id()) {
                abort(403, 'You can only edit your own products.');
            }

            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'price'       => 'required|numeric|min:0.01',
                'category'    => 'nullable|string|max:100',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            ]);

            $data = $request->only(['name', 'description', 'price', 'category']);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Update failed. Try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->user_id !== auth()->id()) {
                abort(403);
            }

            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully!');

        } catch (Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete product.');
        }
    }
}