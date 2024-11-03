<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function checkStock()
    {
        $lowStockProducts = Products::where('quantity', '<', 20)->get();
        if ($lowStockProducts->isNotEmpty()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Low stock alert!',
                'products' => $lowStockProducts,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Stock levels are fine.']);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}
