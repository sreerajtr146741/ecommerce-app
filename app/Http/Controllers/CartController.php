<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $cart = session('cart', []);
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image
        ];
        
        session(['cart' => $cart]);

        return back()->with('success', 'Added to Cart Successfully!');
    }

    public function remove(Request $request, $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back();
    }
}