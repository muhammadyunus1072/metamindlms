<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'product_description',
        'product_price',
        'product_price_before_discount',
        'product_remarks_id',
        'product_remarks_type',
    ];

    protected static function onBoot()
    {
        self::created(function ($model) {
            if($model->product_remarks_type === Course::class){
                $productCourses = $model->product->productCourses;
                foreach ($productCourses as $productCourseIndex => $productCourse) {
                    $transactionDetailCourse = new TransactionDetailCourse();
                    $transactionDetailCourse->transaction_detail_id = $model->id;
                    $transactionDetailCourse->course_id = $productCourse->course->id;
                    $transactionDetailCourse->course_title = $productCourse->course->title;
                    $transactionDetailCourse->course_description = $productCourse->course->description;
                    $transactionDetailCourse->course_about = $productCourse->course->about;
                    $transactionDetailCourse->course_url_image = $productCourse->course->url_image;
                    $transactionDetailCourse->course_url_icon = $productCourse->course->url_icon;
                    $transactionDetailCourse->course_url_video = $productCourse->course->url_video;
                    $transactionDetailCourse->course_price = $productCourse->course->price;
                    $transactionDetailCourse->course_price_before_discount = $productCourse->course->price_before_discount;
                    $transactionDetailCourse->save();
                }
            }else if($model->product_remarks_type === OfflineCourse::class) {
                $productOfflineCourses = $model->product->productOfflineCourses;
                foreach ($productOfflineCourses as $productOfflineCourseIndex => $productOfflineCourse) {
                    $transactionDetailOfflineCourse = new TransactionDetailOfflineCourse();
                    $transactionDetailOfflineCourse->transaction_detail_id = $model->id;
                    $transactionDetailOfflineCourse->offline_course_id = $productOfflineCourse->offlineCourse->id;
                    $transactionDetailOfflineCourse->offline_course_title = $productOfflineCourse->offlineCourse->title;
                    $transactionDetailOfflineCourse->offline_course_description = $productOfflineCourse->offlineCourse->description;
                    $transactionDetailOfflineCourse->offline_course_content = $productOfflineCourse->offlineCourse->content;
                    $transactionDetailOfflineCourse->offline_course_quota = $productOfflineCourse->offlineCourse->quota;
                    $transactionDetailOfflineCourse->offline_course_date_time_start = $productOfflineCourse->offlineCourse->date_time_start;
                    $transactionDetailOfflineCourse->offline_course_date_time_end = $productOfflineCourse->offlineCourse->date_time_end;
                    $transactionDetailOfflineCourse->offline_url_online_meet = $productOfflineCourse->offlineCourse->url_online_meet;
                    $transactionDetailOfflineCourse->offline_course_price = $productOfflineCourse->offlineCourse->price;
                    $transactionDetailOfflineCourse->offline_course_price_before_discount = $productOfflineCourse->offlineCourse->price_before_discount;
                    $transactionDetailOfflineCourse->save();
                }
            }else{
                $productCourses = $model->product->productCourses;
                foreach ($productCourses as $productCourseIndex => $productCourse) {
                    $transactionDetailCourse = new TransactionDetailCourse();
                    $transactionDetailCourse->transaction_detail_id = $model->id;
                    $transactionDetailCourse->course_id = $productCourse->course->id;
                    $transactionDetailCourse->course_title = $productCourse->course->title;
                    $transactionDetailCourse->course_description = $productCourse->course->description;
                    $transactionDetailCourse->course_about = $productCourse->course->about;
                    $transactionDetailCourse->course_url_image = $productCourse->course->url_image;
                    $transactionDetailCourse->course_url_icon = $productCourse->course->url_icon;
                    $transactionDetailCourse->course_url_video = $productCourse->course->url_video;
                    $transactionDetailCourse->course_price = $productCourse->course->price;
                    $transactionDetailCourse->course_price_before_discount = $productCourse->course->price_before_discount;
                    $transactionDetailCourse->save();
                }
                $productOfflineCourses = $model->product->productOfflineCourses;
                foreach ($productOfflineCourses as $productOfflineCourseIndex => $productOfflineCourse) {
                    $transactionDetailOfflineCourse = new TransactionDetailOfflineCourse();
                    $transactionDetailOfflineCourse->transaction_detail_id = $model->id;
                    $transactionDetailOfflineCourse->offline_course_id = $productOfflineCourse->offlineCourse->id;
                    $transactionDetailOfflineCourse->offline_course_title = $productOfflineCourse->offlineCourse->title;
                    $transactionDetailOfflineCourse->offline_course_description = $productOfflineCourse->offlineCourse->description;
                    $transactionDetailOfflineCourse->offline_course_content = $productOfflineCourse->offlineCourse->content;
                    $transactionDetailOfflineCourse->offline_course_quota = $productOfflineCourse->offlineCourse->quota;
                    $transactionDetailOfflineCourse->offline_course_date_time_start = $productOfflineCourse->offlineCourse->date_time_start;
                    $transactionDetailOfflineCourse->offline_course_date_time_end = $productOfflineCourse->offlineCourse->date_time_end;
                    $transactionDetailOfflineCourse->offline_url_online_meet = $productOfflineCourse->offlineCourse->url_online_meet;
                    $transactionDetailOfflineCourse->offline_course_price = $productOfflineCourse->offlineCourse->price;
                    $transactionDetailOfflineCourse->offline_course_price_before_discount = $productOfflineCourse->offlineCourse->price_before_discount;
                    $transactionDetailOfflineCourse->save();
                }
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(TransactionDetailCourse::class, 'transaction_detail_id', 'id');
    }

    public function offlineCourses()
    {
        return $this->hasMany(TransactionDetailOfflineCourse::class, 'transaction_detail_id', 'id');
    }
}
