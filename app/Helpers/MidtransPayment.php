<?php

namespace App\Helpers;

use Midtrans\Config;

class MidtransPayment
{
    public static function getSnapToken($transaction_id, $gross_amount, $customerDetails)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $transaction_id,
                    'gross_amount' => $gross_amount,
                ),
                'customer_details' => $customerDetails,
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
