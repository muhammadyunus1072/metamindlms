<?php

namespace App\Models;

use App\Helpers\FileHelper;
use App\Helpers\NumberGenerator;
use Sis\TrackHistory\HasTrackHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'payment_method_name',
        'payment_method_description',
        'last_status_id',
        'proof_of_payment',
        'number',
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $model->number = NumberGenerator::generate('INV', self::class);
            $payment_method = $model->paymentMethod;
            $model->payment_method_name = $payment_method->name;
            $model->payment_method_description = $payment_method->description;
        });

        self::created(function ($model) {
            $user = User::where('id', info_user_id())->with([
                'carts',
                'carts.product',
            ])
                ->first();

            foreach ($user->carts as $cart) {
                $transaction_detail = new TransactionDetail();
                $transaction_detail->transaction_id = $model->id;
                $transaction_detail->product_id = $cart->product->id;
                $transaction_detail->product_name = $cart->product->name;
                $transaction_detail->product_description = $cart->product->description;
                $transaction_detail->product_price = $cart->product->price;
                $transaction_detail->product_price_before_discount = $cart->product->price_before_discount;
                $transaction_detail->product_remarks_id = $cart->product->remarks_id;
                $transaction_detail->product_remarks_type = $cart->product->remarks_type;
                $transaction_detail->save();
            }

            $transaction_status = new TransactionStatus();
            $transaction_status->transaction_id = $model->id;
            $transaction_status->name = TransactionStatus::STATUS_PAYMENT_PENDING;
            $transaction_status->description = TransactionStatus::STATUS_PAYMENT_PENDING;
            $transaction_status->save();

            $user->carts()->delete();
        });
    }

    public function getImage()
    {
        return $this->proof_of_payment ? FileHelper::PROOF_OF_PAYMENT_READ_LOCATION . $this->proof_of_payment : null;
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(TransactionStatus::class, 'last_status_id', 'id');
    }
}
