<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 12), 1), 100);

        $products = Product::with('category')
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->query('category_id')))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->query('search') . '%'))
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products->items()),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function show(int $id)
    {
        $product = Product::with('category')->find($id);

        if (! $product) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        return new ProductDetailResource($product);
    }
}