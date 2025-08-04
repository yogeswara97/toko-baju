<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = [1, 2, 3];

        $products = Product::with(['variants', 'variants.size', 'variants.color'])->get();

        $statuses = ['paid', 'shipped', 'completed', 'cancelled'];
        $shippingStatuses = ['requested', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered', 'confirmed'];

        for ($i = 1; $i <= 20; $i++) {
            $userId = $userIds[array_rand($userIds)];
            $orderCode = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            $shippingAddress = "Jl. Testing Order Ke-$i, Kota Laravel";
            $shippingCost = rand(10000, 30000);
            $paymentMethod = 'Bank Transfer';

            $selectedProducts = $products->random(rand(1, 3));

            $subtotal = 0;
            $discount = rand(0, 20000); // bisa 0 atau diskon kecil

            DB::beginTransaction();
            try {
                $order = Order::create([
                    'user_id' => $userId,
                    'order_code' => $orderCode,
                    'subtotal' => 0,
                    'discount' => $discount,
                    'total_amount' => 0,
                    'status' => $statuses[array_rand($statuses)],
                    'shipping_status' => $shippingStatuses[array_rand($shippingStatuses)],
                    'raja_ongkir_id' => rand(1000, 9999),
                    'shipping_cost' => $shippingCost,
                    'shipping_address' => $shippingAddress,
                    'payment_method' => $paymentMethod,
                ]);

                foreach ($selectedProducts as $product) {
                    $variant = $product->variants->random();

                    $price = $variant->price ?? $product->price;
                    $qty = rand(1, 5);
                    $lineSubtotal = $price * $qty;
                    $subtotal += $lineSubtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id ?? null,
                        'product_name' => $product->name,
                        'variant_size' => optional($variant->size)->name,
                        'variant_color' => optional($variant->color)->name,
                        'price' => $price,
                        'quantity' => $qty,
                        'subtotal' => $lineSubtotal,
                    ]);
                }

                $order->update([
                    'subtotal' => $subtotal,
                    'total_amount' => $subtotal + $shippingCost - $discount,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                dump("Gagal bikin order ke-$i: " . $e->getMessage());
            }
        }
    }
}
