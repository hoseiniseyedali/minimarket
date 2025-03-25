<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['index']);
    }

    /**
     * Display a listing of orders for admin.
     */
    public function index()
    {
        $orders = Order::with(['user', 'products'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Create a new order from the cart.
     */
    public function create(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products first.');
        }

        try {
            return DB::transaction(function () use ($cart) {
                $totalAmount = 0;
                $cartItems = [];

                // Calculate total amount and prepare cart items
                foreach ($cart as $productId => $quantity) {
                    $product = Product::findOrFail($productId);
                    $totalAmount += $product->price * $quantity;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity
                    ];
                }

                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                // Attach products to order
                foreach ($cartItems as $item) {
                    $order->products()->attach($item['product']->id, [
                        'quantity' => $item['quantity'],
                        'price' => $item['product']->price,
                    ]);
                }

                // Clear the cart after successful order
                Session::forget('cart');

                return redirect()->route('home')
                    ->with('success', 'Order placed successfully!');
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }
} 