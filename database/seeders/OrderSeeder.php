<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 3;

        // Ambil 2-3 produk acak
        $products = Product::with('variants')->inRandomOrder()->take(rand(2, 3))->get();
        $totalAmount = 0;

        $order = Order::create([
            'user_id' => $userId,
            'order_code' => 'ORD-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
            'total_amount' => 0, // diupdate nanti
            'status' => 'paid',
            'shipping_address' => 'Jalan Dummy No. 123, Contoh City',
            'payment_method' => 'manual_transfer',
        ]);

        foreach ($products as $product) {
            $variant = $product->variants->isNotEmpty()
                ? $product->variants->random()
                : null;

            $price = $variant->price ?? $product->price;
            $qty = rand(1, 3);
            $subtotal = $price * $qty;
            $totalAmount += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id ?? null,
                'product_name' => $product->name,
                'variant_size' => $variant->size ?? null,
                'variant_color' => $variant->color ?? null,
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ]);
        }

        $order->update(['total_amount' => $totalAmount]);
    }
}
