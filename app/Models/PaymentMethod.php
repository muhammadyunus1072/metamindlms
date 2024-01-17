<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const MIDTRANS_PAYMENT_METHOD = 'Midtrans';

    protected $fillable = [
        'name',
        'description',
    ];
}
