<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourse extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'quota',
        'date_time_start',
        'date_time_end',
        'image',
        'url_online_meet',
        'price',
        'price_before_discount',
    ];

    protected static function onBoot()
    {
        self::created(function ($model) {
            $product = new Product();
            $product->name = $model->title;
            $product->description = $model->description;
            $product->price = $model->price;
            $product->price_before_discount = $model->price_before_discount;
            $product->remarks_id = $model->id;
            $product->remarks_type = self::class;
            $product->save();

            $product_offline_course = new ProductOfflineCourse();
            $product_offline_course->product_id = $product->id;
            $product_offline_course->offline_course_id = $model->id;
            $product_offline_course->save();
        });
        self::updated(function ($model) {
            $product = $model->product;
            $product->name = $model->title;
            $product->description = $model->description;
            $product->price = $model->price;
            $product->price_before_discount = $model->price_before_discount;
            $product->save();
        });
        self::deleted(function ($model) {
            $product = $model->product;
            $product->delete();
        });
    }

    public function getImage()
    {
        return $this->image ? FileHelper::OFFLINE_COURSE_READ_LOCATION . $this->image : null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'remarks_id')->where('remarks_type', self::class);
    }

    public function offlineCourseCategories()
    {
        return $this->hasMany(OfflineCourseCategory::class, "offline_course_id", 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryCourse::class, 'offline_course_categories', 'offline_course_id', 'category_course_id')->whereNull('offline_course_categories.deleted_at');
    }

    public function attendances()
    {
        return $this->hasMany(OfflineCourseAttendance::class, 'offline_course_id', 'id');
    }

    public function registrars()
    {
        return $this->hasMany(OfflineCourseRegistrar::class, 'offline_course_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(OfflineCourseAttachment::class, 'offline_course_id', 'id');
    }

    public function links()
    {
        return $this->hasMany(OfflineCourseLink::class, 'offline_course_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(OfflineCourseVideo::class, 'offline_course_id', 'id');
    }
}
