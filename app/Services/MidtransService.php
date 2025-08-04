<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($order, $user)
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->product_variant_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name . ' ' . ($item->variant_color ?? '') . ' ' . ($item->variant_size ?? ''),
            ];
        }

        $items[] = [
            'id' => 'SHIPPING',
            'price' => $order->shipping_cost,
            'quantity' => 1,
            'name' => 'Biaya Pengiriman',
        ];

        if ($order->discount > 0) {
            $items[] = [
                'id' => 'DISCOUNT',
                'price' => -$order->discount,
                'quantity' => 1,
                'name' => 'Diskon',
            ];
        }

        $expiry = [
            'start_time' => now()->format('Y-m-d H:i:s O'),
            'unit' => 'minute',
            'duration' => 10,
        ];

        // Default fallback biar gak error
        $address = [
            'first_name'   => $user->name,
            'address'      => $order->shipping_address,
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $order->total_amount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'shipping_address' => $address,
                'billing_address' => $address,
            ],
            'expiry' => $expiry,
            'custom_fields' => [
                'order_note' => 'Pembayaran pesanan #' . $order->order_code,
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
