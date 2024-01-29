<?php

namespace App\Http\Controllers;

use App\Models\Cart;

class MenuNotificationController extends Controller
{
    public function get()
    {
        $data = [];

        $data[] = Cart::get_notification_cart();

        return $data;
    }
}
