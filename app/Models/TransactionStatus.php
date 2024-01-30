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

            if($model->name  === self::STATUS_DONE) {
                $transactionDetails = $model->transaction->transactionDetails;
                foreach ($transactionDetails as $transactionDetailIndex => $transactionDetail) {
                    if($transactionDetail->product_remarks_type === Course::class){
                        $productCourses = $transactionDetail->product->productCourses;
                        foreach ($productCourses as $productCourseIndex => $productCourse) {
                            $transactionDetailCourse = new TransactionDetailCourse();
                            $transactionDetailCourse->transaction_detail_id = $transactionDetail->id;
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
                    }else if($transactionDetail->product_remarks_type === OfflineCourse::class) {
                        $productOfflineCourses = $transactionDetail->product->productOfflineCourses;
                        foreach ($productOfflineCourses as $productOfflineCourseIndex => $productOfflineCourse) {
                            $transactionDetailOfflineCourse = new TransactionDetailOfflineCourse();
                            $transactionDetailOfflineCourse->transaction_detail_id = $transactionDetail->id;
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
                        $productCourses = $transactionDetail->product->productCourses;
                        foreach ($productCourses as $productCourseIndex => $productCourse) {
                            $transactionDetailCourse = new TransactionDetailCourse();
                            $transactionDetailCourse->transaction_detail_id = $transactionDetail->id;
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
                        $productOfflineCourses = $transactionDetail->product->productOfflineCourses;
                        foreach ($productOfflineCourses as $productOfflineCourseIndex => $productOfflineCourse) {
                            $transactionDetailOfflineCourse = new TransactionDetailOfflineCourse();
                            $transactionDetailOfflineCourse->transaction_detail_id = $transactionDetail->id;
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
                }
            }
        });
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

        return "<div class='badge badge-$class' style='font-size:15px;'>$this->name</div>";
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
