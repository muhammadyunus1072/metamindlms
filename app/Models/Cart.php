<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class Cart extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public static function is_product_in_cart($product_id)
    {
        $product = Cart::where('user_id', info_user_id())
            ->where('product_id', $product_id)
            ->first();
        if (!$product) {
            return false;
        }
        return true;
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function get_notification_cart()
    {
        $data = [];
        $carts = self::where('user_id', info_user_id())
            ->count();
            
        array_push($data, [
            'id_menu' => "cart",
            'body' => $carts,
            'style' => 'danger'
        ]);

        return $data;
    }
}
