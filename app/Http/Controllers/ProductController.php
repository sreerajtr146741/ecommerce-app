<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $apiProducts = Http::timeout(10)->get('https://fakestoreapi.com/products')->json();

            $myProducts = Product::where('user_id', auth()->id())
                ->latest()
                ->get();

            return view('products.index', [
                'apiProducts' => collect($apiProducts ?? []),
                'myProducts'  => $myProducts,
            ]);

        } catch (Exception $e) {
            Log::error('Failed to load products page: ' . $e->getMessage());

            return view('products.index', [
                'apiProducts' => collect([]),
                'myProducts'  => collect([]),
            ])->with('error', 'Unable to load products. Please try again later.');
        }
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
            ]);

            Product::create([
                'user_id'     => auth()->id(),
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
            ]);

            return redirect()
                ->route('products.index')
                ->with('success', 'Product added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to add product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        try {
            if ($product->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            return view('products.edit', compact('product'));

        } catch (Exception $e) {
            Log::error('Edit product access failed: ' . $e->getMessage());
            abort(404);
        }
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
            ]);

            $product->update([
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
            ]);

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->user_id !== auth()->id()) {
                abort(403, 'Unauthorized deletion.');
            }

            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully!');

        } catch (Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete product. Try again.');
        }
    }
}