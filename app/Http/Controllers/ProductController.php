<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class ProductController extends Controller
{
    // Remove this entire __construct() block:
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    public function index(Request $request)
    {
        // Seed from public API if empty (one-time)
        if (Product::count() === 0) {
            $response = Http::get('https://fakestoreapi.com/products');
            if ($response->successful()) {
                foreach ($response->json() as $item) {
                    Product::create([
                        'name' => $item['title'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'category' => $item['category'],
                    ]);
                }
            }
        }

        $query = Product::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        Product::create($request->all());
        return redirect('/products')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        $product->update($request->all());
        return redirect('/products')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('success', 'Product deleted successfully.');
    }
}