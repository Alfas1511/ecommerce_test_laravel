<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
    }

    public function getData(Request $request)
    {
        $datas = Product::query();
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $editUrl = route('products.edit', $data->id);
                $deleteUrl = route('products.destroy', $data->id);

                $btn = '<a href="' . $editUrl . '" style="padding: 4px 20px; background: black; text-decoration:none; color: white; border: none; border-radius: 5px;">Edit</a>';

                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline-block; margin-left:8px;" onsubmit="return confirm(\'Are you sure?\')">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" style="padding: 8px 20px; background: red; color: white; border: none; border-radius: 5px; cursor:pointer;">
                    Delete
                </button>
            </form>';

                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->stock_quantity = $data['stock'];
        $product->save();

        return redirect()->route('products.index')->with('success', "Product Added Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, string $id)
    {
        $data = $request->validated();

        $product = Product::find($id);
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->stock_quantity = $data['stock'];
        $product->save();

        return redirect()->route('products.index')->with('success', "Product Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }

    public function showcase()
    {
        $products = Product::all();

        return view('products.showcase', compact('products'));
    }
}
