<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        try {
            $products = Product::all();
            return view('product', compact('products'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load products.');
        }
    }

    // Show create form
    public function create()
    {
        try {
            return view('create');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to open create form.');
        }
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        try {
            Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
            ]);

            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product.')->withInput();
        }
    }

    // Show edit form
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('edit', compact('product'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load product for editing.');
        }
    }

    // Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
            ]);

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update product.')->withInput();
        }
    }

    // Delete product
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product.');
        }
    }
}
