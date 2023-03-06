<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseMember extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    //Track History
    protected static function onBoot()
    {
        self::creating(function ($model) {
            $model->code = self::generateCode();
        });
    }

    public static function generateCode()
    {
        $numberLength = 8;
        // Get Last Number
        $lastModel = self::orderBy('id', 'DESC')->withTrashed()->first();
        if (!empty($lastModel)) {
            $lastNumber = $lastModel->id;
        } else {
            $lastNumber = 0;
        }

        // Get Current Number
        $currentNumber = strval($lastNumber + 1);
        $currentNumber = str_pad($currentNumber, $numberLength, "0", STR_PAD_LEFT);

        // Generate Format Number
        $formattedNumber = "COM-$currentNumber";

        return $formattedNumber;
    }
}
