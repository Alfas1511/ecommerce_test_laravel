<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = Product::find($request->product_id);

            $user = auth()->user();
            $existing = $user->cart()->where('product_id', $request->product_id)->first();

            if ($existing) {
                $newQuantity = $existing->quantity + $request->quantity;

                if ($newQuantity > $product->stock_quantity) {
                    return response()->json([
                        'message' => 'Not enough stock available.',
                        'status' => false,
                    ]);
                }

                $existing->quantity = $newQuantity;
                $existing->save();
            } else {
                $user->cart()->create([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }

            return response()->json([
                'message' => 'Product Added To Cart Successfully',
                'status' => true,
            ]);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'message' => 'Something went wrong',
                'status' => false,
            ]);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $cart = Cart::find($request->id);
            $cart->delete();

            return response()->json([
                'message' => 'Product Removed from Cart Successfully',
                'status' => true,
            ]);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'message' => 'Something went wrong',
                'status' => false,
            ]);
        }
    }
}
