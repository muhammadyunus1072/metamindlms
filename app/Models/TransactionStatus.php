<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class TransactionStatus extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;


    const STATUS_PAYMENT_PENDING = "Menunggu Pembayaran";
    const STATUS_ORDER_CONFIRMATION_PENDING = "Menunggu Konfirmasi";
    const STATUS_DONE = "Selesai";
    const STATUS_CANCEL = "Batal";

    const STATUS_CHOICE = [
        self::STATUS_PAYMENT_PENDING => self::STATUS_PAYMENT_PENDING,
        self::STATUS_ORDER_CONFIRMATION_PENDING => self::STATUS_ORDER_CONFIRMATION_PENDING,
        self::STATUS_DONE => self::STATUS_DONE,
        self::STATUS_CANCEL => self::STATUS_CANCEL,
    ];

    protected $fillable = [
        'transaction_id',
        'name',
        'description',
    ];
    protected static function onBoot()
    {
        self::created(function ($model) {
            $transaction = $model->transaction;
            $transaction->last_status_id = $model->id;
            $transaction->save();
        });
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function get_beautify()
    {
        switch ($this->name) {
            case self::STATUS_PAYMENT_PENDING:
                $class = "warning";
                break;
            case self::STATUS_ORDER_CONFIRMATION_PENDING:
                $class = "info";
                break;
            case self::STATUS_DONE:
                $class = "success";
                break;
            case self::STATUS_CANCEL:
                $class = "danger";
                break;
        }
        
        return "<div class=' bg-$class rounded-pill p-2 text-white border border-0'>$this->name</div>";
    }
}
