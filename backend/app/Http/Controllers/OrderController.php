<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        // Gộp các dòng trùng product_id thành một
        $quantities = [];
        foreach ($data['items'] as $item) {
            $id = $item['product_id'];
            $quantities[$id] = ($quantities[$id] ?? 0) + $item['quantity'];
        }

        $order = DB::transaction(function () use ($request, $data, $quantities) {
            $products = Product::whereIn('id', array_keys($quantities))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            foreach ($quantities as $productId => $quantity) {
                $product = $products[$productId];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Sản phẩm \"{$product->name}\" chỉ còn {$product->stock} sản phẩm"],
                    ]);
                }

                $total += $product->price * $quantity;
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'receiver_name' => $data['receiver_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'status' => 'pending',
                'total_price' => $total,
            ]);

            foreach ($quantities as $productId => $quantity) {
                $product = $products[$productId];

                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => $quantity,
                ]);

                $product->decrement('stock', $quantity);
            }

            return $order;
        });

        return response()->json(['data' => $this->summary($order)], 201);
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $orders->map(fn (Order $order) => $this->summary($order)),
        ]);
    }

    public function show(Request $request, int $id)
    {
        $order = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (! $order) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }

        return response()->json([
            'data' => $this->summary($order) + [
                'receiver_name' => $order->receiver_name,
                'phone' => $order->phone,
                'address' => $order->address,
                'note' => $order->note,
                'items' => $order->items->map(fn ($item) => [
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]),
            ],
        ]);
    }

    private function summary(Order $order): array
    {
        return [
            'id' => $order->id,
            'status' => $order->status,
            'total_price' => $order->total_price,
            'created_at' => $order->created_at->toIso8601ZuluString(),
        ];
    }
}