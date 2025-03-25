<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }
        $cartCount = array_sum(session('cart', []));

        return view('cart.index', compact('items', 'total', 'cartCount'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        
        Session::put('cart', $cart);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => array_sum($cart)
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId] = $request->quantity;
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}