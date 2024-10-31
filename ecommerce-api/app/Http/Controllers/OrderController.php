<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Order created', 'order' => $order]);
    }

    public function getOrder($id)
    {
        $order = Order::with('product')->findOrFail($id);
        return response()->json($order);
    }
}
