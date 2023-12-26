<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Add_NewProducts;
use Illuminate\Http\Request;

class getAllVendorProductsController extends Controller
{
    public function getAllVendorProducts(Request $request, $id)
    {
        $getAllVendorProducts = Add_NewProducts::where('v_id', $id)->get();
        if (!$getAllVendorProducts->isEmpty()) {
            return response()->json(['all-vendor-products' => $getAllVendorProducts]);
        } else {
            return response()->json(['message' => 'No product found Against this Id']);
        }
    }
}
