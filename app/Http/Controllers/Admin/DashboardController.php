<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $orderCount = Order::count();

        $totalRevenue = OrderItem::sum(DB::raw('price * quantity'));

        return view('dashboard', compact('orderCount', 'totalRevenue'));
    }
}
