<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty!',
                'status' => false,
            ]);
        }

        DB::beginTransaction();

        try {
            $order = $user->orders()->create([
                'total_price' => $cartItems->sum(fn($item) => $item->quantity * $item->product->price),
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;

                if ($product->stock_quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $product->decrement('stock_quantity', $item->quantity);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item->quantity,
                    'price'      => $product->price,
                ]);
            }

            // Clear cart
            $user->cart()->delete();

            DB::commit();
            Mail::to($user->email)->send(new OrderConfirmationMail($order));

            return response()->json([
                'message' => 'Order placed successfully!',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to place order!',
                'status' => false,
            ]);
        }
    }
}
