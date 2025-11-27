<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Checkout single item
    public function single($id)
    {
        $cart = session('cart', []);
        if (!isset($cart[$id])) {
            return redirect()->route('products.index')->with('error', 'Item not in cart!');
        }

        $item = $cart[$id];
        $item['id'] = $id;

        return view('checkout', compact('item'));
    }

    // Checkout all items
    public function all()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart is empty!');
        }

        $items = [];
        foreach ($cart as $id => $item) {
            $item['id'] = $id;
            $items[] = $item;
        }

        return view('checkout', compact('items'));
    }

    // SUCCESS PAGE — This removes items from cart
    public function success(Request $request)
    {
        $purchasedIds = $request->input('purchased_ids', []);

        if (!empty($purchasedIds)) {
            // Mark these as purchased → will be auto-removed from cart
            $already = session('purchased_items', []);
            $merged = array_merge($already, $purchasedIds);
            session(['purchased_items' => array_unique($merged)]);
        }

        // Optional: Clear purchased list after some time or on logout
        return view('checkout-success');
    }

    // FAILED / CANCELLED → Do nothing → items stay in cart
    public function cancel()
    {
        return redirect()->route('products.index')->with('error', 'Payment cancelled. Items are still in your cart.');
    }
}