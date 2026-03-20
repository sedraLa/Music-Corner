<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CartController extends Controller
{
    public function toggle($productId)
    {
        $userId = auth()->id();
        $order = Order::firstOrCreate([
            'user_id' => $userId,
            'status' => 'cart'
        ], [
            'total' => 0
        ]);

        $item = $order->items()->where('product_id', $productId)->first();

        if ($item) {
            //remove item
            $order->total -= $item->price * $item->quantity;
            $order->save();
            $item->delete();

            return response()->json(['status' => 'removed']);
        } else {
            $product = Product::findOrFail($productId);

            //add item

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);

            $order->total += $product->price;
            $order->save();

            return response()->json(['status' => 'added']);
        }
    }
}
