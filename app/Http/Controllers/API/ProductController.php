<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('image')->get();
        return ResponseFormatter::success([
            'products' => ProductResource::collection($products),
        ]);
    }

    public function getProduct(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('image')->where('nama', 'like', '%' . $search . '%')->orWhere('deskripsi', 'like', '%' . $search . '%')->orWhere('varian', 'like', '%' . $search . '%')->orWhere('kode', 'like', '%' . $search . '%')->get();
        return ResponseFormatter::success([
            'products' => ProductResource::collection($products),
        ]);
    }
}
