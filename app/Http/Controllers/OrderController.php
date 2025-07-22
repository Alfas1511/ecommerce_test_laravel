<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function place(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
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

            return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function index()
    {
        return view('orders.index');
    }

    public function getData()
    {

        $datas = Order::where('user_id', auth()->user()->id);
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return $data->created_at ? Carbon::parse($data->created_at)->format('d-m-Y') : "";
            })
            ->addColumn('view_order_details', function ($data) {
                return '<a href="' . route('orders.viewDetails', $data->id) . '" style="text-decoration:none; padding: 4px 20px; background: green; color: white; border: none; border-radius: 5px;">View details</a>';
            })
            ->rawColumns(['view_order_details'])
            ->make(true);
    }

    public function viewDetails(string $id)
    {
        $order_details = OrderItem::where('order_id', $id)->get();
        return view('orders.view_order_details', compact('order_details'));
    }
}
