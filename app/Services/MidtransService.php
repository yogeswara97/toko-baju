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

    public function createTransaction($order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total, // total bayar
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
            ]
        ];

        return Snap::getSnapToken($params); // return Snap Token
    }
}
