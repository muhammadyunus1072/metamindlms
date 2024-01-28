<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'price_before_discount',
        'remarks_id',
        'remarks_type',
    ];

    protected static function onBoot()
    {
        self::deleted(function ($model) {
            $model->productCourses()->delete();
            $model->productOfflineCourses()->delete();
        });
    }

    public function productCourses()
    {
        return $this->hasMany(ProductCourse::class, 'product_id', 'id');
    }

    public function productOfflineCourses()
    {
        return $this->hasMany(ProductOfflineCourse::class, 'product_id', 'id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id', 'product_id');
    }
}
