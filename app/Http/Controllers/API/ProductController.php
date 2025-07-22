<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productsList()
    {
        $datas = Product::get();
        return response()->json([
            'message' => 'Products List',
            'status' => true,
            'data' => $datas,
        ]);
    }
}
