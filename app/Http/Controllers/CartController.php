<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cart.index');
    }

    public function getData(Request $request)
    {
        $datas = Cart::with('product')->where('user_id', auth()->id());

        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('name', fn($data) => $data->product->name ?? '')
            ->addColumn('price', fn($data) => number_format($data->product->price ?? 0, 2))
            ->addColumn('amount', function ($data) {
                $price = $data->product->price ?? 0;
                return number_format($price * $data->quantity, 2);
            })
            ->addColumn('action', function ($data) {
                $url = route('cart.destroy', $data->id);
                return '<button class="btn-delete" data-url="' . $url . '" style="color:red; border:none; background:none; cursor:pointer;">Delete</button>';
            })
            ->addColumn('quantity', function ($data) {
                return '
                        <input
                            type="number"
                            value="' . $data->quantity . '"
                            min="1"
                            data-id="' . $data->id . '"
                            class="cart-qty-input"
                            style="width: 60px; text-align: center; padding: 5px;" />
                    ';
            })
            ->rawColumns(['action', 'quantity'])
            ->make(true);
    }



    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $existing = $user->cart()->where('product_id', $request->product_id)->first();

        if ($existing) {
            $newQuantity = $existing->quantity + $request->quantity;

            if ($newQuantity > $product->stock_quantity) {
                return redirect()->route('cart.index')->with('error', 'Not enough stock available.');
            }

            $existing->quantity = $newQuantity;
            $existing->save();
        } else {
            $user->cart()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }



    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json(['message' => 'Quantity updated']);
    }



    public function destroy($id)
    {
        $item = Cart::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }
        $item->delete();

        return response()->json(['message' => 'Item removed.']);
    }
}
